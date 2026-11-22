import { User } from '@/types';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function PublicLayout({
    user,
    children,
}: PropsWithChildren<{ user: User | null }>) {
    return (
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
                        {user ? (
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

            <main>{children}</main>
        </div>
    );
}
