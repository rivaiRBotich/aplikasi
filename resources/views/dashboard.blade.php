<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Pasien - MBC Clinic') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Menampilkan Error Validasi Laravel jika lolos ke server --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm space-y-1">
                    <p class="font-bold">Gagal Mengirim data:</p>
                    <ul class="list-disc pl-5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Banner Sesi Aktif --}}
            @if(isset($activeChat) && $activeChat)
                <div class="bg-teal-50 border border-teal-200 p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-4 shadow-sm">
                    <div class="text-sm text-teal-900">
                        <span class="font-bold">📢 Sesi Konsultasi Anda Sedang Berjalan!</span><br>
                        <p class="text-xs text-teal-700/80 mt-0.5">Anda sudah membayar untuk Layanan Chat Klinik <span class="capitalize font-bold text-teal-800">{{ $activeChat->category }}</span>. Silakan langsung masuk kembali ke ruang percakapan.</p>
                    </div>
                    <a href="{{ route('chat.room', $activeChat->id) }}" class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-6 py-3 rounded-xl transition text-center shadow-lg shadow-teal-600/20 whitespace-nowrap">
                        Masuk Ruang Chat <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif

            {{-- Hero Card Saldo --}}
            <div class="bg-gradient-to-r from-teal-700 to-cyan-800 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <p class="text-teal-200 text-xs font-bold uppercase tracking-wider">Selamat Datang, Pasien</p>
                    <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                    <div class="pt-2">
                        <p class="text-xs text-teal-100/70">Sisa Saldo Konsultasi Anda:</p>
                        <h1 class="text-4xl font-black mt-1">Rp{{ number_format($user->balance, 0, ',', '.') }}</h1>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10 text-sm max-w-xs space-y-1">
                    <p class="font-bold text-teal-300"><i class="fa-solid fa-bank"></i> Rekening Top-up Klinik:</p>
                    <p class="font-semibold">Bank BCA: 822-0192-XXX</p>
                    <p class="text-xs text-white/70">a.n PT Sekantin Engineering (MBC Clinic)</p>
                </div>
            </div>

            {{-- STATUS DOKTER ONLINE --}}
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-slate-900">👨‍⚕️ Status Dokter</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($doctors as $doctor)
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                        <div class="relative shrink-0">
                            <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm uppercase">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                            <span id="status-dot-{{ $doctor->id }}"
                                  class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white
                                         {{ $doctor->is_online ? 'bg-green-500' : 'bg-slate-300' }}">
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-slate-800 truncate">{{ $doctor->name }}</p>
                            <p class="text-xs capitalize text-slate-400">Klinik {{ $doctor->clinic_category }}</p>
                            <p id="status-text-{{ $doctor->id }}"
                               class="text-xs font-semibold mt-0.5 {{ $doctor->is_online ? 'text-green-500' : 'text-slate-400' }}">
                                {{ $doctor->is_online ? '● Online' : '○ Offline' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 text-center text-slate-400 text-xs py-6">
                        Belum ada dokter terdaftar.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Mulai Konsultasi --}}
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900">🩺 Mulai Konsultasi Live Chat</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    
                    @php $umum = $tariffs->where('category', 'umum')->first(); @endphp
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 text-xl"><i class="fa-solid fa-user-doctor"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-800">Klinik Umum</h4>
                                <p class="text-xs text-emerald-600 font-bold">Rp{{ number_format($umum->price ?? 25000, 0, ',', '.') }} / sesi</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Solusi keluhan kesehatan umum, resep obat ringan, dan pertolongan pertama.</p>
                        <a href="{{ route('chat.initiate', 'umum') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 rounded-xl text-xs transition block">Hubungi Dokter</a>
                    </div>

                    @php $cantik = $tariffs->where('category', 'kecantikan')->first(); @endphp
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600 text-xl"><i class="fa-solid fa-sparkles"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-800">Klinik Kecantikan</h4>
                                <p class="text-xs text-pink-600 font-bold">Rp{{ number_format($cantik->price ?? 50000, 0, ',', '.') }} / sesi</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Konsultasi masalah kulit, jerawat, bekas luka, rekomendasi produk skincare premium MBC Klinik.</p>
                        <a href="{{ route('chat.initiate', 'kecantikan') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 rounded-xl text-xs transition block">Hubungi Dokter</a>
                    </div>

                    @php $gigi = $tariffs->where('category', 'gigi')->first(); @endphp
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 text-xl"><i class="fa-solid fa-tooth"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-800">Spesialis Gigi</h4>
                                <p class="text-xs text-sky-600 font-bold">Rp{{ number_format($gigi->price ?? 35000, 0, ',', '.') }} / sesi</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Keluhan sakit gigi, gusi bengkak, konsultasi pasang kawat, atau pembersihan karang gigi.</p>
                        <a href="{{ route('chat.initiate', 'gigi') }}" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 rounded-xl text-xs transition block">Hubungi Dokter</a>
                    </div>

                </div>
            </div>

            {{-- Riwayat Konsultasi --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> Riwayat Konsultasi Medis Anda
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase tracking-wider">
                                <th class="pb-3 font-semibold">Tanggal Selesai</th>
                                <th class="pb-3 font-semibold">Klinik Layanan</th>
                                <th class="pb-3 font-semibold">Dokter Pendamping</th>
                                <th class="pb-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($chatHistory as $history)
                            <tr class="text-slate-600 hover:bg-slate-50/50 transition">
                                <td class="py-3.5 text-xs text-slate-400">
                                    {{ \Carbon\Carbon::parse($history->updated_at)->format('d M Y - H:i') }} WIB
                                </td>
                                <td class="py-3.5 font-medium text-slate-800 capitalize">
                                    Klinik {{ $history->category }}
                                </td>
                                <td class="py-3.5 text-xs">
                                    <span class="font-semibold text-slate-700">
                                        {{ $history->doctor->name ?? 'Tim Medis MBC' }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('chat.room', $history->id) }}" class="inline-flex items-center gap-1 text-xs bg-teal-50 hover:bg-teal-100 text-teal-700 font-bold px-3 py-1.5 rounded-xl transition">
                                        Lihat Transkrip <i class="fa-solid fa-book-medical text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 text-xs">
                                    <div class="text-slate-300 text-3xl mb-2"><i class="fa-solid fa-folder-open"></i></div>
                                    <p class="font-medium text-slate-400">Anda belum memiliki riwayat sesi konsultasi yang selesai.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top-up & Status --}}
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <h4 class="font-bold text-slate-900 text-sm uppercase tracking-wider text-slate-400">💵 Isi Saldo Konsultasi</h4>
                    
                    <form action="{{ route('user.topup.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3"
                          onsubmit="return jalankanLoadingTopup(this);">
                        @csrf
                        <div>
                            <label class="block text-xs text-slate-500 mb-1 font-semibold">Nominal Isi Saldo (Rp)</label>
                            <input type="number" name="amount" placeholder="Contoh: 50000" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" min="10000" required>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 mb-1 font-semibold">Unggah Bukti Transfer (Format: JPG, PNG, WEBP | Max 2MB)</label>
                            {{-- FORCE TYPE: Memaksa file explorer komputer memilih tipe gambar saja --}}
                            <input type="file" id="proof_image" name="proof_image" accept="image/jpeg, image/png, image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
                        </div>
                        
                        <button type="submit" id="btn-submit-topup" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-2.5 rounded-xl text-sm transition cursor-pointer flex items-center justify-center gap-2">
                            Kirim Bukti Transfer
                        </button>
                    </form>
                </div>

                <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold text-slate-900 text-sm mb-4 uppercase tracking-wider text-slate-400">📋 Status Pengajuan Saldo Terbaru</h4>
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400">
                                <th class="pb-2">Tanggal</th>
                                <th class="pb-2">Jumlah</th>
                                <th class="pb-2 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topups as $t)
                            <tr class="border-b border-slate-50 text-slate-600">
                                <td class="py-3 text-xs text-slate-400">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}</td>
                                <td class="py-3 font-semibold text-slate-800">Rp{{ number_format($t->amount, 0, ',', '.') }}</td>
                                <td class="py-3 text-right">
                                    <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $t->status == 'pending' ? 'bg-amber-50 text-amber-700' : ($t->status == 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700') }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-slate-400 text-xs">Belum ada riwayat pengisian saldo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                const fileSize = file.size / 1024 / 1024; // Ubah ke satuan MB
                const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
                
                // 1. Validasi Ekstensi Gambar Terlarang di Browser
                if (!allowedExtensions.exec(file.name)) {
                    alert('Format file tidak cocok! Sila unggah gambar dengan format JPG, PNG, atau WEBP.');
                    fileInput.value = ''; // Reset pilihan file
                    return false;
                }
                
                // 2. Validasi Ukuran Maksimal 2MB di Browser
                if (fileSize > 2) {
                    alert('Ukuran file gambar terlalu besar! Maksimal ukuran adalah 2MB.');
                    fileInput.value = ''; // Reset pilihan file
                    return false;
                }
            }

            // Kunci tombol & Jalankan animasi loading jika validasi aman
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
                        dot.classList.add('bg-green-500');
                        text.classList.remove('text-slate-400');
                        text.classList.add('text-green-500');
                        text.textContent = '● Online';
                    } else {
                        dot.classList.remove('bg-green-500');
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