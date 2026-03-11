import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
           // ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ],

    // ❌ REMOVE HTTPS — breaks Docker build
    server: {
        host: '0.0.0.0'
    },

    build: {
        manifest: true,
        outDir: 'public/build',
        assetsDir: 'assets'
    },

    define: {
        'import.meta.env.VITE_APP_URL': JSON.stringify('https://lizym.onrender.com')
    }
});
