import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    server: {
        // コンテナ内のすべてのネットワークインターフェースで待機する
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            // ブラウザにはlocalhostとして接続先を伝える
            host: 'localhost',
        },
    },
});
