import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { route as routeFn } from 'ziggy-js';
import { initializeTheme } from './hooks/use-appearance';

declare global {
    const route: typeof routeFn;
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const appPages = import.meta.glob('./pages/**/*.tsx');
        const modulePages = import.meta.glob('../../Modules/**/resources/js/pages/**/*.tsx');
        const moduleNames: Record<string, string> = { Buku: 'Buku', Peminjaman: 'Peminjaman', UserManagement: 'UserManagement' };
        if (name.includes('/')) {
            const [module, ...page] = name.split('/');
            if (moduleNames[module]) {
                return resolvePageComponent(`../../Modules/${moduleNames[module]}/resources/js/pages/${page.join('/')}.tsx`, modulePages);
            }
        }
        return resolvePageComponent(`./pages/${name}.tsx`, appPages);
    },
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();

