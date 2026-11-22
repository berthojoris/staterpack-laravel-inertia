export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface NewsItem {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    content?: string;
    author: string;
    image_url: string;
    published_at: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

export type PublicPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User | null;
    };
};
