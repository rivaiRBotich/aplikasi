import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST, // <-- Kita kunci mati ke IP localhost agar instan terhubung
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: 443,
    forceTLS: true,     // <-- Wajib false karena di localhost kita menggunakan HTTP biasa, bukan HTTPS
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth', // ← WAJIB ADA
});