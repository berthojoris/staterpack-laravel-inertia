import { NewsItem, PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

export default function NewsShow({
    news,
}: PageProps<{ news: NewsItem & { content: string } }>) {
    return (
        <>
            <Head title={news.title} />

            <div className="min-h-screen bg-gray-100 text-gray-900">
                <header className="border-b border-gray-200 bg-white">
                    <div className="mx-auto flex max-w-3xl items-center justify-between px-6 py-4">
                        <Link
                            href={route('news.index')}
                            className="text-lg font-semibold text-gray-900"
                        >
                            Blog Laravel
                        </Link>
                    </div>
                </header>

                <main className="mx-auto max-w-3xl px-6 py-10">
                    <Link
                        href={route('news.index')}
                        className="text-sm text-gray-600 transition hover:text-gray-900"
                    >
                        &larr; Kembali ke daftar berita
                    </Link>

                    <article className="mt-6 overflow-hidden rounded-lg border border-gray-200 bg-white">
                        <img
                            src={news.image_url}
                            alt={news.title}
                            className="h-64 w-full object-cover sm:h-80"
                        />

                        <div className="p-6 sm:p-8">
                            <p className="text-xs font-medium tracking-wide text-gray-500 uppercase">
                                {formatDate(news.published_at)}
                            </p>

                            <h1 className="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                                {news.title}
                            </h1>

                            <p className="mt-3 text-sm text-gray-500">
                                Oleh {news.author}
                            </p>

                            <div className="mt-6 space-y-4 text-base leading-relaxed text-gray-700">
                                {news.content
                                    .split('\n\n')
                                    .map((paragraph, index) => (
                                        <p key={index}>{paragraph}</p>
                                    ))}
                            </div>
                        </div>
                    </article>
                </main>
            </div>
        </>
    );
}

function formatDate(iso: string): string {
    return new Date(iso).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}
