<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MBC Clinic</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_mbc.jpeg') }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-teal-100 selection:text-teal-900">

    <nav class="bg-white/70 backdrop-blur-md sticky top-0 z-50 border-b border-neutral-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Clinic Logo" class="h-12 md:h-14 w-auto object-contain">
                </div>
                <div class="hidden md:flex space-x-8 text-sm font-medium tracking-wide">
                    <a href="#" class="text-teal-600 transition duration-300">Beranda</a>
                    <a href="#solutions" class="text-slate-600 hover:text-teal-600 transition duration-300">Solusi Produk</a>
                    <a href="#portfolio" class="text-slate-600 hover:text-teal-600 transition duration-300">Portofolio & Kegiatan</a>
                    <a href="#about" class="text-slate-600 hover:text-teal-600 transition duration-300">Tentang Kami</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-xs md:text-sm font-semibold text-slate-600 hover:text-teal-600 transition duration-300">Masuk</a>
                    <a href="/register" class="bg-slate-900 hover:bg-teal-600 text-white text-xs md:text-sm px-5 py-2.5 rounded-full font-medium transition duration-300 shadow-sm hover:shadow-md">Daftar Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-white pt-10 pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 md:pr-6">
                <div class="inline-flex items-center space-x-2 bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
                    <span>✨ Intelligent Healthcare Partner</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight leading-[1.15]">
                    Solusi Kesehatan & <br class="hidden lg:inline"><span class="text-teal-600 relative inline-block">Estetika Medis</span>
                </h1>
                <p class="text-slate-500 text-sm md:text-base leading-relaxed max-w-xl">
                    Klinik MBC mendefinisikan ulang layanan kesehatan modern melalui konsultasi cerdas dengan interaksi live chat interaktif bersama dokter spesialis umum, kecantikan, dan gigi.
                </p>
                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    <button onclick="openChatBot()" class="cursor-pointer bg-teal-600 text-white px-8 py-3.5 rounded-full font-medium hover:bg-teal-700 shadow-md hover:shadow-lg hover:shadow-teal-100 transition duration-300 text-center text-sm">
                        <i class="fa-solid fa-comments mr-2 animate-pulse"></i> Konsultasi Sekarang
                    </button>
                    <a href="#solutions" class="border border-slate-200 text-slate-700 px-8 py-3.5 rounded-full font-medium hover:bg-slate-50 hover:border-slate-300 transition duration-300 text-center text-sm">
                        Lihat Produk Layanan
                    </a>
                </div>
            </div>
            
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-teal-100 rounded-full blur-2xl opacity-60"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-emerald-100 rounded-full blur-3xl opacity-60"></div>
                
                <div class="w-full h-[380px] md:h-[440px] bg-gradient-to-br from-teal-50 to-emerald-50 rounded-3xl overflow-hidden relative border border-teal-100/30 shadow-xl flex items-center justify-center group">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=800" alt="Clinic Interior" class="w-full h-full object-cover opacity-90 group-hover:scale-102 transition duration-700 ease-out">
                    
                    <div class="absolute bottom-6 left-6 right-6 bg-white/80 backdrop-blur-md p-4 rounded-2xl border border-white/40 shadow-lg flex items-center justify-between transition-all duration-300 hover:bg-white">
                        <div>
                            <p class="text-[10px] text-teal-600 uppercase font-bold tracking-widest">Layanan Aktif</p>
                            <p class="text-sm font-bold text-slate-800 mt-0.5">Umum, Kecantikan & Gigi</p>
                        </div>
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="solutions" class="py-24 bg-slate-50/60 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center md:text-left max-w-3xl mb-16">
                <span class="text-teal-600 text-xs font-bold uppercase tracking-widest bg-teal-50 px-2.5 py-1 rounded-md">Our Solutions</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-3 tracking-tight">Katalog Produk & Solusi Perawatan</h2>
                <p class="text-slate-500 text-sm md:text-base mt-2">Dapatkan produk rekomendasi klinis terbaik yang dirancang spesifik untuk kebutuhan medis Anda.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl p-4 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-full h-56 bg-slate-50 rounded-xl overflow-hidden mb-4 relative">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="text-[10px] font-bold bg-neutral-100 text-neutral-600 px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $product['solution'] }}</span>
                        <h3 class="font-bold text-base md:text-lg text-slate-900 mt-3 group-hover:text-teal-600 transition duration-300">{{ $product['name'] }}</h3>
                    </div>
                    <div class="mt-6 pt-4 border-t border-neutral-50 flex justify-between items-center">
                        <span class="text-xs text-slate-400 font-medium">Harga Resmi</span>
                        <span class="font-bold text-teal-600 text-base md:text-lg">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portfolio" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center md:text-left max-w-3xl mb-16">
                <span class="text-teal-600 text-xs font-bold uppercase tracking-widest bg-teal-50 px-2.5 py-1 rounded-md">MBC Updates</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-3 tracking-tight">Portofolio Kegiatan & Berita Edukasi</h2>
                <p class="text-slate-500 text-sm md:text-base mt-2">Dokumentasi aktivitas medis, sertifikasi, seminar, dan artikel edukasi tepercaya dari kami.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolios as $portfolio)
                <article class="group cursor-pointer flex flex-col justify-between p-2 rounded-2xl hover:bg-neutral-50/50 transition duration-300">
                    <div>
                        <div class="w-full h-52 rounded-2xl overflow-hidden bg-slate-100 mb-4 shadow-sm">
                            <img src="{{ asset('storage/' . $portfolio['image']) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                        </div>
                        <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                            <span class="font-bold text-teal-600 uppercase tracking-wider">{{ $portfolio['category'] }}</span>
                            <span>•</span>
                            <span>{{ $portfolio['date'] }}</span>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-teal-600 transition duration-300 leading-snug">{{ $portfolio['title'] }}</h3>
                        <p class="text-slate-500 text-xs md:text-sm mt-2 line-clamp-2 leading-relaxed">{{ $portfolio['excerpt'] }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="toggleChatModal()" class="cursor-pointer bg-slate-900 hover:bg-teal-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:scale-105 transition-all duration-300 relative group">
            <i class="fa-solid fa-comments text-xl group-hover:rotate-6 transition duration-300"></i>
            <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
        </button>
    </div>
    
    <div id="chatModal" class="fixed bottom-24 right-6 w-[92vw] sm:w-96 h-[520px] bg-white rounded-3xl shadow-2xl border border-neutral-100/60 z-50 hidden flex flex-col overflow-hidden transition-all duration-300">
        <div class="bg-slate-900 p-4 text-white flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-teal-600 rounded-full flex items-center justify-center font-bold text-xs shadow-sm">MBC</div>
                <div>
                    <h4 class="font-semibold text-xs md:text-sm">Asisten Virtual MBC</h4>
                    <span class="text-[10px] text-emerald-400 flex items-center mt-0.5">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>Respons Otomatis
                    </span>
                </div>
            </div>
            <button onclick="toggleChatModal()" class="cursor-pointer text-slate-400 hover:text-white text-2xl transition">&times;</button>
        </div>
    
        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50/50 text-xs md:text-sm" id="chatMessages">
            <div class="flex items-start space-x-2">
                <div class="bg-white border border-neutral-100 text-slate-700 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm leading-relaxed">
                    Halo! Perkenalkan saya bot klinik MBC. Ada yang bisa saya bantu terkait keluhan medis Anda hari ini? Silakan ketik keluhan Anda di bawah, atau ketik <b>"chat dokter"</b> untuk konsultasi langsung.
                </div>
            </div>
            <div id="typingIndicatorWidget" class="hidden flex items-start space-x-2">
                <div class="bg-white border border-neutral-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                    <div class="flex space-x-1">
                        <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="p-3 bg-white border-t border-neutral-100 flex items-center space-x-2">
            <input type="text" id="userInput" placeholder="Ketik keluhan Anda di sini..." class="flex-1 bg-slate-50 border border-neutral-200 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:border-teal-500 focus:bg-white transition duration-200" onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()" id="widgetSendBtn" class="cursor-pointer bg-teal-600 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-teal-700 transition duration-200 shrink-0">
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>

    <footer class="bg-slate-900 text-slate-500 py-12 text-center text-xs border-t border-slate-800 tracking-wide">
        <p>&copy; 2026 MBC Clinic. All Rights Reserved.</p>
        <p class="mt-1 opacity-60">Inspired by <a href="https://sekantin.com" rel="nofollow" class="hover:text-teal-400 transition">sekantin.com</a></p>
    </footer>

    <script>
        let widgetHistory = [];
    
        function toggleChatModal() {
            const modal = document.getElementById('chatModal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.getElementById('userInput').focus();
            }
        }

        function openChatBot() {
            const modal = document.getElementById('chatModal');
            modal.classList.remove('hidden');
            document.getElementById('userInput').focus();
        }
    
        function handleKeyPress(e) {
            if (e.key === 'Enter') sendMessage();
        }
    
        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
    
        function sendMessage() {
            const input = document.getElementById('userInput');
            const container = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicatorWidget');
            const sendBtn = document.getElementById('widgetSendBtn');
    
            const text = input.value.trim();
            if (text === '') return;
    
            // Tampilkan chat user
            const userHtml = `
                <div class="flex justify-end">
                    <div class="bg-teal-600 text-white p-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-sm">
                        ${escapeHtml(text)}
                    </div>
                </div>
            `;
            typingIndicator.insertAdjacentHTML('beforebegin', userHtml);
    
            input.value = '';
            input.disabled = true;
            sendBtn.disabled = true;
            container.scrollTop = container.scrollHeight;
    
            const lowerText = text.toLowerCase();
    
            // Arahkan ke chat dokter langsung jika mendeteksi kata kunci terkait
            if (lowerText.includes('dokter') || lowerText.includes('chat langsung') || lowerText.includes('spesialis')) {
                setTimeout(() => {
                    const doctorHtml = `
                        <div class="flex items-start space-x-2">
                            <div class="bg-white border border-neutral-200 text-slate-800 p-4 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm space-y-3">
                                <p class="font-bold text-xs text-slate-400 uppercase tracking-wider">Silakan masuk untuk memilih spesialisasi:</p>
                                <a href="{{ route('login') }}" class="block text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-4 rounded-xl text-xs font-semibold transition duration-200 shadow-sm">
                                    Masuk untuk Konsultasi Dokter <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    `;
                    typingIndicator.insertAdjacentHTML('beforebegin', doctorHtml);
                    container.scrollTop = container.scrollHeight;
                    input.disabled = false;
                    sendBtn.disabled = false;
                    input.focus();
                }, 400);
                return;
            }
    
            // Aktifkan indikator mengetik (loading)
            typingIndicator.classList.remove('hidden');
            container.scrollTop = container.scrollHeight;
    
            // Hit ke API Backend Laravel Anda
            fetch(`{{ route('chat.bot.guest.send') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                },
                body: JSON.stringify({
                    message: text,
                    history: widgetHistory,
                }),
            })
            .then(res => res.json())
            .then(data => {
                typingIndicator.classList.add('hidden');
                const reply = data.message ?? 'Maaf, sistem bot sedang gangguan. Silakan coba lagi atau hubungi dokter kami langsung.';
    
                const botHtml = `
                    <div class="flex items-start space-x-2">
                        <div class="bg-white border border-neutral-100 text-slate-700 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm whitespace-pre-line leading-relaxed">
                            ${escapeHtml(reply)}
                        </div>
                    </div>
                `;
                typingIndicator.insertAdjacentHTML('beforebegin', botHtml);
    
                // Kelola riwayat percakapan agar tidak overload (maksimal 20 riwayat)
                widgetHistory.push({ role: 'user', content: text });
                widgetHistory.push({ role: 'assistant', content: reply });
                if (widgetHistory.length > 20) {
                    widgetHistory = widgetHistory.slice(-20);
                }
    
                container.scrollTop = container.scrollHeight;
            })
            .catch(err => {
                typingIndicator.classList.add('hidden');
                const errHtml = `
                    <div class="flex items-start space-x-2">
                        <div class="bg-white border border-rose-100 text-rose-600 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm text-xs">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> Gagal memuat respons. Pastikan Anda terhubung ke internet atau coba beberapa saat lagi.
                        </div>
                    </div>
                `;
                typingIndicator.insertAdjacentHTML('beforebegin', errHtml);
                container.scrollTop = container.scrollHeight;
                console.error(err);
            })
            .finally(() => {
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            });
        }
    </script>
</body>
</html>