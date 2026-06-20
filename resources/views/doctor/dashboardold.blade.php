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
@vite(['resources/js/app.js']) {{-- tambahkan ini juga --}}

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

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-teal-600/20">
                    <i class="fa-solid fa-user-md text-sm"></i>
                </div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">MBC Clinic</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Panel Medis Dokter</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-xs bg-teal-50 border border-teal-200 text-teal-700 px-3 py-1.5 rounded-full font-semibold flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span> Dokter Aktif: {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl transition">
                        Keluar <i class="fa-solid fa-sign-out-alt ml-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri & Tengah: Antrean Konsultasi Pasien -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-teal-600"></i> Antrean Pasien Masuk
                    </h2>
                    <span class="text-xs bg-amber-100 text-amber-800 font-bold px-2.5 py-0.5 rounded-full">
                        {{ $availableChats->count() }} Menunggu
                    </span>
                </div>
                
                @if($availableChats->isEmpty())
                    <div class="text-center py-10 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                        <div class="text-slate-300 text-3xl mb-2"><i class="fa-solid fa-comment-slash"></i></div>
                        <p class="text-xs text-slate-400 font-medium">Belum ada pasien baru yang mengajukan konsultasi saat ini.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($availableChats as $chat)
                            <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-10 h-10 bg-slate-100 border border-slate-200 text-slate-600 rounded-full flex items-center justify-center font-bold text-sm uppercase shadow-inner">
                                        {{ substr($chat->patient->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ $chat->patient->name }}</h4>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] bg-slate-100 border border-slate-200 text-slate-600 font-semibold px-2 py-0.5 rounded-md capitalize">
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
                                    <button type="submit" class="text-xs bg-teal-600 hover:bg-teal-700 text-white font-bold px-4 py-2 rounded-xl shadow-md shadow-teal-600/10 transition flex items-center gap-1.5">
                                        Terima Chat <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Sesi Konsultasi Aktif yang Sedang Ditangani -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-sm font-bold text-slate-900 tracking-tight mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-comments text-emerald-600"></i> Konsultasi Aktif Saya
                </h2>

                @if($activeChats->isEmpty())
                    <div class="text-center py-8 border border-dashed border-slate-100 rounded-xl bg-slate-50/50">
                        <p class="text-xs text-slate-400 font-medium">Tidak ada sesi obrolan aktif yang Anda pegang.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($activeChats as $active)
                            <a href="{{ route('chat.room', $active->id) }}" class="flex items-center justify-between p-3 border border-slate-100 hover:border-teal-200 rounded-xl hover:bg-teal-50/30 transition group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-teal-50 border border-teal-100 text-teal-600 rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($active->patient->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-xs group-hover:text-teal-700 transition">{{ $active->patient->name }}</h4>
                                        <p class="text-[10px] text-slate-400 capitalize">Klinik {{ $active->category }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2.5 py-1 rounded-lg">
                                    Buka <i class="fa-solid fa-arrow-right ml-0.5"></i>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </main>

</body>
</html>