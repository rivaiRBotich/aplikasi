<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - MBC Clinic</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_mbc.jpeg') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/js/app.js'])
</head>

<script>
    // Kirim heartbeat setiap 30 detik
    function sendHeartbeat() {
        fetch('/doctor/heartbeat', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });
    }

    sendHeartbeat(); // langsung kirim saat halaman dibuka
    setInterval(sendHeartbeat, 30000); // setiap 30 detik

    // Tandai offline saat tab/browser ditutup
    window.addEventListener('beforeunload', function () {
        navigator.sendBeacon('/doctor/offline', JSON.stringify({
            _token: '{{ csrf_token() }}'
        }));
    });
</script>

<body class="bg-slate-50 text-slate-800 antialiased font-sans">

    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Logo" class="w-10 h-10 rounded-full object-cover border-2 border-teal-500 shadow-sm">
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight tracking-wide">MBC CLINIC</h1>
                    <p class="text-[11px] text-teal-600 font-semibold tracking-wider uppercase">Portal Medis Dokter</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-xs bg-teal-50 border border-teal-100 text-teal-700 px-3 py-1.5 rounded-full font-semibold flex items-center gap-1.5 shadow-sm">
                    <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span> {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100/80 px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                        Keluar <i class="fa-solid fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1 bg-gradient-to-br from-slate-900 to-teal-950 text-white rounded-2xl p-5 shadow-md flex items-center justify-between relative overflow-hidden group">
                <div class="z-10">
                    <p class="text-[11px] text-teal-400 font-bold tracking-widest uppercase mb-1">Selamat Bekerja,</p>
                    <h2 class="text-lg font-bold truncate max-w-[250px]">Dokter,  {{( auth()->user()->name ) }} 👋</h2>
                    <p class="text-[11px] text-slate-300 mt-1 font-medium">Klinik Spesialis: <span class="capitalize text-teal-300">{{ auth()->user()->clinic_category ?? 'Umum' }}</span></p>
                </div>
                <img src="{{ asset('images/logo_mbc.jpeg') }}" class="w-24 h-24 rounded-full object-cover absolute -right-4 -bottom-2 opacity-15 blur-[1px] group-hover:scale-110 transition duration-500">
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 text-xl shrink-0">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Dompet Pendapatan</p>
                    <h3 class="text-lg font-black text-slate-800 mt-0.5">Rp{{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-emerald-600 font-medium mt-0.5"><i class="fa-solid fa-arrow-trend-up"></i> Otomatis cair per bulan</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 text-xl shrink-0">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">Konsultasi Ditangani</p>
                    <h3 class="text-lg font-black text-slate-800 mt-0.5">{{ $activeChats->count() }} Pasien</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Sedang dalam ruang obrolan</p>
                </div>
            </div>
        </div>

        <main class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-teal-600 text-base"></i> Antrean Pasien Masuk Klinik
                        </h2>
                        <span class="text-xs bg-amber-50 border border-amber-200 text-amber-800 font-extrabold px-3 py-1 rounded-full animate-pulse">
                            {{ $availableChats->count() }} Menunggu
                        </span>
                    </div>
                    
                    @if($availableChats->isEmpty())
                        <div class="text-center py-12 border border-dashed border-slate-200 rounded-xl bg-slate-50/50 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-300 text-2xl mb-3">
                                <i class="fa-solid fa-comment-slash"></i>
                            </div>
                            <p class="text-xs text-slate-500 font-bold">Belum Ada Antrean Masuk</p>
                            <p class="text-[11px] text-slate-400 max-w-[280px] mt-0.5">Pasien yang membutuhkan kenyamanan medismu akan muncul langsung secara real-time di sini.</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($availableChats as $chat)
                                <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0 group">
                                    <div class="flex items-center space-x-3.5">
                                        <div class="w-11 h-11 bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-full flex items-center justify-center font-bold text-sm uppercase shadow-sm tracking-wider">
                                            {{ substr($chat->patient->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm mb-0.5 group-hover:text-teal-600 transition">{{ $chat->patient->name }}</h4>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] bg-slate-100 border border-slate-200 text-slate-600 font-bold px-2 py-0.5 rounded-md capitalize">
                                                    Klinik {{ $chat->category }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 font-medium">
                                                    <i class="fa-regular fa-clock"></i> {{ $chat->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('doctor.chat.accept', $chat->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs bg-teal-600 hover:bg-teal-700 text-white font-bold px-4 py-2.5 rounded-xl shadow-md shadow-teal-600/10 hover:shadow-teal-600/20 transition duration-200 flex items-center gap-1.5">
                                            Terima Chat <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-900 tracking-tight mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-emerald-600 text-base"></i> Obrolan Aktif Saya
                    </h2>

                    @if($activeChats->isEmpty())
                        <div class="text-center py-10 border border-dashed border-slate-100 rounded-xl bg-slate-50/50 flex flex-col items-center justify-center">
                            <img src="{{ asset('images/logo_mbc.jpeg') }}" class="w-10 h-10 rounded-full object-cover opacity-20 grayscale mb-2">
                            <p class="text-xs text-slate-400 font-semibold">Tidak ada sesi aktif.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($activeChats as $active)
                                <a href="{{ route('chat.room', $active->id) }}" class="flex items-center justify-between p-3 border border-slate-100 hover:border-teal-300 rounded-xl hover:bg-teal-50/30 transition-all duration-200 group shadow-sm bg-slate-50/20">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 bg-teal-50 border border-teal-100 text-teal-600 rounded-full flex items-center justify-center font-bold text-xs uppercase shadow-inner">
                                            {{ substr($active->patient->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-xs group-hover:text-teal-700 transition">{{ $active->patient->name }}</h4>
                                            <p class="text-[10px] text-slate-400 font-medium capitalize">Klinik {{ $active->category }}</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-teal-700 bg-teal-50 border border-teal-100 px-2.5 py-1 rounded-lg shadow-2xs group-hover:bg-teal-600 group-hover:text-white transition duration-200">
                                        Masuk Kamar <i class="fa-solid fa-right-to-bracket ml-0.5"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </main>
    </div>

</body>
</html>