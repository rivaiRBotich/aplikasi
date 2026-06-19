<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Bot Kesehatan - MBC Clinic</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 antialiased h-screen flex flex-col justify-between">

    <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shrink-0 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-sky-600 rounded-full flex items-center justify-center text-white">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Bot Kesehatan MBC Clinic</h3>
                <p class="text-[11px] text-emerald-500 font-semibold"><span class="inline-block w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span>Online 24 Jam</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <form action="{{ route('chat.bot.reset') }}" method="POST" onsubmit="return confirm('Hapus semua riwayat chat dengan bot?')">
                @csrf
                <button type="submit" class="text-xs bg-slate-100 hover:bg-slate-200 font-medium text-slate-600 px-4 py-2 rounded-xl transition">
                    <i class="fa-solid fa-trash-can"></i> Reset
                </button>
            </form>
            <a href="{{ route('dashboard') }}" class="text-xs bg-slate-100 hover:bg-slate-200 font-medium text-slate-600 px-4 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </header>

    <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50">

        {{-- Pesan sambutan otomatis kalau belum ada history --}}
        @if($messages->isEmpty())
        <div class="flex justify-start">
            <div class="max-w-[75%] rounded-2xl px-4 py-3 shadow-sm text-sm bg-white text-slate-800 rounded-bl-none border border-slate-100">
                <p class="text-[10px] opacity-60 font-bold mb-1">🤖 Bot MBC Clinic</p>
                <p class="leading-relaxed">Halo! Selamat datang di Chatbot MBC Clinic 👋<br><br>Saya asisten kesehatan virtual yang siap bantu jawab pertanyaan seputar kesehatan umum kamu. Ada keluhan atau pertanyaan apa hari ini?</p>
                <p class="text-[9px] opacity-40 mt-2">Catatan: Saya bukan pengganti diagnosis dokter. Untuk keluhan serius, silakan konsultasi langsung dengan dokter kami.</p>
            </div>
        </div>
        @endif

        @foreach($messages as $msg)
            @if($msg->role === 'user')
            <div class="flex justify-end">
                <div class="max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm text-sm bg-sky-600 text-white rounded-br-none">
                    <p class="leading-relaxed">{{ $msg->message }}</p>
                    <p class="text-[9px] opacity-60 text-right mt-1">{{ $msg->created_at->format('H:i') }}</p>
                </div>
            </div>
            @else
            <div class="flex justify-start">
                <div class="max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm text-sm bg-white text-slate-800 rounded-bl-none border border-slate-100">
                    <p class="text-[10px] opacity-60 font-bold mb-0.5">🤖 Bot MBC Clinic</p>
                    <p class="leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                    <p class="text-[9px] opacity-40 text-right mt-1">{{ $msg->created_at->format('H:i') }}</p>
                </div>
            </div>
            @endif
        @endforeach

        {{-- Indikator bot sedang mengetik --}}
        <div id="typing-indicator" class="hidden flex justify-start">
            <div class="bg-white border border-slate-100 rounded-2xl rounded-bl-none px-4 py-3 shadow-sm">
                <div class="flex space-x-1">
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-slate-200 p-4 shrink-0 shadow-lg">
        <form id="chat-form" class="flex items-center space-x-3 max-w-5xl mx-auto">
            <input type="text" id="message-input" placeholder="Tulis pertanyaan kesehatan kamu di sini..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl text-sm p-3 focus:outline-none focus:border-sky-500 transition" autocomplete="off" required>
            <button type="submit" id="send-btn" class="bg-sky-600 hover:bg-sky-700 text-white p-3 rounded-xl transition shadow-md shadow-sky-600/20 cursor-pointer">
                <i class="fa-solid fa-paper-plane text-sm"></i>
            </button>
        </form>
    </footer>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const typingIndicator = document.getElementById('typing-indicator');

        chatBox.scrollTop = chatBox.scrollHeight;

        function appendUserMessage(text) {
            const html = `
                <div class="flex justify-end">
                    <div class="max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm text-sm bg-sky-600 text-white rounded-br-none">
                        <p class="leading-relaxed">${escapeHtml(text)}</p>
                        <p class="text-[9px] opacity-60 text-right mt-1">${nowTime()}</p>
                    </div>
                </div>
            `;
            chatBox.insertAdjacentHTML('beforeend', html);
        }

        function appendBotMessage(text) {
            const html = `
                <div class="flex justify-start">
                    <div class="max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm text-sm bg-white text-slate-800 rounded-bl-none border border-slate-100">
                        <p class="text-[10px] opacity-60 font-bold mb-0.5">🤖 Bot MBC Clinic</p>
                        <p class="leading-relaxed whitespace-pre-line">${escapeHtml(text)}</p>
                        <p class="text-[9px] opacity-40 text-right mt-1">${nowTime()}</p>
                    </div>
                </div>
            `;
            chatBox.insertAdjacentHTML('beforeend', html);
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function nowTime() {
            return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false }).replace('.', ':');
        }

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const text = messageInput.value.trim();
            if (!text) return;

            messageInput.value = '';
            sendBtn.disabled = true;
            messageInput.disabled = true;

            appendUserMessage(text);
            scrollToBottom();

            // Tampilkan indikator mengetik
            typingIndicator.classList.remove('hidden');
            chatBox.appendChild(typingIndicator);
            scrollToBottom();

            fetch(`{{ route('chat.bot.send') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: text }),
            })
            .then(res => res.json())
            .then(data => {
                typingIndicator.classList.add('hidden');
                if (data.message) {
                    appendBotMessage(data.message.message);
                } else {
                    appendBotMessage('Maaf, terjadi kesalahan. Silakan coba lagi.');
                }
                scrollToBottom();
            })
            .catch(err => {
                typingIndicator.classList.add('hidden');
                appendBotMessage('Maaf, koneksi bermasalah. Silakan coba lagi.');
                console.error(err);
            })
            .finally(() => {
                sendBtn.disabled = false;
                messageInput.disabled = false;
                messageInput.focus();
            });
        });
    </script>

</body>
</html>