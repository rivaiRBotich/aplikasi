@extends('layouts.admin')
@section('admin_content')
<div class="space-y-6">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div><p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pasien</p><h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalUsers }}</h3></div>
            <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600"><i class="fa-solid fa-users text-lg"></i></div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div><p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Dokter Terdaftar</p><h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalDoctors }}</h3></div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600"><i class="fa-solid fa-user-md text-lg"></i></div>
        </div>
        {{-- ✅ BARU — id ditambahkan agar bisa diupdate via JS, plus badge "live" --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between relative overflow-hidden">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    Permohonan Saldo Pending
                    <span class="flex h-1.5 w-1.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-500"></span>
                    </span>
                </p>
                <h3 id="pending-topup-count" class="text-2xl font-bold text-rose-600 mt-1">{{ $pendingTopups }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600"><i class="fa-solid fa-receipt text-lg"></i></div>
        </div>
    </div>

    <!-- TARIF CHAT -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider text-slate-400">💰 Pengaturan Tarif Live Chat</h3>
        <form action="{{ route('admin.tariff.update') }}" method="POST" class="grid md:grid-cols-4 gap-4 items-end">
            @csrf
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Klinik Umum (Rp)</label><input type="number" name="price_umum" value="{{ $tariffs->where('category', 'umum')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Klinik Kecantikan (Rp)</label><input type="number" name="price_kecantikan" value="{{ $tariffs->where('category', 'kecantikan')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Dokter Gigi (Rp)</label><input type="number" name="price_gigi" value="{{ $tariffs->where('category', 'gigi')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <button type="submit" class="bg-slate-950 hover:bg-slate-800 text-white font-medium py-2.5 px-5 rounded-xl text-sm transition">Simpan Pengaturan</button>
        </form>
    </div>

    <!-- Input Bank -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider text-slate-400">Update Account bank</h3>
        <form action="{{ route('admin.bank.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">
                    Nama Bank
                </label>
                <input
                    type="text"
                    name="nama_bank"
                    placeholder="Masukkan Nama Bank : Contoh Bank BCA"
                    value="{{ $bank-> nama_bank}}"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">
                    Account Rekening Bank
                </label>
                <input
                    type="text"
                    name="account"
                    placeholder="Input Acount bank contoh :822-xxxx-xxx"
                    value="{{ $bank-> account}}"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">
                    Nama Penerima
                </label>
                <input
                    type="text"
                    name="nama_penerima"
                    placeholder="Input Nama Penerima"
                    value="{{ $bank-> nama_penerima}}"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">
                    Nomor Whatsapp
                </label>
                <input
                    type="text"
                    name="phone"
                    placeholder="Input Nomor Whatsapp Contoh : 6285830136749"
                    value="{{ $bank-> phone}}"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5">
            </div>

            <button
                type="submit"
                class="bg-slate-950 hover:bg-slate-800 text-white font-medium py-2.5 px-5 rounded-xl text-sm transition">
                Simpan Pengaturan
            </button>
        </form>
    </div>
    {{-- ✅ BARU — Toast notifikasi muncul saat ada topup baru masuk --}}
    <div id="topup-toast" class="hidden fixed bottom-6 right-6 bg-white border border-rose-200 shadow-xl rounded-2xl p-4 max-w-sm z-50">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div class="text-sm">
                <p class="font-bold text-slate-800">Permohonan Top-up Baru!</p>
                <p id="topup-toast-text" class="text-xs text-slate-500 mt-0.5"></p>
                <a href="{{ route('admin.topups') }}" class="text-xs text-teal-600 font-bold mt-1.5 inline-block">Lihat detail →</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) return;

        window.Echo.channel('admin.topups')
            .listen('.topup.created', (data) => {
                console.log('Topup baru masuk:', data);

                // Update angka pending
                const counter = document.getElementById('pending-topup-count');
                if (counter) {
                    counter.textContent = parseInt(counter.textContent) + 1;
                }

                // Tampilkan toast notifikasi
                const toast = document.getElementById('topup-toast');
                const toastText = document.getElementById('topup-toast-text');
                if (toast && toastText) {
                    toastText.textContent = `${data.user_name} mengajukan top-up Rp${parseInt(data.amount).toLocaleString('id-ID')}`;
                    toast.classList.remove('hidden');

                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 6000);
                }
            });
    });
</script>
@endpush
@endsection