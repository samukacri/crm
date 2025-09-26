import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'packages/Webkul/Admin/src/Resources/assets/js/app.js',
                'packages/Webkul/Admin/src/Resources/assets/css/app.css',
                'packages/Webkul/Admin/src/Resources/assets/images/logo.svg',
                'packages/Webkul/Admin/src/Resources/assets/images/favicon.ico',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/admin/build',
        assetsDir: 'assets',
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'assets/[name]-[hash][extname]';
                    }
                    if (assetInfo.name.endsWith('.svg')) {
                        return 'assets/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
