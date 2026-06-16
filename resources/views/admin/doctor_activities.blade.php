@extends('layouts.admin')
@section('admin_content')
<div class="space-y-8">

    {{-- Filter Bulan --}}
    <form method="GET" action="{{ route('admin.doctors.activities') }}" 
          class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-4">
        <label class="text-xs font-semibold text-slate-500">Filter Bulan:</label>
        <select name="month" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-teal-500">
            @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
            @endforeach
        </select>
        <select name="year" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-teal-500">
            @foreach(range(now()->year - 1, now()->year + 1) as $y)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
            Tampilkan
        </button>
    </form>

    {{-- Komisi Per Dokter --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-1">💼 Komisi Dokter — 
            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
        </h3>
        <p class="text-xs text-slate-400 mb-4">Status pembayaran komisi dokter bulan ini.</p>
        
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase">
                    <th class="pb-3 font-semibold">Dokter</th>
                    <th class="pb-3 font-semibold text-center">Total Chat</th>
                    <th class="pb-3 font-semibold text-right">Total Komisi</th>
                    <th class="pb-3 font-semibold text-center">Status</th>
                    <th class="pb-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $c)
                <tr class="border-b border-slate-50 text-slate-600">
                    {{-- FIX: Menggunakan doctor_name hasil JOIN manual --}}
                    <td class="py-3 font-bold text-slate-800">{{ $c->doctor_name ?? 'Dokter Tidak Ditemukan' }}</td>
                    <td class="py-3 text-center text-slate-500">{{ $c->total_chats ?? 0 }} sesi</td>
                    <td class="py-3 font-bold text-emerald-600 text-right">
                        Rp{{ number_format($c->total_commission ?? 0, 0, ',', '.') }}
                    </td>
                    
                    {{-- Status Badge (Kebal Huruf Kapital) --}}
                    <td class="py-3 text-center">
                        @if(strtolower($c->status) === 'paid')
                            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
                                ✅ Lunas
                            </span>
                            @if($c->paid_at)
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($c->paid_at)->format('d M Y H:i') }}
                                </p>
                            @endif
                        @else
                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                ⏳ Belum Dibayar
                            </span>
                        @endif
                    </td>

                    {{-- Tombol Aksi "Tandai Lunas" --}}
                    <td class="py-3 text-center">
                        @if(strtolower($c->status) === 'unpaid' || strtolower($c->status) === 'pending' || empty($c->status))
                            {{-- FIX: Confirm alert dialihkan memakai $c->doctor_name --}}
                            <form action="{{ route('admin.commission.pay', $c->id) }}" method="POST"
                                onsubmit="return confirm('Tandai komisi {{ $c->doctor_name }} sudah dibayar?')">
                                @csrf
                                <button type="submit" 
                                        class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl transition">
                                    Tandai Lunas
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-slate-300">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                        Tidak ada data komisi untuk bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </div>

    {{-- Log Chat Selesai --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-1">📋 Log Chat Selesai — 
            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
        </h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase">
                    <th class="pb-3 font-semibold">Dokter</th>
                    <th class="pb-3 font-semibold">Pasien</th>
                    <th class="pb-3 font-semibold">Biaya</th>
                    <th class="pb-3 font-semibold">Komisi</th>
                    <th class="pb-3 font-semibold">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completedChats as $chat)
                <tr class="border-b border-slate-50 text-slate-600">
                    <td class="py-3 font-semibold text-slate-800">{{ $chat->doctor_name }}</td>
                    <td class="py-3">{{ $chat->patient_name }}</td>
                    <td class="py-3 text-slate-500">Rp{{ number_format($chat->price_at_time, 0, ',', '.') }}</td>
                    <td class="py-3 font-bold text-emerald-600">Rp{{ number_format($chat->commission_earned, 0, ',', '.') }}</td>
                    <td class="py-3 text-xs text-slate-400">
                        {{ \Carbon\Carbon::parse($chat->updated_at)->format('d M Y - H:i') }} WIB
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-slate-400 text-xs">
                        Belum ada chat selesai bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $completedChats->links() }}</div>
    </div>

</div>
@endsection