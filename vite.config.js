import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/custom.js',
                'resources/js/main.js',
                'resources/js/pj-js/images.js',
                'resources/js/pj-js/suffix.js',
            ],
            refresh: true,
        }),
    ],
    order: [
        'jquery',
        'app',
        'projects'
    ]
});
