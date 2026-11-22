import { NewsItem, PageProps } from '@/types';
import { Deferred, Head, Link } from '@inertiajs/react';

export default function NewsIndex({
    auth,
    news,
}: PageProps<{ news?: NewsItem[] }>) {
    return (
        <>
            <Head title="Berita Terbaru" />

            <div className="min-h-screen bg-gray-100 text-gray-900">
                <header className="border-b border-gray-200 bg-white">
                    <div className="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
                        <Link
                            href={route('news.index')}
                            className="text-lg font-semibold text-gray-900"
                        >
                            Blog Laravel
                        </Link>

                        <nav className="flex items-center gap-4 text-sm">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="rounded-md px-3 py-2 text-gray-600 transition hover:text-gray-900"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="rounded-md px-3 py-2 text-gray-600 transition hover:text-gray-900"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-md bg-gray-900 px-3 py-2 text-white transition hover:bg-gray-700"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </div>
                </header>

                <main className="mx-auto max-w-5xl px-6 py-10">
                    <h1 className="text-3xl font-bold text-gray-900">
                        Berita Terbaru
                    </h1>
                    <p className="mt-2 text-gray-600">
                        Kabar teknologi terkini seputar ekosistem Laravel dan
                        web development.
                    </p>

                    <Deferred data="news" fallback={<NewsSkeleton />}>
                        <div className="mt-8 grid gap-6 sm:grid-cols-2">
                            {news?.map((item) => (
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
                                        className="h-44 w-full object-cover transition group-hover:opacity-90"
                                        loading="lazy"
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
                    </Deferred>
                </main>
            </div>
        </>
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

function formatDate(iso: string): string {
    return new Date(iso).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}
