import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import DataTablesLib from 'datatables.net-dt'
import DataTable from 'datatables.net-vue3'

DataTable.use(DataTablesLib)

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>([
            './pages/**/*.vue',
            '../../Modules/**/resources/js/pages/**/*.vue',
        ]);

        let path = `./pages/${name}.vue`;

        if (!pages[path]) {
            // Support "Module::Page" syntax or fallback to finding file by name
            const matchingPath = Object.keys(pages).find((p) => {
                if (name.includes('::')) {
                    const [module, component] = name.split('::');
                    return p.includes(`/${module}/`) && p.endsWith(`/${component}.vue`);
                }
                return p.endsWith(`/${name}.vue`);
            });

            if (matchingPath) {
                path = matchingPath;
            }
        }

        return resolvePageComponent(path, pages);
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('DataTable', DataTable)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
