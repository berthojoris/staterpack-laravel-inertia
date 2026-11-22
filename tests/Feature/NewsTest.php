<?php

use App\Models\News;

test('home page menampilkan halaman daftar berita', function () {
    $response = $this->get(route('news.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('News/Index'));
});

test('daftar berita dimuat sebagai deferred prop', function () {
    News::factory()->count(3)->create();

    $response = $this->get(route('news.index'));

    // prop deferred tidak ikut payload awal; client memuatnya lewat partial reload
    $response->assertInertia(
        fn ($page) => $page
            ->component('News/Index')
            ->missing('news')
    );
});

test('halaman pertama memuat 6 berita untuk infinite scroll', function () {
    News::factory()->count(8)->create();

    $response = $this->get(route('news.index'));

    $response->assertInertia(function ($page) {
        $page->component('News/Index')->missing('news');

        // partial reload yang sama seperti yang dikirim komponen <Deferred>
        $page->loadDeferredProps('default', function ($page) {
            $page
                ->has('news.data', 6)
                ->where('news.current_page', 1)
                ->where('news.per_page', 6);
        });
    });
});

test('halaman kedua berisi sisa berita', function () {
    News::factory()->count(8)->create();

    $response = $this->get(route('news.index', ['page' => 2]));

    $response->assertInertia(function ($page) {
        $page->component('News/Index')->missing('news');

        $page->loadDeferredProps('default', function ($page) {
            $page
                ->has('news.data', 2)
                ->where('news.current_page', 2);
        });
    });
});

test('detail berita bisa diakses lewat slug', function () {
    $news = News::factory()->create([
        'title' => 'Judul Berita Uji Coba',
        'slug' => 'judul-berita-uji-coba',
    ]);

    $response = $this->get(route('news.show', $news));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('News/Show')
        ->where('news.slug', 'judul-berita-uji-coba')
        ->where('news.title', 'Judul Berita Uji Coba'));
    $response->assertSee('Judul Berita Uji Coba');
});

test('detail berita yang tidak ada menghasilkan 404', function () {
    $this->get(route('news.show', 'tidak-ada'))->assertNotFound();
});
