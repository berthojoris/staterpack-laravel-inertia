import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { fontsource } from 'laravel-vite-plugin/fonts';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.tsx',
            refresh: true,
            fonts: [
                fontsource('Figtree', {
                    weights: [400, 500, 600, 700],
                    subsets: ['latin'],
                    display: 'swap',
                    optimizedFallbacks: false,
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                }),
            ],
        }),
        react(),
        tailwindcss(),
    ],
});
