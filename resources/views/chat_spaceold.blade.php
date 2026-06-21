<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Chat Konsultasi - MBC Clinic</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/js/app.js']) {{-- Memuat aset kompilasi Vite & Echo JS --}}
</head>
<body class="bg-slate-100 text-slate-800 antialiased h-screen flex flex-col justify-between">

    <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shrink-0 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm uppercase">
                {{ substr($room->category, 0, 2) }}
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm capitalize">Layanan Live Chat Klinik {{ $room->category }}</h3>
                <p class="text-[11px] text-slate-400">
                    Dokter pendamping: <span class="font-semibold text-teal-600">{{ $room->doctor->name ?? 'Mencari Dokter Terdekat...' }}</span>
                </p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            @if(auth()->user()->role === 'doctor' && $room->status === 'active')
                <form action="{{ route('doctor.chat.end', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan sesi konsultasi medis ini?')">
                    @csrf
                    <button type="submit" class="text-xs bg-rose-600 hover:bg-rose-700 font-bold text-white px-4 py-2 rounded-xl transition shadow-md shadow-rose-600/10 cursor-pointer">
                        <i class="fa-solid fa-circle-xmark"></i> Akhiri Sesi
                    </button>
                </form>
            @endif

            <a href="{{ auth()->user()->role === 'doctor' ? route('doctor.dashboard') : route('dashboard') }}" class="text-xs bg-slate-100 hover:bg-slate-200 font-medium text-slate-600 px-4 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </header>

    <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50">
        @foreach($messages as $msg)
            @php $isMe = $msg->sender_id === $user->id; @endphp
            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] rounded-2xl px-4 py-2.5 shadow-sm text-sm {{ $isMe ? 'bg-teal-600 text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none border border-slate-100' }}">
                    <p class="text-[10px] opacity-60 font-bold mb-0.5">{{ $msg->sender->name }}</p>
                    <p class="leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-[9px] opacity-50 text-right mt-1">{{ $msg->created_at->format('H:i') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <footer class="bg-white border-t border-slate-200 p-4 shrink-0 shadow-lg">
        @if($room->status === 'closed')
            <div class="max-w-5xl mx-auto bg-slate-100 border border-slate-200 text-center py-3 rounded-xl text-xs text-slate-500 font-semibold tracking-wide">
                🔒 Sesi konsultasi telah berakhir. Silakan kembali ke Dashboard untuk memulai konsultasi baru.
            </div>
        @else
            <form id="chat-form" class="flex items-center space-x-3 max-w-5xl mx-auto">
                <input type="text" id="message-input" placeholder="Tulis keluhan atau jawaban medis Anda di sini..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl text-sm p-3 focus:outline-none focus:border-teal-500 transition" autocomplete="off" required>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white p-3 rounded-xl transition shadow-md shadow-teal-600/20 cursor-pointer">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </button>
            </form>
        @endif
    </footer>
<!-- 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.0/dist/echo.iife.js"></script> -->

    <!-- <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const currentUserId = {{ $user->id }};
        const roomId = {{ $room->id }};

        // Otomatis scroll box chat ke posisi paling bawah begitu halaman terbuka
        chatBox.scrollTop = chatBox.scrollHeight;

        // == INISIALISASI MURNI TANPA VITE COMPILER ==
        // == INISIALISASI CDN DENGAN AUTH HEADER MANUAL ==
        if (typeof LaravelEcho !== 'undefined') {
            window.Echo = new LaravelEcho({
                broadcaster: 'reverb',
                key: '{{ env("REVERB_APP_KEY") }}',
                wsHost: '127.0.0.1',
                wsPort: {{ env("REVERB_PORT", 8080) }},
                wssPort: {{ env("REVERB_PORT", 8080) }},
                forceTLS: false,
                enabledTransports: ['ws', 'wss'],
                // == TAMBAHKAN BERIKUT AGAR TIDAK NULL ==
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            });

            console.log('Mencoba menyambungkan Echo CDN ke channel private-chat.room.' + roomId);

            window.Echo.private(`chat.room.${roomId}`)
                .listen('.message.sent', (data) => {
                    console.log("Pesan masuk real-time via CDN:", data);
                    if (parseInt(data.message.sender_id) !== parseInt(currentUserId)) {
                        appendMessage(data.message);
                    }
                })
                .error((err) => {
                    console.error("Gagal otorisasi channel private:", err);
                });
        }

        // 2. Fungsi untuk Menempelkan Bubble Chat Baru ke Layar Monitor
        function appendMessage(msg) {
            const isMe = parseInt(msg.sender_id) === parseInt(currentUserId);
            const alignClass = isMe ? 'justify-end' : 'justify-start';
            const bubbleClass = isMe ? 'bg-teal-600 text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none border border-slate-100';
            
            const timeStr = new Date(msg.created_at).toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            }).replace('.', ':');

            let senderName = 'User';
            if (msg.sender) {
                senderName = msg.sender.name;
            } else {
                senderName = isMe ? "{{ $user->name }}" : "{{ auth()->user()->role === 'doctor' ? ($room->patient->name ?? 'Pasien') : ($room->doctor->name ?? 'Dokter') }}";
            }

            const messageHtml = `
                <div class="flex ${alignClass}">
                    <div class="max-w-[70%] rounded-2xl px-4 py-2.5 shadow-sm text-sm ${bubbleClass}">
                        <p class="text-[10px] opacity-60 font-bold mb-0.5">${senderName}</p>
                        <p class="leading-relaxed">${msg.message}</p>
                        <p class="text-[9px] opacity-50 text-right mt-1">${timeStr}</p>
                    </div>
                </div>
            `;

            chatBox.insertAdjacentHTML('beforeend', messageHtml);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // 3. Aksi Pengiriman Pesan Menggunakan AJAX (POST)
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = messageInput.value.trim();
                if (!text) return;

                messageInput.value = '';

                fetch(`/chat/room/${roomId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        appendMessage(data.message);
                    }
                })
                .catch(error => {
                    console.error('Gagal mengirim pesan:', error);
                });
            });
        }
    </script> -->

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const currentUserId = {{ $user->id }};
        const roomId = {{ $room->id }};

        // Auto scroll ke bawah saat halaman dibuka
        chatBox.scrollTop = chatBox.scrollHeight;

        // Fungsi append bubble chat
        function appendMessage(msg) {
            const isMe = parseInt(msg.sender_id) === parseInt(currentUserId);
            const alignClass = isMe ? 'justify-end' : 'justify-start';
            const bubbleClass = isMe ? 'bg-teal-600 text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none border border-slate-100';
            
            const timeStr = new Date(msg.created_at).toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            }).replace('.', ':');

            let senderName = 'User';
            if (msg.sender) {
                senderName = msg.sender.name;
            } else {
                senderName = isMe ? "{{ $user->name }}" : "{{ auth()->user()->role === 'doctor' ? ($room->patient->name ?? 'Pasien') : ($room->doctor->name ?? 'Dokter') }}";
            }

            const messageHtml = `
                <div class="flex ${alignClass}">
                    <div class="max-w-[70%] rounded-2xl px-4 py-2.5 shadow-sm text-sm ${bubbleClass}">
                        <p class="text-[10px] opacity-60 font-bold mb-0.5">${senderName}</p>
                        <p class="leading-relaxed">${msg.message}</p>
                        <p class="text-[9px] opacity-50 text-right mt-1">${timeStr}</p>
                    </div>
                </div>
            `;

            chatBox.insertAdjacentHTML('beforeend', messageHtml);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // ✅ ECHO LISTENER — taruh di sini
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.Echo) {
                console.error('Echo tidak tersedia! Cek app.js & bootstrap.js');
                return;
            }

            console.log('Echo siap, subscribe ke channel: chat.room.' + roomId);

            window.Echo.private(`chat.room.${roomId}`)
                .listen('.message.sent', (data) => {
                    console.log('Pesan masuk real-time:', data);
                    appendMessage(data.message ?? data);
                })
                .error((err) => {
                    console.error('Gagal otorisasi channel:', err);
                });
        });

        // Kirim pesan via AJAX
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = messageInput.value.trim();
                if (!text) return;

                messageInput.value = '';

                fetch(`/chat/room/${roomId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Socket-ID': window.Echo.socketId() ?? ''
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        appendMessage(data.message);
                    }
                })
                .catch(error => {
                    console.error('Gagal mengirim pesan:', error);
                });
            });
        }
    </script>