<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MBC Clinic - Health & Aesthetic</title>
    
    <!-- Tailwind Browser -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_mbc.jpeg') }}">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F7F1E6] text-stone-800 antialiased selection:bg-[#E8DCC0] selection:text-[#3D2E1F] overflow-x-hidden">

    {{-- LAYER BACKGROUND FIXED & BLUR (Terisolasi di belakang seluruh elemen website) --}}
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat blur-[6px] scale-105 pointer-events-none" 
         style="background-image: url('{{ asset('images/bg_mbc.jpeg') }}');">
    </div>
    {{-- Lapisan overlay gradasi global agar nuansa krem hangat tetap dominan dan teks terbaca tajam --}}
    <div class="fixed inset-0 z-0 bg-gradient-to-b from-[#F7F1E6]/50 via-[#F7F1E6]/30 to-[#F7F1E6]/60 pointer-events-none"></div>

    {{-- KONTEN UTAMA (Diberikan relasi z-10 agar berada di atas layer background) --}}
    <div class="relative z-10 flex flex-col min-h-screen">

        {{-- NAVBAR ELEGAN --}}
        <nav class="bg-[#F7F1E6]/90 backdrop-blur-md sticky top-0 z-50 border-b border-[#E0D2AE]/50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 md:h-20 items-center">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Clinic Logo" class="h-12 md:h-14 w-auto object-contain">
                    </div>
                    <div class="hidden md:flex space-x-8 text-sm font-medium tracking-wide">
                        <a href="#" class="text-[#A9842E] font-semibold transition duration-300">Beranda</a>
                        <a href="#solutions" class="text-stone-600 hover:text-[#A9842E] transition duration-300">Solusi Produk</a>
                        <a href="#portfolio" class="text-stone-600 hover:text-[#A9842E] transition duration-300">Portofolio & Kegiatan</a>
                        <a href="#about" class="text-stone-600 hover:text-[#A9842E] transition duration-300">Tentang Kami</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/login" class="text-xs md:text-sm font-semibold text-stone-600 hover:text-[#A9842E] transition duration-300">Masuk</a>
                        <a href="/register" class="bg-[#3D2E1F] hover:bg-[#2B2016] text-white text-xs md:text-sm px-5 py-2.5 rounded-full font-medium transition duration-300 shadow-xs hover:shadow-md">Daftar Akun</a>
                    </div>
                </div>
            </div>
        </nav>

        {{-- HERO SECTION --}}
        <section class="relative pt-16 pb-24 overflow-hidden min-h-[85vh] flex items-center bg-transparent">
            <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-5 gap-8 lg:gap-12 items-center relative z-10">
                
                {{-- Bagian Kiri: Teks & Aksi --}}
                <div class="space-y-6 md:col-span-3">
                    <div class="inline-flex items-center space-x-2 bg-white/90 border border-[#E0D2AE] text-[#A9842E] px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide shadow-xs backdrop-blur-xs">
                        <span>✨ Healthy Skin. Luxury Care.</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#3D2E1F] tracking-tight leading-[1.15]">
                        Transformasi Kesehatan & <br class="hidden lg:inline"><span class="text-[#A9842E] relative inline-block">Pesona Aesthetic Anda</span>
                    </h1>
                    <p class="text-stone-700 text-sm md:text-base font-medium leading-relaxed max-w-xl bg-white/40 p-3 rounded-2xl border border-white/20 backdrop-blur-xs">
                        Klinik MBC mendefinisikan ulang pelayanan medis modern melalui pendekatan nyaman, aman, dan profesional. Nikmati interaksi live chat interaktif bersama dokter umum, gigi, dan khusus kecantikan (aesthetic).
                    </p>
                    <div class="pt-4 flex flex-col sm:flex-row gap-4">
                        <button onclick="openChatBot()" class="cursor-pointer bg-[#3D2E1F] text-white px-8 py-3.5 rounded-full font-medium hover:bg-[#2B2016] shadow-md hover:shadow-lg hover:shadow-[#3D2E1F]/10 transition duration-300 text-center text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-comments animate-pulse"></i> Konsultasi Sekarang
                        </button>
                        <a href="#solutions" class="bg-white border border-[#E0D2AE] text-stone-700 px-8 py-3.5 rounded-full font-medium hover:bg-[#F7F1E6] hover:border-[#A9842E]/40 transition duration-300 text-center text-sm flex items-center justify-center shadow-xs">
                            Lihat Produk Layanan
                        </a>
                    </div>
                </div>
                
                {{-- Bagian Kanan: Kartu Logo Mengambang --}}
                <div class="relative flex justify-center md:justify-end md:col-span-2 w-full">
                    <div class="w-full max-w-xl bg-white/40 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/60 p-5 flex flex-row items-center gap-4 sm:gap-5">
                        
                        <div class="w-24 sm:w-28 md:w-32 shrink-0">
                            <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Clinic Visual" class="w-full h-auto object-contain rounded-2xl shadow-xs p-1.5 bg-white/80">
                        </div>

                        <div class="flex-1 flex flex-col justify-center text-left">
                            <h3 class="text-base sm:text-xl font-bold tracking-wide text-[#3D2E1F] uppercase drop-shadow-sm">MBC CLINIC</h3>
                            <p class="text-[10px] sm:text-xs tracking-widest text-[#A9842E] font-medium mt-0.5 uppercase mb-3 drop-shadow-sm">Health & Aesthetic</p>

                            <div class="w-full bg-white/90 backdrop-blur-sm px-3.5 py-2.5 rounded-xl border border-[#E0D2AE]/40 flex items-center justify-between">
                                <div class="pr-2">
                                    <p class="text-[9px] text-[#A9842E] uppercase font-bold tracking-widest">Layanan Aktif</p>
                                    <p class="text-[11px] md:text-xs font-semibold text-[#3D2E1F] mt-0.5 leading-relaxed">kesehatan umum, kesehatan gigi & mulut, serta aesthetic</p>
                                </div>
                                <span class="flex h-2.5 w-2.5 relative shrink-0">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- KATALOG PRODUK --}}
        <section id="solutions" class="py-24 bg-transparent border-y border-[#E0D2AE]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center md:text-left max-w-3xl mb-16 bg-white/60 p-6 rounded-2xl border border-white/40 backdrop-blur-md">
                    <span class="text-[#A9842E] text-xs font-bold uppercase tracking-widest bg-[#F7F1E6] px-3 py-1.5 rounded-md border border-[#E0D2AE]/40">Our Solutions</span>
                    <h2 class="text-3xl font-extrabold text-[#3D2E1F] mt-4 tracking-tight">Katalog Produk & Solusi Perawatan</h2>
                    <p class="text-stone-600 text-sm md:text-base mt-2">Dapatkan produk rekomendasi klinis terbaik yang dirancang spesifik untuk kebutuhan medis Anda.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $product)
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-4 border border-[#E0D2AE]/30 shadow-md hover:bg-white hover:border-[#A9842E]/60 hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-full h-56 bg-white rounded-xl overflow-hidden mb-4 relative border border-stone-100">
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <span class="text-[10px] font-bold bg-[#E0D2AE]/40 text-[#A9842E] px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $product['solution'] }}</span>
                            <h3 class="font-bold text-base md:text-lg text-[#3D2E1F] mt-3 group-hover:text-[#A9842E] transition duration-300">{{ $product['name'] }}</h3>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#E0D2AE]/20 flex justify-between items-center">
                            <span class="text-xs text-stone-400 font-medium">Harga Resmi</span>
                            <span class="font-bold text-[#A9842E] text-base md:text-lg">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- PORTOFOLIO & KEGIATAN --}}
        <section id="portfolio" class="py-24 bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center md:text-left max-w-3xl mb-16 bg-white/60 p-6 rounded-2xl border border-white/40 backdrop-blur-md">
                    <span class="text-[#A9842E] text-xs font-bold uppercase tracking-widest bg-white px-3 py-1.5 rounded-md border border-[#E0D2AE]/40">MBC Updates</span>
                    <h2 class="text-3xl font-extrabold text-[#3D2E1F] mt-4 tracking-tight">Portofolio Kegiatan & Berita Edukasi</h2>
                    <p class="text-stone-600 text-sm md:text-base mt-2">Dokumentasi aktivitas medis, sertifikasi, seminar, dan artikel edukasi tepercaya dari kami.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($portfolios as $portfolio)
                    <article class="group cursor-pointer flex flex-col justify-between p-4 rounded-2xl bg-white/80 backdrop-blur-md border border-[#E0D2AE]/30 hover:bg-white shadow-md hover:shadow-xl transition duration-300">
                        <div>
                            <div class="w-full h-52 rounded-xl overflow-hidden bg-white mb-4 border border-stone-100">
                                <img src="{{ asset('storage/' . $portfolio['image']) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            </div>
                            <div class="flex items-center space-x-2 text-[11px] text-stone-400 mb-2">
                                <span class="font-bold text-[#A9842E] uppercase tracking-wider">{{ $portfolio['category'] }}</span>
                                <span>•</span>
                                <span>{{ $portfolio['date'] }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-[#3D2E1F] group-hover:text-[#A9842E] transition duration-300 leading-snug">{{ $portfolio['title'] }}</h3>
                            <p class="text-stone-500 text-xs md:text-sm mt-2 line-clamp-2 leading-relaxed">{{ $portfolio['excerpt'] }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- FIXED WIDGET CHAT BUTTON --}}
        <div class="fixed bottom-6 right-6 z-50">
            <button onclick="toggleChatModal()" class="cursor-pointer bg-[#3D2E1F] hover:bg-[#2B2016] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:scale-105 transition-all duration-300 relative group">
                <i class="fa-solid fa-comments text-xl group-hover:rotate-6 transition duration-300"></i>
                <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
            </button>
        </div>
        
        {{-- MODAL CHAT INTEGRASI --}}
        <div id="chatModal" class="fixed bottom-24 right-6 w-[92vw] sm:w-96 h-[520px] bg-white rounded-3xl shadow-2xl border border-[#E0D2AE]/50 z-50 hidden flex flex-col overflow-hidden transition-all duration-300">
            <div class="bg-[#3D2E1F] p-4 text-white flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-[#A9842E] rounded-full flex items-center justify-center font-bold text-xs shadow-inner">MBC</div>
                    <div>
                        <h4 class="font-semibold text-xs md:text-sm">Asisten Virtual MBC</h4>
                        <span class="text-[10px] text-emerald-400 flex items-center mt-0.5">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>Respons Otomatis
                        </span>
                    </div>
                </div>
                <button onclick="toggleChatModal()" class="cursor-pointer text-stone-300 hover:text-white text-2xl transition">&times;</button>
            </div>
        
            <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-[#F7F1E6]/50 text-xs md:text-sm" id="chatMessages">
                <div class="flex items-start space-x-2">
                    <div class="bg-white border border-stone-100 text-stone-700 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-xs leading-relaxed">
                        Halo! Perkenalkan saya bot klinik MBC. Ada yang bisa saya bantu terkait keluhan medis Anda hari ini? Silakan ketik keluhan Anda di bawah, atau ketik <b>"chat dokter"</b> untuk konsultasi langsung bersama tim medis kami.
                    </div>
                </div>
                <div id="typingIndicatorWidget" class="hidden flex items-start space-x-2">
                    <div class="bg-white border border-stone-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-xs">
                        <div class="flex space-x-1">
                            <span class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                            <span class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                            <span class="w-1.5 h-1.5 bg-stone-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="p-3 bg-white border-t border-stone-100 flex items-center space-x-2">
                <input type="text" id="userInput" placeholder="Ketik keluhan Anda di sini..." class="flex-1 bg-[#F7F1E6]/60 border border-stone-200 rounded-full px-4 py-2.5 text-xs focus:outline-none focus:border-[#A9842E] focus:bg-white transition duration-200" onkeypress="handleKeyPress(event)">
                <button onclick="sendMessage()" id="widgetSendBtn" class="cursor-pointer bg-[#3D2E1F] text-white w-9 h-9 rounded-full flex items-center justify-center hover:bg-[#2B2016] transition duration-200 shrink-0">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="bg-[#3D2E1F] text-[#C9AD74] py-12 text-center text-xs tracking-wide border-t border-[#A9842E]/20 mt-auto">
            <p>&copy; 2026 MBC Clinic. All Rights Reserved.</p>
            <p class="mt-1 opacity-60">Inspired by <a href="https://sekantin.com" rel="nofollow" class="hover:text-white transition">sekantin.com</a></p>
        </footer>

    </div>

    {{-- SCRIPTS UTAMA --}}
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
    
            const userHtml = `
                <div class="flex justify-end">
                    <div class="bg-[#A9842E] text-white p-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-xs break-words">
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
    
            if (lowerText.includes('dokter') || lowerText.includes('chat langsung') || lowerText.includes('spesialis')) {
                setTimeout(() => {
                    const doctorHtml = `
                        <div class="flex items-start space-x-2">
                            <div class="bg-white border border-stone-200 text-stone-800 p-4 rounded-2xl rounded-tl-none max-w-[85%] shadow-xs space-y-3">
                                <p class="font-bold text-xs text-stone-400 uppercase tracking-wider">Silakan masuk untuk memilih spesialisasi:</p>
                                <a href="/login" class="block text-center bg-[#3D2E1F] hover:bg-[#2B2016] text-white py-2.5 px-4 rounded-xl text-xs font-semibold transition duration-200 shadow-xs">
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
    
            typingIndicator.classList.remove('hidden');
            container.scrollTop = container.scrollHeight;
    
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
                        <div class="bg-white border border-stone-100 text-stone-700 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-xs whitespace-pre-line leading-relaxed break-words">
                            ${reply}
                        </div>
                    </div>
                `;
                typingIndicator.insertAdjacentHTML('beforebegin', botHtml);
    
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
                        <div class="bg-white border border-rose-100 text-rose-600 p-3.5 rounded-2xl rounded-tl-none max-w-[85%] shadow-xs text-xs">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> Gagal memuat respons. Hubungi dokter kami secara langsung.
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