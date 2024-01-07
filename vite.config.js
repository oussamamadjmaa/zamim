import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/vue_web_assets/sass/style.scss',
                'resources/vue_web_assets/js/app.js',
                'resources/vue_web_assets/js/scripts.js',
                'resources/vue_backend_assets/sass/style.scss',
                'resources/vue_backend_assets/js/app.js',
                'resources/vue_backend_assets/js/app_admin.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: tag => tag.startsWith('ion-icon'),
                },
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
