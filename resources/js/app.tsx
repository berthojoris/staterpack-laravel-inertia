import '../css/app.css';

import type { ResolvedComponent } from '@inertiajs/react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Eager: semua page ikut bundle app.tsx sehingga navigasi antar halaman
// tidak menunggu unduhan/transform chunk page (terasa terutama di dev).
const pages = import.meta.glob<{ default: ResolvedComponent }>(
    './Pages/**/*.tsx',
    {
        eager: true,
    },
);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => pages[`./Pages/${name}.tsx`].default,
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
        delay: 250,
    },
});
