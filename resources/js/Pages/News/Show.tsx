import PublicLayout from '@/Layouts/PublicLayout';
import { formatDate } from '@/lib/format-date';
import { NewsItem, PublicPageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

export default function NewsShow({
    auth,
    news,
}: PublicPageProps<{ news: NewsItem & { content: string } }>) {
    return (
        <PublicLayout user={auth.user}>
            <Head title={news.title} />

            <div className="mx-auto max-w-3xl px-6 py-10">
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
                        width={800}
                        height={450}
                        fetchPriority="high"
                        className="h-64 w-full object-cover sm:h-80"
                        decoding="async"
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
            </div>
        </PublicLayout>
    );
}
