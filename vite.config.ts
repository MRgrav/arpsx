import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
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
    ],
    build: {
        chunkSizeWarningLimit: 1000,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        // Isolate the heavy PDF.js package
                        if (id.includes('@tato30') || id.includes('pdfjs-dist')) {
                            return 'vendor-pdfjs';
                        }
                        // Isolate Lucide icons package
                        if (id.includes('lucide-vue-next')) {
                            return 'vendor-icons';
                        }
                        // Standard vendor chunk for other npm packages
                        return 'vendor';
                    }
                },
            },
        },
    },
});

