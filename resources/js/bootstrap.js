import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: '127.0.0.1', // <-- Kita kunci mati ke IP localhost agar instan terhubung
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: true,     // <-- Wajib false karena di localhost kita menggunakan HTTP biasa, bukan HTTPS
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth', // ← WAJIB ADA
});