<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBC Clinic - Intelligent Health & Dermabeauty Partner</title>
    <!-- Tailwind CSS v4 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased">

    <!-- 1. NAVBAR (Clean & Sticky) -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Clinic Logo" class="h-20 w-auto object-contain max-w-[240px] md:max-w-[320px]">
                </div>
                <div class="hidden md:flex space-x-8 font-medium text-slate-600 text-sm">
                    <a href="#" class="text-teal-600">Beranda</a>
                    <a href="#solutions" class="hover:text-teal-600 transition">Solusi Produk</a>
                    <a href="#portfolio" class="hover:text-teal-600 transition">Portofolio & Kegiatan</a>
                    <a href="#about" class="hover:text-teal-600 transition">Tentang Kami</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-sm font-medium text-slate-600 hover:text-teal-600">Masuk</a>
                    <a href="/register" class="bg-slate-900 text-white text-sm px-5 py-2.5 rounded-full font-medium hover:bg-slate-800 transition shadow-sm">Daftar Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION (Minimalis & Elegan) -->
    <section class="relative bg-white pt-12 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center space-x-2 bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <span>✨ Intelligent Healthcare Partner</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight leading-[1.15]">
                    Solusi Kesehatan & <span class="text-teal-600">Estetika Medis</span>
                </h1>
                <p class="text-slate-500 text-base md:text-lg leading-relaxed max-w-xl">
                    Klinik MBC mendefinisikan ulang layanan kesehatan melalui konsultasi cerdas dengan interaksi live chat interaktif bersama dokter spesialis umum, kecantikan, dan gigi.
                </p>
                <div class="pt-2 flex flex-col sm:flex-row gap-4">
                    <button onclick="openChatBot()" class="bg-teal-600 text-white px-8 py-3.5 rounded-full font-medium hover:bg-teal-700 shadow-md transition text-center">
                        <i class="fa-solid fa-robot mr-2"></i> Konsultasi Sekarang
                    </button>
                    <a href="#solutions" class="border border-slate-200 text-slate-700 px-8 py-3.5 rounded-full font-medium hover:bg-slate-50 transition text-center">
                        Lihat Produk Layanan
                    </a>
                </div>
            </div>
            <div class="relative">
                <!-- Aksen estetika modern melengkung -->
                <div class="w-full h-[400px] bg-gradient-to-br from-teal-50 to-emerald-50 rounded-3xl overflow-hidden relative border border-teal-100/50 shadow-inner flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=800" alt="Clinic Interior" class="w-full h-full object-cover mix-blend-multiply opacity-80">
                    <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-md p-4 rounded-xl border border-white/20 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-semibold tracking-wider">Dokter Aktif</p>
                            <p class="text-sm font-bold text-slate-800">Umum, Kecantikan & Gigi</p>
                        </div>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PILIHAN SOLUSI / PRODUK (Mengikuti Karakter Utama DermaXP) -->
    <section id="solutions" class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-teal-600 text-xs font-bold uppercase tracking-widest">Our Solutions</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Katalog Produk & Solusi Perawatan</h2>
                <p class="text-slate-500 text-sm mt-2">Dapatkan produk rekomendasi klinis terbaik yang dirancang spesifik untuk kebutuhan medis Anda.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-full h-52 bg-slate-50 rounded-xl overflow-hidden mb-4">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $product['solution'] }}</span>
                        <h3 class="font-bold text-lg text-slate-900 mt-2.5">{{ $product['name'] }}</h3>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 flex justify-between items-center">
                        <span class="text-xs text-slate-400 font-medium">Harga Tertera</span>
                        <span class="font-bold text-teal-600 text-base">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. PORTOFOLIO & KEGIATAN KLINIK -->
    <section id="portfolio" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-teal-600 text-xs font-bold uppercase tracking-widest">MBC Updates</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Portofolio Kegiatan & Berita Edukasi</h2>
                <p class="text-slate-500 text-sm mt-2">Dokumentasi aktivitas medis, sertifikasi, seminar, dan artikel edukasi tepercaya dari kami.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolios as $portfolio)
                <article class="group cursor-pointer flex flex-col justify-between">
                    <div>
                        <div class="w-full h-48 rounded-2xl overflow-hidden bg-slate-100 mb-4 border border-slate-100">
                            <img src="{{ asset('storage/' . $portfolio['image']) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="flex items-center space-x-2 text-xs text-slate-400 mb-2">
                            <span class="font-semibold text-teal-600 uppercase">{{ $portfolio['category'] }}</span>
                            <span>•</span>
                            <span>{{ $portfolio['date'] }}</span>
                        </div>
                        <h3 class="font-bold text-xl text-slate-900 group-hover:text-teal-600 transition leading-snug">{{ $portfolio['title'] }}</h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">{{ $portfolio['excerpt'] }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. FLOATING LIVE CHAT WIDGET -->
    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="toggleChatModal()" class="bg-teal-600 hover:bg-teal-700 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:scale-105 transition duration-200 relative group">
            <i class="fa-solid fa-comments text-xl"></i>
            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
        </button>
    </div>

    <!-- MODAL POPUP CHAT INTERAKTIF -->
    <div id="chatModal" class="fixed bottom-24 right-6 w-96 h-[520px] bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 hidden flex flex-col overflow-hidden">
        <!-- Header Chat -->
        <div class="bg-slate-900 p-4 text-white flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center font-bold text-sm">MBC</div>
                <div>
                    <h4 class="font-semibold text-sm">Asisten Virtual MBC</h4>
                    <span class="text-xs text-emerald-400 flex items-center"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>Respons Cepat AI</span>
                </div>
            </div>
            <button onclick="toggleChatModal()" class="text-slate-400 hover:text-white text-xl">&times;</button>
        </div>

        <!-- Box Isi Chat -->
        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50 text-sm" id="chatMessages">
            <div class="flex items-start space-x-2">
                <div class="bg-white border border-slate-100 text-slate-700 p-3 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm">
                    Halo! 👋 Perkenalkan saya bot klinik MBC. Ada yang bisa saya bantu terkait keluhan medis Anda hari ini? Silakan ketik keluhan Anda di bawah.
                </div>
            </div>
        </div>

        <!-- Input Chat -->
        <div class="p-3 bg-white border-t border-slate-100 flex items-center space-x-2">
            <input type="text" id="userInput" placeholder="Ketik keluhan atau ketik 'Chat Dokter'..." class="flex-1 bg-slate-50 border border-slate-200 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:border-teal-500 focus:bg-white transition" onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()" class="bg-teal-600 text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-teal-700 transition">
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-12 text-center text-xs border-t border-slate-800">
        <p>&copy; 2026 MBC Clinic. All Rights Reserved. Inspired by</p><p><a href="https://sekantin.com" rel="nofollow">sekantin.com</a></p>
    </footer>

    <!-- LOGIKA JAVASCRIPT CHATBOX (FRONTEND TEMPORARY) -->
    <script>
        function toggleChatModal() {
            const modal = document.getElementById('chatModal');
            modal.classList.toggle('hidden');
        </div>

        function openChatBot() {
            const modal = document.getElementById('chatModal');
            modal.classList.remove('hidden');
            document.getElementById('userInput').focus();
        }

        function handleKeyPress(e) {
            if(e.key === 'Enter') sendMessage();
        }

        function sendMessage() {
            const input = document.getElementById('userInput');
            const container = document.getElementById('chatMessages');
            
            if(input.value.trim() === "") return;

            // Tampilkan chat user
            container.innerHTML += `
                <div class="flex justify-end">
                    <div class="bg-teal-600 text-white p-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-sm">
                        ${input.value}
                    </div>
                </div>
            `;
            
            const userText = input.value.toLowerCase();
            input.value = "";
            container.scrollTop = container.scrollHeight;

            // Simulasi Alur Logika Anda
            setTimeout(() => {
                if (userText.includes('dokter') || userText.includes('chat langsung')) {
                    container.innerHTML += `
                        <div class="flex items-start space-x-2">
                            <div class="bg-white border border-slate-200 text-slate-800 p-4 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm space-y-3">
                                <p class="font-semibold text-xs text-slate-500 uppercase tracking-wider">Silakan pilih spesialisasi (Wajib Login & Isi Saldo):</p>
                                <div class="flex flex-col space-y-2">
                                    <a href="/login" class="block text-center bg-teal-50 hover:bg-teal-100 text-teal-700 py-2.5 rounded-xl text-xs font-semibold transition border border-teal-100">🩺 Klinik Umum</a>
                                    <a href="/login" class="block text-center bg-rose-50 hover:bg-rose-100 text-rose-700 py-2.5 rounded-xl text-xs font-semibold transition border border-rose-100">✨ Klinik Kecantikan</a>
                                    <a href="/login" class="block text-center bg-sky-50 hover:bg-sky-100 text-sky-700 py-2.5 rounded-xl text-xs font-semibold transition border border-sky-100">🦷 Dokter Gigi</a>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Penanda kalau nanti bagian ini akan merespons langsung via DeepSeek API
                    container.innerHTML += `
                        <div class="flex items-start space-x-2">
                            <div class="bg-white border border-slate-100 text-slate-700 p-3 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm">
                                <span class="text-slate-400"><i class="fa-solid fa-spinner animate-spin mr-1"></i> DeepSeek AI sedang menganalisis gejala...</span>
                            </div>
                        </div>
                    `;
                }
                container.scrollTop = container.scrollHeight;
            }, 800);
        }
    </script>
</body>
</html>