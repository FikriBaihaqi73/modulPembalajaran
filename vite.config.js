import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        cors: true,
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js', 'resources/js/mentor.jsx', 'resources/js/components/TiptapEditor.jsx', 'resources/js/components/Chatbot.jsx'],
            refresh: true,
        }),
    ],
});
