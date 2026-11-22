<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * Home page: daftar berita terbaru.
     */
    public function index()
    {
        return Inertia::render('News/Index', [
            'news' => Inertia::defer(
                fn () => News::query()
                    ->orderByDesc('published_at')
                    ->get(['id', 'title', 'slug', 'excerpt', 'author', 'image_url', 'published_at'])
            ),
        ]);
    }

    /**
     * Detail berita berdasarkan slug.
     */
    public function show(News $news)
    {
        return Inertia::render('News/Show', [
            'news' => $news->only(['id', 'title', 'slug', 'excerpt', 'content', 'author', 'image_url', 'published_at']),
        ]);
    }
}
