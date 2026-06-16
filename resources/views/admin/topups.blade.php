@extends('layouts.admin')
@section('admin_content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <h3 class="font-bold text-slate-900 mb-4">Verifikasi Pengisian Saldo (Top-up) Pasien</h3>
    <table class="w-full text-left border-collapse text-sm">
        <thead><tr class="border-b border-slate-100 text-slate-400"><th class="pb-3 font-semibold">Nama User</th><th class="pb-3 font-semibold">Jumlah Topup</th><th class="pb-3 font-semibold">Bukti Transfer</th><th class="pb-3 font-semibold">Status</th><th class="pb-3 font-semibold text-center">Aksi</th></tr></thead>
        <tbody>
            @foreach($topups as $t)
            <tr class="border-b border-slate-50 text-slate-600">
                <td class="py-4"><b>{{ $t->user_name }}</b><br><span class="text-xs text-slate-400">{{ $t->email }}</span></td>
                <td class="py-4 font-bold text-slate-800">Rp{{ number_format($t->amount,0,',','.') }}</td>
                <td class="py-4"><a href="{{ asset('storage/' . $t->proof_image) }}" target="_blank" class="text-teal-600 hover:underline text-xs"><i class="fa-solid fa-image"></i> Lihat Bukti</a></td>
                <td class="py-4"><span class="px-2 py-1 text-xs rounded-full font-semibold {{ $t->status == 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : ($t->status == 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500') }}">{{ ucfirst($t->status) }}</span></td>
                <td class="py-4 text-center">
                    @if($t->status == 'pending')
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('admin.topup.verify', ['id' => $t->id, 'status' => 'approved']) }}" class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-emerald-700 transition">Setujui</a>
                        <a href="{{ route('admin.topup.verify', ['id' => $t->id, 'status' => 'rejected']) }}" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Tolak</a>
                    </div>
                    @else
                    <span class="text-xs text-slate-400">Selesai diproses</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $topups->links() }}</div>
</div>
@endsection