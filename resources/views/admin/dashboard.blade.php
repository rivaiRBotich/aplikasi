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
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div><p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Permohonan Saldo Pending</p><h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $pendingTopups }}</h3></div>
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600"><i class="fa-solid fa-receipt text-lg"></i></div>
        </div>
    </div>

    <!-- TARIF CHAT -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider text-slate-400">💰 Pengaturan Tarif Live Chat Dokter</h3>
        <form action="{{ route('admin.tariff.update') }}" method="POST" class="grid md:grid-cols-4 gap-4 items-end">
            @csrf
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Klinik Umum (Rp)</label><input type="number" name="price_umum" value="{{ $tariffs->where('category', 'umum')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Klinik Kecantikan (Rp)</label><input type="number" name="price_kecantikan" value="{{ $tariffs->where('category', 'kecantikan')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <div><label class="block text-xs font-semibold text-slate-500 mb-1">Dokter Gigi (Rp)</label><input type="number" name="price_gigi" value="{{ $tariffs->where('category', 'gigi')->first()->price ?? 0 }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5"></div>
            <button type="submit" class="bg-slate-950 hover:bg-slate-800 text-white font-medium py-2.5 px-5 rounded-xl text-sm transition">Simpan Aturan</button>
        </form>
    </div>
</div>
@endsection