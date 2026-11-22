import PublicLayout from '@/Layouts/PublicLayout';
import { formatDate } from '@/lib/format-date';
import { NewsItem, PublicPageProps } from '@/types';
import { Deferred, Head, InfiniteScroll, Link } from '@inertiajs/react';

type NewsPage = {
    data: NewsItem[];
};

export default function NewsIndex({
    auth,
    news,
}: PublicPageProps<{ news?: NewsPage }>) {
    return (
        <PublicLayout user={auth.user}>
            <Head title="Berita Terbaru" />

            <div className="mx-auto max-w-5xl px-6 py-10">
                <h1 className="text-3xl font-bold text-gray-900">
                    Berita Terbaru
                </h1>
                <p className="mt-2 text-gray-600">
                    Kabar teknologi terkini seputar ekosistem Laravel dan web
                    development.
                </p>

                <Deferred data="news" fallback={<NewsSkeleton />}>
                    <InfiniteScroll data="news" loading={<NewsLoading />}>
                        <div className="mt-8 grid gap-6 sm:grid-cols-2">
                            {news?.data.map((item) => (
                                <Link
                                    key={item.id}
                                    href={route('news.show', item.slug)}
                                    prefetch
                                    cacheFor="30s"
                                    className="group overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300"
                                >
                                    <img
                                        src={item.image_url}
                                        alt={item.title}
                                        width={800}
                                        height={450}
                                        className="h-44 w-full object-cover transition group-hover:opacity-90"
                                        loading="lazy"
                                        decoding="async"
                                    />

                                    <div className="p-5">
                                        <p className="text-xs font-medium tracking-wide text-gray-500 uppercase">
                                            {formatDate(item.published_at)}
                                        </p>
                                        <h2 className="mt-2 text-lg font-semibold text-gray-900 group-hover:underline">
                                            {item.title}
                                        </h2>
                                        <p className="mt-2 line-clamp-3 text-sm text-gray-600">
                                            {item.excerpt}
                                        </p>
                                        <p className="mt-3 text-sm text-gray-500">
                                            Oleh {item.author}
                                        </p>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </InfiniteScroll>
                </Deferred>
            </div>
        </PublicLayout>
    );
}

function NewsSkeleton() {
    return (
        <div aria-busy="true" className="mt-8 grid gap-6 sm:grid-cols-2">
            {Array.from({ length: 4 }).map((_, index) => (
                <div
                    key={index}
                    className="overflow-hidden rounded-lg border border-gray-200 bg-white"
                >
                    <div className="h-44 w-full animate-pulse bg-gray-200" />
                    <div className="space-y-3 p-5">
                        <div className="h-3 w-24 animate-pulse rounded bg-gray-200" />
                        <div className="h-5 w-3/4 animate-pulse rounded bg-gray-200" />
                        <div className="h-3 w-full animate-pulse rounded bg-gray-200" />
                        <div className="h-3 w-2/3 animate-pulse rounded bg-gray-200" />
                    </div>
                </div>
            ))}
        </div>
    );
}

function NewsLoading() {
    return (
        <div className="flex justify-center py-6" aria-busy="true">
            <div className="h-3 w-24 animate-pulse rounded bg-gray-300" />
        </div>
    );
}
