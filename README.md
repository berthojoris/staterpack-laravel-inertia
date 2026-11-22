# Starterpack Laravel 13 + Inertia.js (React)

Base project siap-clone untuk memulai aplikasi Laravel 13 dengan frontend SPA Inertia.js v3 + React 19 + TypeScript, lengkap dengan scaffolding autentikasi (login, register, lupa password, verifikasi email), Tailwind CSS v4, Pest, ESLint, dan Prettier.

## Tech Stack

| Layer | Teknologi |
| --- | --- |
| Backend | Laravel 13 (PHP >= 8.3) |
| Frontend | Inertia.js v3 + React 19 + TypeScript 5.9 |
| Styling | Tailwind CSS v4 (CSS-first) |
| Build | Vite 8 |
| Router helper | Ziggy 2 (`route()` di TSX) |
| Auth | Laravel Breeze (session-based, sanctum terpasang) |
| Testing | Pest 4 |
| Lint / Format | ESLint 8 + Prettier 3 |

## Requirements

- PHP >= 8.3 (dengan ekstensi standar Laravel)
- Composer 2
- Node.js >= 20 (direkomendasikan 22+)
- Database default: SQLite — bisa diganti MySQL/PostgreSQL lewat `.env`

## Cara Pakai untuk Project Baru

### 1. Clone dan install dependencies

```bash
git clone https://github.com/berthojoris/staterpack-laravel-inertia.git project-baru
cd project-baru

# hapus keterikatan git lama, init repo baru untuk project kamu
rm -rf .git
git init
```

```bash
composer install
npm install
```

### 2. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan `.env` bila perlu (nama app, database, dll):

```env
APP_NAME="Project Baru"
DB_CONNECTION=sqlite       # default; ganti ke mysql/pgsql jika perlu
```

### 3. Migrate dan build

```bash
php artisan migrate
npm run build
```

### 4. Jalankan development server

```bash
composer dev
```

Perintah ini menjalankan sekaligus: `php artisan serve`, queue listener, log tail (`pail`), dan Vite dev server dengan HMR. Buka `http://localhost:8000`.

Atau jalankan manual satu per satu:

```bash
php artisan serve   # backend
npm run dev         # vite HMR
```

## Perintah Penting

| Perintah | Fungsi |
| --- | --- |
| `composer dev` | server + queue + log + vite sekaligus |
| `npm run dev` | Vite dev server (HMR) saja |
| `npm run build` | type-check (`tsc`) + build produksi |
| `npm run lint` | ESLint + auto-fix untuk `resources/js` |
| `php artisan test` | jalankan test suite (Pest) |

## Struktur Frontend

```
resources/js/
├── Pages/          → halaman Inertia (Welcome, Dashboard, Auth/, Profile/)
├── Layouts/       → AuthenticatedLayout, GuestLayout
├── Components/    → komponen reusable (TextInput, PrimaryButton, dll.)
├── types/         → definisi PageProps & global route()
└── app.tsx         → bootstrap createInertiaApp
```

Halaman baru: buat file di `resources/js/Pages/` lalu render dari route:

```php
Route::get('/users', fn () => Inertia::render('Users/Index'))->name('users.index');
```

Navigasi di sisi React selalu via `<Link href={route('users.index')}>` — bukan `<a href>`.

## Konvensi Pengembangan

Panduan lengkap untuk AI agent dan kontributor ada di [AGENTS.md](AGENTS.md) — mencakup aturan Inertia v3 (deferred props, partial reload, merge props, prefetch, history encryption), konvensi naming, testing, dan checklist sebelum selesai.

## Lisensi

MIT
