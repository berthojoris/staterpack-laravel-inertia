<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Data berita dummy untuk demo blog di home page.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Laravel 13 Rilis dengan Fokus AI-Native Workflow',
                'slug' => 'laravel-13-rilis-fokus-ai-native',
                'excerpt' => 'Laravel 13 hadir dengan primitive AI pihak pertama, JSON:API resources, dan semantic search. Upgrade dari Laravel 12 relatif minor.',
                'content' => "Laravel 13 melanjutkan ritme rilis tahunan dengan fokus pada AI-native workflow, default yang lebih aman, dan API yang lebih ekspresif. Rilis utama kali ini menyertakan primitive AI pihak pertama, JSON:API resources, hingga kemampuan semantic atau vector search.\n\nDari sisi breaking change, tim Laravel sengaja meminimalkannya. Sebagian besar aplikasi bisa naik versi tanpa banyak mengubah kode. Minimum PHP yang disyaratkan naik menjadi 8.3.\n\nBeberapa hal baru yang menonjol: konfigurasi session kini default memakai serialisasi JSON untuk mencegah serangan deserialization, cache mendapat opsi serializable_classes, dan middleware CSRF berganti nama menjadi PreventRequestForgery dengan verifikasi origin berbasis header Sec-Fetch-Site.",
                'author' => 'Redaksi Teknologi',
                'image_url' => 'https://picsum.photos/seed/laravel13/800/450',
                'published_at' => '2026-11-18 09:00:00',
            ],
            [
                'title' => 'Inertia.js v3 Resmi Stabil, Banyak Fitur Baru untuk SPA',
                'slug' => 'inertiajs-v3-resmi-stabil',
                'excerpt' => 'Deferred props, merge props, hingga polling murah kini jadi fitur inti Inertia v3. React 19 didukung penuh.',
                'content' => "Inertia.js v3 akhirnya mencapai versi stabil. Adapter React kini mendukung React 19 secara penuh di samping Vue 3 dan Svelte.\n\nFitur yang sebelumnya eksperimental kini matang: deferred props untuk data berat, merge props untuk koleksi yang di-append, komponen WhenVisible dan InfiniteScroll untuk lazy loading, konvensi partial reload dengan only:, prefetching dengan cacheFor, polling murah via usePoll, hingga history encryption untuk halaman sensitif.\n\nBagi tim yang sudah memakai versi beta, jalur upgrade tergolong mulus. Dokumentasi resmi juga sudah diperbarui lengkap dengan contoh untuk tiap adapter.",
                'author' => 'Budi Santoso',
                'image_url' => 'https://picsum.photos/seed/inertiav3/800/450',
                'published_at' => '2026-11-16 14:30:00',
            ],
            [
                'title' => 'React 19 Perkuat Server Components dan Form Actions',
                'slug' => 'react-19-server-components-actions',
                'excerpt' => 'useActionState, useOptimistic, dan prerendering jadi sorotan utama React 19. Migrasi dari 18 terbilang lancar.',
                'content' => "React 19 menyempurnakan cerita server-side dengan dukungan penuh untuk Server Components dan Form Actions. Hook baru seperti useActionState dan useOptimistic membuat penanganan form dan feedback UI jadi lebih ringkas.\n\nDari sisi breaking change, prop-types untuk function component dihapus dan forwardRef tidak lagi diperlukan karena ref kini bisa diteruskan sebagai prop biasa.\n\nEkosistem tooling ikut menyesuaikan: Vite, Next.js, dan React Router sudah mendukung React 19 sejak rilis stabil.",
                'author' => 'Sari Wijaya',
                'image_url' => 'https://picsum.photos/seed/react19/800/450',
                'published_at' => '2026-11-12 10:15:00',
            ],
            [
                'title' => 'Tailwind CSS v4 Bawa Engine Baru dan Konfigurasi CSS-First',
                'slug' => 'tailwind-v4-engine-css-first',
                'excerpt' => 'Tidak ada lagi tailwind.config.js. Token desain kini hidup langsung di CSS lewat @theme, dengan engine Oxide yang jauh lebih cepat.',
                'content' => "Tailwind CSS v4 memperkenalkan engine baru bernama Oxide yang diklaim hingga 10x lebih cepat untuk full build dan lebih dari 100x untuk incremental build.\n\nPerubahan terbesar ada pada konfigurasi: file tailwind.config.js tidak lagi dibutuhkan. Semua token desain didefinisikan langsung di CSS lewat directive @theme, dan deteksi konten otomatis tanpa daftar content manual.\n\nUpgrade dari v3 disediakan tool migrasi otomatis yang menangani sebagian besar perubahan kelas dan konfigurasi.",
                'author' => 'Andi Pratama',
                'image_url' => 'https://picsum.photos/seed/tailwind4/800/450',
                'published_at' => '2026-11-10 08:45:00',
            ],
            [
                'title' => 'PHP 8.5 Naikkan Performa dengan Pipe Operator',
                'slug' => 'php-85-pipe-operator',
                'excerpt' => 'Pipe operator, property access di destructuring, dan peningkatan extension dom headline rilis PHP 8.5.',
                'content' => "PHP 8.5 melanjutkan modernisasi bahasa dengan syntax pipe operator yang membuat rantai transformasi data lebih mudah dibaca.\n\nRilis ini juga menambahkan property access di list destructuring, penanda #[\NoDiscard] untuk fungsi yang hasilnya wajib dipakai, dan grafik call-site independency untuk extension lebih presisi.\n\nBenchmark awal menunjukkan peningkatan performa kecil namun konsisten pada aplikasi web dibanding PHP 8.4.",
                'author' => 'Redaksi Teknologi',
                'image_url' => 'https://picsum.photos/seed/php85/800/450',
                'published_at' => '2026-11-06 16:20:00',
            ],
            [
                'title' => 'SQLite Makin Layak untuk Production Web Modern',
                'slug' => 'sqlite-production-web-modern',
                'excerpt' => 'Mode WAL, litestream untuk backup, dan turunnya biaya VPS membuat database embedded ini kembali populer.',
                'content' => "SQLite sudah lama jadi pilihan utama untuk mobile dan embedded, tapi kini semakin banyak aplikasi web production yang memakainya.\n\nMode WAL (Write-Ahead Logging) memungkinkan pembacaan dan penulisan berjalan paralel tanpa blocking. Ditambah Litestream untuk replikasi dan backup berkelanjutan ke S3, SQLite jadi opsi yang sangat hemat untuk aplikasi dengan traffic menengah.\n\nLaravel bahkan menjadikan SQLite sebagai default sejak beberapa versi terakhir, dan dukungan tooling-nya terus membaik.",
                'author' => 'Dina Lestari',
                'image_url' => 'https://picsum.photos/seed/sqlitemodern/800/450',
                'published_at' => '2026-11-03 11:00:00',
            ],
            [
                'title' => 'Vite 8 Fokus pada Startup yang Lebih Cepat',
                'slug' => 'vite-8-startup-lebih-cepat',
                'excerpt' => 'Rilis besar Vite 8 memangkas waktu dev server startup dengan caching modul yang lebih agresif.',
                'content' => "Vite 8 membawa perbaikan besar pada kecepatan startup dev server, terutama untuk project besar dengan ribuan modul.\n\nCaching dependensi pre-bundled kini persisten antar sesi dan invalidasi-nya lebih pintar. Output rollup juga di-update ke versi terbaru untuk build produksi yang lebih ramping.\n\nPlugin populer seperti @vitejs/plugin-react, laravel-vite-plugin, dan @tailwindcss/vite sudah mendukung Vite 8 sejak hari rilis.",
                'author' => 'Rizky Hidayat',
                'image_url' => 'https://picsum.photos/seed/vite8/800/450',
                'published_at' => '2026-10-28 13:40:00',
            ],
            [
                'title' => 'Ziggy 2: Route Laravel Langsung dari JavaScript',
                'slug' => 'ziggy-2-route-laravel-dari-js',
                'excerpt' => 'Tidak perlu lagi hardcode URL di frontend. Ziggy menyuntikkan daftar route Laravel ke komponen JS dengan type-safe.',
                'content' => "Ziggy mempermudah SPA yang dibangun di atas Laravel dengan cara menyediakan helper route() di sisi JavaScript yang identik dengan PHP.\n\nVersi 2.x menyuntikkan daftar route lewat directive @routes atau middleware, lengkap dengan definisi tipe untuk TypeScript lewat ziggy:generate. Nama route, parameter, dan query string semua tervalidasi saat compile time.\n\nKombinasi Ziggy dan Inertia membuat seluruh navigasi aplikasi konsisten antara backend dan frontend.",
                'author' => 'Budi Santoso',
                'image_url' => 'https://picsum.photos/seed/ziggy2/800/450',
                'published_at' => '2026-10-24 09:30:00',
            ],
            [
                'title' => 'Pest 4 Jadikan Testing PHP Lebih Ekspresif',
                'slug' => 'pest-4-testing-php-ekspresif',
                'excerpt' => 'Higher-order tests, architecture testing, dan mutation testing jadi andalan Pest 4 di atas PHPUnit 12.',
                'content' => "Pest 4 berdiri di atas PHPUnit 12 dengan API yang jauh lebih ringkas. Test bisa ditulis tanpa class boilerplate dan tetap kompatibel penuh dengan ekosistem PHPUnit.\n\nPlugin arch memungkinkan pengujian arsitektur (misalnya melarang model mengakses controller), sementara plugin mutate mengukur kualitas test lewat mutation testing.\n\nLaravel 13 dan Breeze kini menyediakan stub Pest sebagai default saat generate scaffolding baru.",
                'author' => 'Sari Wijaya',
                'image_url' => 'https://picsum.photos/seed/pest4/800/450',
                'published_at' => '2026-10-20 15:55:00',
            ],
            [
                'title' => 'TypeScript 5.9 Perkuat Inference untuk Generics',
                'slug' => 'typescript-59-inference-generics',
                'excerpt' => 'Peningkatan inference generic dan kompatibilitas tooling jadi fokus minor release TypeScript terbaru.',
                'content' => "TypeScript 5.9 menyempurnakan inference untuk generic kompleks dan memperkecil jumlah anotasi manual yang harus ditulis developer sehari-hari.\n\nPerbaikan juga tersedia untuk project references dan watch mode yang kini lebih responsif terhadap perubahan konfigurasi.\n\nKomunitas menanti versi mayor berikutnya yang menjanjikan port compiler ke bahasa Go untuk kecepatan build yang jauh lebih tinggi.",
                'author' => 'Andi Pratama',
                'image_url' => 'https://picsum.photos/seed/ts59/800/450',
                'published_at' => '2026-10-15 17:10:00',
            ],
        ];

        foreach ($articles as $article) {
            News::create($article);
        }
    }
}
