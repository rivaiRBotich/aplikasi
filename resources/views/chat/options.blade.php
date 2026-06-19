<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Konsultasi - MBC Clinic</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="py-16 min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full px-6 space-y-8">

            <div class="text-center space-y-2">
                <div class="w-16 h-16 bg-teal-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto shadow-lg shadow-teal-600/20">
                    <i class="fa-solid fa-comment-medical"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-900">Selamat Datang di Chatbot MBC Clinic 👋</h1>
                <p class="text-sm text-slate-500">Mau tanya jawab dengan dokter langsung, atau ngobrol dulu dengan bot kami?</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">

                {{-- Opsi: Dokter Langsung — WAJIB LOGIN --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4 flex flex-col">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 text-xl">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800">Konsultasi Dokter</h3>
                        <p class="text-xs text-slate-400 mt-1">Bicara langsung dengan dokter sungguhan untuk diagnosis dan penanganan lebih akurat. Saldo akan dipotong sesuai tarif.</p>
                        <p class="text-[10px] text-amber-600 font-semibold mt-2"><i class="fa-solid fa-circle-info"></i> Perlu login / daftar akun dulu</p>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition block">
                            Pilih Dokter <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition block">
                            Masuk untuk Konsultasi <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    @endauth
                </div>

                {{-- Opsi: Chat Bot — TANPA LOGIN --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4 flex flex-col">
                    <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 text-xl">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800">Tanya Bot Kesehatan</h3>
                        <p class="text-xs text-slate-400 mt-1">Tanya jawab cepat dan gratis dengan asisten virtual kami untuk info kesehatan umum, 24 jam nonstop.</p>
                        <p class="text-[10px] text-emerald-600 font-semibold mt-2"><i class="fa-solid fa-circle-check"></i> Tanpa perlu login</p>
                    </div>
                    <a href="{{ route('chat.bot.guest') }}" class="w-full text-center bg-sky-600 hover:bg-sky-700 text-white font-medium py-2.5 rounded-xl text-sm transition block">
                        Mulai Chat Bot <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

            </div>

            <p class="text-center text-[11px] text-slate-400">
                Bot kesehatan hanya memberikan informasi umum, bukan pengganti diagnosis medis profesional.
            </p>

            <div class="text-center">
                <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

</body>
</html>