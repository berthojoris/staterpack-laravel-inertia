# AGENTS.md — Starterpack Laravel 13 + Inertia.js (React)

Panduan pengembangan untuk AI agent dan kontributor. Semua aturan di bawah mencerminkan konvensi yang sudah ada di repo ini — jangan menyeragamkan dengan konvensi luar.

## Tech Stack

| Layer | Teknologi | Versi |
| --- | --- | --- |
| Backend | Laravel | 13.x (PHP >= 8.3) |
| Server adapter | inertiajs/inertia-laravel | ^3.7 |
| Client adapter | @inertiajs/react (Inertia v3) | ^3.11 |
| UI | React | ^19.3 |
| Bahasa frontend | TypeScript (strict) | ^5.9 |
| Styling | Tailwind CSS v4 (CSS-first, tanpa `tailwind.config.js`) | ^4.3 |
| Build | Vite 8 + laravel-vite-plugin 3 + @vitejs/plugin-react | — |
| Router helper | Ziggy 2 (`route()` global via directive `@routes`) | ^2.7 |
| Test backend | Pest | ^4.7 |
| Lint/format | ESLint 8 + Prettier 3 (+ plugin tailwindcss & organize-imports) | — |
| Database | SQLite (default, mudah diganti via `DB_CONNECTION`) | — |

## Verifikasi API & Dokumentasi (WAJIB)

Selalu gunakan **MCP Context7** untuk mengecek API dan dokumentasi fitur terbaru Inertia.js dan Laravel sebelum menulis kode — jangan mengandalkan ingatan model yang bisa outdated:

- Library ID yang lazim: `inertiajs/inertia-laravel` (adapter Laravel), `inertiajs/inertia` (client core + adapter React), dan dokumentasi Laravel. Jika ID berubah, cari dulu lewat fitur pencarian library Context7.
- Query per satu topik spesifik (contoh: "deferred props in Laravel", "useForm persistence key"), bukan query generik seperti "inertia".
- Jika ragu signature persisnya, cross-check dua sumber: dokumentasi Context7 DAN kode yang terinstall (`vendor/inertiajs/inertia-laravel/src/` untuk API PHP, `node_modules/@inertiajs/react/types/` untuk API React). Yang terinstall adalah kebenaran final.
- Berlaku untuk API baru maupun lama — nama metode bisa berubah antar versi mayor (contoh: `Inertia::defer()`, bukan `deferred()`).

## Architecture

```
routes/web.php, routes/auth.php     → definisi route + props per halaman
app/Http/Controllers/              → controller (Auth, Profile)
app/Http/Middleware/HandleInertiaRequests.php → shared props (auth.user)
app/Http/Requests/                 → validasi FormRequest
resources/js/Pages/                → halaman Inertia (PascalCase, 1 file = 1 page component)
resources/js/Layouts/              → AuthenticatedLayout, GuestLayout
resources/js/Components/           → komponen reusable (InputLabel, TextInput, dll.)
resources/js/types/                → PageProps & global.d.ts (route, PageProps merging)
resources/views/app.blade.php     → root view: @routes, @vite, @inertia
```

Alur data: **Route/Controller → `Inertia::render('Page', [...props])` → React page menerima props sebagai parameter komponen**. Semua state server hidup di props; client tidak pernah fetching sendiri dengan axios/fetch.

## Backend

- Halaman dirender via `Inertia::render('NamaPage', $props)`; route WAJIB punya nama (`->name('users.index')`) agar bisa dipanggil `route()` dari client.
- Auth memakai session web middleware (Breeze). Prop `auth.user` di-share otomatis lewat `HandleInertiaRequests::share()`.
- Validasi tetap di server (FormRequest / `validate()`); error otomatis mengalir ke `form.errors` di client.
- Redirect setelah mutasi cukup standar Laravel — Inertia yang mengubahnya jadi visit.
- Flash message: satu channel saja — `Inertia::flash('toast', 'Pesan')` → ditangkap handler toast global di client (belum ada; tambahkan di `app.tsx` saat pertama kali dibutuhkan, jangan per-page).

## Frontend

- Semua file `.tsx`; tidak ada `.jsx`/`.js` untuk UI. Strict TypeScript, build akan gagal bila ada error (`npm run build` menjalankan `tsc` dulu).
- Navigasi & submit SELALU via Inertia: `<Link>`, `router.*`, `<Form>` (lihat aturan Inertia di bawah). Axios tidak diinstall dan tidak boleh ditambahkan untuk visit/form — gunakan `useHttp` untuk kebutuhan HTTP non-visit.
- Styling: Tailwind v4 via `resources/css/app.css` (`@import 'tailwindcss'`, `@theme` untuk token kustom). Tidak ada `tailwind.config.js` / `postcss.config.js` — jangan membuatnya.
- Icon: belum ada library icon; gunakan SVG inline atau tambahkan package bila disepakati.
- State lokal React biasa (`useState`) hanya untuk UI murni; data server = props Inertia, tidak dicopy ke state.
- Layout persisten via prop `layout` per page (pola Breeze): `Page.layout = (page) => <AuthenticatedLayout ...>{page}</AuthenticatedLayout>`.

## Inertia.js Rules

Aturan inti (berlaku untuk semua task):

- HTTP client bawaan Inertia — dilarang `axios`/`fetch` untuk visit & form. Pakai `<Link>`, `router.get/post/patch/put/delete`, atau `<Form>`.
- Pilihan form: `<Form>` untuk form statis standar; `useForm` untuk form dinamis, upload, dan multi-step.
- Upload file: tampilkan `form.progress.percentage` — jangan pasang listener XHR progress terpisah.
- Feedback tombol saat server bekerja: spinner + `disabled` + `aria-busy` — wajib di setiap tombol submit.
- CSR by default. Jangan aktifkan SSR kecuali diminta eksplisit.
- Request yang tergantikan otomatis cancel oleh visit baru — jangan tulis race guard manual; `router.cancel()` hanya untuk kasus khusus (mis. search-as-you-type di luar partial reload).

### 1. Deferred props (wajib untuk data berat)

Prop yang butuh query DB atau memperlambat first paint HARUS di-defer:

```php
Inertia::render('Users/Index', [
    'users' => Inertia::defer(fn () => User::paginate()),
]);
```

```tsx
<Deferred data="users" fallback={<UsersSkeleton />}>
    <UsersTable users={users} />
</Deferred>
```

### 2. Merge props (koleksi yang di-append)

Daftar panjang (infinite scroll, riwayat chat) di-merge, bukan replace:

```php
'users' => Inertia::merge(fn () => UserResource::collection($users)),
```

### 3. Lazy load di bawah lipatan layar

Data off-screen: `<WhenVisible data="comments" fallback={...}>`. Daftar panjang: `<InfiniteScroll data="items" loading={...}>`. Dilarang IntersectionObserver manual.

### 4. Konvensi filter/search

Filter, search, dan pagination adalah partial reload — jangan reload seluruh halaman:

```ts
router.get(route('users.index'), { search }, {
    only: ['users'],
    preserveState: true,
    replace: true,
})
```

### 5. useForm dengan persistence key

Form non-trivial WAJIB punya remember key agar state selamat saat navigasi:

```ts
const form = useForm('CreateUser', { name: '', email: '' })
const form = useForm(`EditUser:${user.id}`, user)
```

Field sensitif (password) di-exclude dengan `dontRemember()`.

### 6. Prefetching

Tujuan yang mungkin diklik (tile dashboard, tab, halaman berikutnya): `<Link href={...} prefetch cacheFor="30s">`. Jangan prefetch semuanya.

### 7. History encryption

Halaman sensitif (billing, admin, PII) memanggil `Inertia::encryptHistory()` di controller (atau `history: { encrypt: true }` per visit). Halaman seperti ini juga tidak boleh `useRemember` datanya.

### 8. Polling murah

Dashboard auto-refresh tanpa websocket: `usePoll(5000, { only: ['stats'] })` — selalu pakai `only:`, biarkan auto-pause saat tab hidden.

## Naming

| Hal | Konvensi | Contoh |
| --- | --- | --- |
| Page component | PascalCase, cocok dengan argumen pertama `Inertia::render` | `Users/Index.tsx` ↔ `Inertia::render('Users/Index')` |
| Controller | Singular + `Controller` | `ProfileController` |
| Route name | `resource.aksi`, snake/camel sesuai Breeze | `profile.edit`, `verification.send` |
| Layout | PascalCase + `Layout` | `AuthenticatedLayout` |
| Component | PascalCase | `PrimaryButton.tsx` |
| Tipe props page | `PageProps` dari `@inertiajs/core` (sudah di-merge global dengan `Auth.User`) | `type Props = Inertia.PageProps` |
| Tabel DB | plural snake_case | `password_reset_tokens` |

## Testing & Tooling

```bash
composer test        # php artisan config:clear && php artisan test (Pest)
php artisan test     # sama
npm run build        # tsc && vite build — WAJIB lolos sebelum dianggap selesai
npm run lint         # ESLint + auto-fix pada resources/js
npm run dev          # vite dev server (HMR)
composer dev         # server + queue + pail + vite sekaligus
```

- Test backend: Pest di `tests/Feature` & `tests/Unit`; feature test memakai `actingAs()` + assertions respons Inertia.
- Frontend belum punya test runner; minimal verifikasi via `npm run build` + `npm run lint`.
- Perubahan styling harus dicek visualnya via `npm run dev`.

## Security

- Validasi selalu di server; jangan percaya data dari client meski sudah tipify di TS.
- Halaman sensitif: `Inertia::encryptHistory()` (lihat aturan Inertia #7).
- Jangan commit `.env`; regenerasi `APP_KEY` untuk setiap project turunan (`php artisan key:generate`).
- Session default sudah `serialization => json` dan cache `serializable_classes => false` (hardening Laravel 13) — jangan turunkan ke `php`/`true` tanpa alasan kuat.

## AI Agent Checklist (sebelum selesai)

- [ ] API Inertia/Laravel diverifikasi via MCP Context7 (dan/atau kode yang terinstall) sebelum dipakai
- [ ] `npm run build` lolos (tsc + vite, tanpa error)
- [ ] `php artisan test` lolos; test baru untuk fitur baru
- [ ] `npm run lint` bersih
- [ ] Tidak ada `axios` / `fetch` untuk visit atau form
- [ ] Prop berat di-defer; daftar panjang merge + InfiniteScroll; filter partial reload
- [ ] Form punya remember key; tombol submit ada loading state
- [ ] Route baru sudah `->name(...)` dan dipanggil via `route()`
- [ ] Halaman sensitif meng-encrypt history
