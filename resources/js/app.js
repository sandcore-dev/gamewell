import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { i18nVue } from 'laravel-vue-i18n';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({
        el, App, props, plugin,
    }) {
        createApp({ render: () => h(App, props) })
            .use(i18nVue, {
                resolve: async (lang) => {
                    const languages = import.meta.glob('../lang/*.json');
                    return languages[`../lang/${lang}.json`]();
                },
            })
            .use(plugin)
            .mount(el);
    },
});
