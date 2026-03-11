import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import '../css/my.css'
import { initializeTheme } from './composables/useAppearance'

// FIXED PATH
import setupI18n from './i18n'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),

    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),

    setup({ el, App, props, plugin }) {

        // locale from backend or default
        const initialLocale = props.initialPage.props.locale || 'en'

        // create i18n instance
        const i18n = setupI18n(initialLocale)

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .mount(el)
    },

    progress: {
        color: '#4B5563',
    },
})

initializeTheme()