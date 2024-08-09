import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/sass/frontend.scss',
                'resources/js/app.js',
                'resources/sass/pos.scss',
                'resources/js/pos.js',
                'resources/js/front.js'
            ],
            refresh: true,
        }),
    ],
});
