<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo_mbc.jpeg') }}" alt="MBC Logo" class="w-8 h-8 rounded-full object-cover border border-teal-500 shadow-xs">
            <h2 class="font-bold text-xl text-slate-800 leading-tight tracking-tight">
                {{ __('Dashboard Pasien - MBC Clinic') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-circle-xmark text-rose-500"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Menampilkan Error Validasi Laravel jika lolos ke server --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm space-y-2 shadow-xs">
                    <p class="font-bold flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Gagal Mengirim data:</p>
                    <ul class="list-disc pl-5 text-xs font-medium space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Banner Sesi Aktif --}}
            @if(isset($activeChat) && $activeChat)
                <div class="bg-teal-50 border border-teal-200 p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-4 shadow-xs relative overflow-hidden group">
                    <div class="text-sm text-teal-900 z-10">
                        <span class="font-black text-teal-800 flex items-center gap-1.5 animate-pulse">
                            <span class="w-2 h-2 bg-teal-500 rounded-full"></span> 📢 Sesi Konsultasi Anda Sedang Berjalan!
                        </span>
                        <p class="text-xs text-teal-700/90 mt-1 font-medium">Anda sudah membayar untuk Layanan Chat Klinik <span class="capitalize font-bold text-teal-900">{{ $activeChat->category }}</span>. Silakan langsung masuk kembali ke ruang percakapan.</p>
                    </div>
                    <a href="{{ route('chat.room', $activeChat->id) }}" class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition text-center shadow-md shadow-teal-600/20 whitespace-nowrap z-10 flex items-center justify-center gap-1.5">
                        Masuk Ruang Chat <i class="fa-solid fa-comments"></i>
                    </a>
                </div>
            @endif

            {{-- Hero Card Saldo + Branding Logo MBC --}}
            <div class="bg-gradient-to-br from-slate-900 via-teal-950 to-cyan-950 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden group">
                <div class="space-y-2 text-center md:text-left z-10">
                    <p class="text-teal-400 text-xs font-bold uppercase tracking-widest">Selamat Datang di Portal Medis</p>
                    <h3 class="text-2xl font-black tracking-tight">{{ $user->name }}</h3>
                    <div class="pt-4">
                        <p class="text-xs text-slate-400 font-medium">Sisa Saldo Konsultasi Anda:</p>
                        <h1 class="text-4xl font-black tracking-tight text-teal-300 mt-1">Rp{{ number_format($user->balance, 0, ',', '.') }}</h1>
                    </div>
                </div>
                
                {{-- Detail Rekening dengan background premium glassmorphism --}}
                <div class="bg-white/5 backdrop-blur-md p-5 rounded-2xl border border-white/10 text-sm max-w-xs space-y-1.5 z-10 w-full sm:w-auto relative">
                    <p class="font-bold text-teal-400 flex items-center gap-1.5 text-xs uppercase tracking-wider"><i class="fa-solid fa-bank"></i> Rekening Top-up:</p>
                    <p class="font-black text-base text-slate-100 tracking-wide">Bank BCA: 822-0192-XXX</p>
                    <p class="text-[11px] text-slate-400 font-semibold leading-tight">a.n PT Sekantin Engineering<br>(MBC Clinic)</p>
                </div>

                {{-- Watermark Logo Transparan di Sisi Background Belakang --}}
                <img src="{{ asset('images/logo_mbc.jpeg') }}" class="w-36 h-36 rounded-full object-cover absolute -right-6 -bottom-4 opacity-10 blur-[1px] group-hover:scale-105 transition duration-500 pointer-events-none">
            </div>

            {{-- MAIN LAYOUT TWO COLUMNS --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Mulai Konsultasi Cards --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-user-md text-teal-600"></i> Mulai Konsultasi Live Chat
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            {{-- Klinik Umum --}}
                            @php $umum = $tariffs->where('category', 'umum')->first(); @endphp
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-4 hover:border-emerald-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 text-lg shrink-0 shadow-inner">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">Klinik Umum</h4>
                                        <p class="text-xs text-emerald-600 font-extrabold mt-0.5">Rp{{ number_format($umum->price ?? 25000, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium leading-relaxed">Solusi keluhan kesehatan umum, resep obat ringan, dan pertolongan pertama mendesak.</p>
                                <a href="{{ route('chat.initiate', 'umum') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 rounded-xl text-xs shadow-sm transition block">Hubungi Dokter</a>
                            </div>

                            {{-- Klinik Kecantikan --}}
                            @php $cantik = $tariffs->where('category', 'kecantikan')->first(); @endphp
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-4 hover:border-pink-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600 text-lg shrink-0 shadow-inner">
                                        <i class="fa-solid fa-sparkles"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">Kecantikan</h4>
                                        <p class="text-xs text-pink-600 font-extrabold mt-0.5">Rp{{ number_format($cantik->price ?? 50000, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium leading-relaxed">Konsultasi masalah kulit, jerawat, bekas luka, rekomendasi skincare premium MBC.</p>
                                <a href="{{ route('chat.initiate', 'kecantikan') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 rounded-xl text-xs shadow-sm transition block">Hubungi Dokter</a>
                            </div>

                            {{-- Spesialis Gigi --}}
                            @php $gigi = $tariffs->where('category', 'gigi')->first(); @endphp
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-4 hover:border-sky-300 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 text-lg shrink-0 shadow-inner">
                                        <i class="fa-solid fa-tooth"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">Spesialis Gigi</h4>
                                        <p class="text-xs text-sky-600 font-extrabold mt-0.5">Rp{{ number_format($gigi->price ?? 35000, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium leading-relaxed">Keluhan sakit gigi, gusi bengkak, konsultasi kawat, atau scaling karang gigi.</p>
                                <a href="{{ route('chat.initiate', 'gigi') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 rounded-xl text-xs shadow-sm transition block">Hubungi Dokter</a>
                            </div>

                        </div>
                    </div>

                    {{-- Riwayat Konsultasi --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 pb-2 border-b border-slate-100">
                            <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> Riwayat Sesi Konsultasi Medis
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-200 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                                        <th class="pb-3">Waktu Selesai</th>
                                        <th class="pb-3">Klinik</th>
                                        <th class="pb-3">Dokter Pendamping</th>
                                        <th class="pb-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($chatHistory as $history)
                                    <tr class="text-slate-600 hover:bg-slate-50/50 transition group">
                                        <td class="py-3.5 text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($history->updated_at)->format('d M Y - H:i') }} WIB
                                        </td>
                                        <td class="py-3.5 font-bold text-slate-800 text-xs capitalize">
                                            Klinik {{ $history->category }}
                                        </td>
                                        <td class="py-3.5 text-xs">
                                            <span class="font-semibold text-slate-700">
                                                {{ $history->doctor->name ?? 'Tim Medis MBC' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 text-right">
                                            <a href="{{ route('chat.room', $history->id) }}" class="inline-flex items-center gap-1.5 text-[11px] bg-slate-50 hover:bg-teal-600 hover:text-white border border-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-xl transition-all duration-200">
                                                Rekam Medis <i class="fa-solid fa-file-medical"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-slate-400 text-xs">
                                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-300 text-xl mx-auto mb-2"><i class="fa-solid fa-folder-open"></i></div>
                                            <p class="font-bold text-slate-500">Belum ada riwayat konsultasi.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="space-y-6">
                    
                    {{-- Form Top-Up Saldo --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <h4 class="font-black text-slate-400 text-[11px] uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-wallet text-teal-600"></i> Konfirmasi Isi Saldo
                        </h4>
                        
                        <form action="{{ route('user.topup.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4"
                              onsubmit="return jalankanLoadingTopup(this);">
                            @csrf
                            <div>
                                <label class="block text-xs text-slate-600 mb-1 font-bold">Nominal Transfer (Rp)</label>
                                <input type="number" name="amount" placeholder="Mulai dari 10000" class="w-full bg-slate-50 border-slate-200 focus:border-teal-500 focus:ring-teal-500 rounded-xl text-xs font-semibold p-3 shadow-inner" min="10000" required>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-600 mb-1 font-bold">Bukti Transfer (Gambar)</label>
                                <input type="file" id="proof_image" name="proof_image" accept="image/jpeg, image/png, image/webp" class="w-full text-[11px] text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition" required>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">* Format: JPG, PNG, WEBP (Maks 2MB)</p>
                            </div>
                            
                            <button type="submit" id="btn-submit-topup" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl text-xs transition cursor-pointer flex items-center justify-center gap-2 shadow-md shadow-slate-900/10">
                                <i class="fa-solid fa-paper-plane text-[10px]"></i> Kirim Bukti Transfer
                            </button>
                        </form>
                    </div>

                    {{-- Status Pengajuan Top-up Terbaru --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                        <h4 class="font-black text-slate-400 text-[11px] uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-teal-600"></i> Status Top-up Terbaru
                        </h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 font-semibold">
                                        <th class="pb-2">Tanggal</th>
                                        <th class="pb-2">Jumlah</th>
                                        <th class="pb-2 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topups as $t)
                                    <tr class="border-b border-slate-50 text-slate-600 last:border-0 font-medium">
                                        <td class="py-3 text-slate-400">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}</td>
                                        <td class="py-3 font-bold text-slate-800">Rp{{ number_format($t->amount, 0, ',', '.') }}</td>
                                        <td class="py-3 text-right">
                                            <span class="px-2 py-0.5 text-[10px] rounded-md font-bold {{ $t->status == 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($t->status == 'approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                                {{ ucfirst($t->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-slate-400 text-[11px]">Belum ada riwayat pengisian.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- STATUS DOKTER ONLINE REAL-TIME --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 pb-2 border-b border-slate-100">
                            <i class="fa-solid fa-circle-nodes text-teal-600 animate-pulse"></i> Status Dokter Siaga
                        </h3>
                        <div class="space-y-3 max-h-[290px] overflow-y-auto pr-1">
                            @forelse($doctors as $doctor)
                            <div class="p-3 rounded-xl border border-slate-50 bg-slate-50/40 flex items-center gap-3 shadow-2xs">
                                <div class="relative shrink-0">
                                    <div class="w-9 h-9 bg-teal-700 text-white rounded-full flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($doctor->name, 0, 1) }}
                                    </div>
                                    <span id="status-dot-{{ $doctor->id }}"
                                          class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full border-2 border-white
                                                 {{ $doctor->is_online ? 'bg-green-500 animate-pulse' : 'bg-slate-300' }}">
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs text-slate-800 truncate leading-tight">{{ $doctor->name }}</p>
                                    <p class="text-[10px] font-medium capitalize text-slate-400 mt-0.5">Klinik {{ $doctor->clinic_category }}</p>
                                    <p id="status-text-{{ $doctor->id }}"
                                       class="text-[10px] font-bold mt-0.5 {{ $doctor->is_online ? 'text-green-500' : 'text-slate-400' }}">
                                        {{ $doctor->is_online ? '● Online' : '○ Offline' }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-slate-400 text-[11px] py-4">Belum ada dokter terdaftar.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- Script JavaScript --}}
    @push('scripts')
    <script>
        function jalankanLoadingTopup(formElement) {
            const fileInput = document.getElementById('proof_image');
            const tombol = document.getElementById('btn-submit-topup');
            
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = file.size / 1024 / 1024;
                const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
                
                if (!allowedExtensions.exec(file.name)) {
                    alert('Format file tidak cocok! Sila unggah gambar dengan format JPG, PNG, atau WEBP.');
                    fileInput.value = '';
                    return false;
                }
                
                if (fileSize > 2) {
                    alert('Ukuran file gambar terlalu besar! Maksimal ukuran adalah 2MB.');
                    fileInput.value = '';
                    return false;
                }
            }

            tombol.disabled = true;
            tombol.classList.add('opacity-50', 'cursor-not-allowed');
            tombol.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sedang Mengunggah...
            `;
            
            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Echo) return;

            window.Echo.channel('doctors.online')
                .listen('.status.changed', (data) => {
                    console.log('Status dokter berubah:', data);

                    const dot  = document.getElementById('status-dot-' + data.doctor_id);
                    const text = document.getElementById('status-text-' + data.doctor_id);

                    if (!dot || !text) return;

                    if (data.is_online) {
                        dot.classList.remove('bg-slate-300');
                        dot.classList.add('bg-green-500', 'animate-pulse');
                        text.classList.remove('text-slate-400');
                        text.classList.add('text-green-500');
                        text.textContent = '● Online';
                    } else {
                        dot.classList.remove('bg-green-500', 'animate-pulse');
                        dot.classList.add('bg-slate-300');
                        text.classList.remove('text-green-500');
                        text.classList.add('text-slate-400');
                        text.textContent = '○ Offline';
                    }
                });
        });
    </script>
    @endpush
</x-app-layout>