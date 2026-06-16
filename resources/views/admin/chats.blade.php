@extends('layouts.admin')
@section('admin_content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="mb-4">
        <h3 class="font-bold text-slate-900">Takeover & Pengembalian Poin/Saldo</h3>
        <p class="text-xs text-slate-400 mt-0.5">Daftar room chat aktif yang tidak direspons dokter karena offline. Admin harus membalas atau mengembalikan saldo.</p>
    </div>
    <table class="w-full text-left border-collapse text-sm">
        <thead><tr class="border-b border-slate-100 text-slate-400"><th class="pb-3 font-semibold">Nama Pasien</th><th class="pb-3 font-semibold">Kategori Spesialis</th><th class="pb-3 font-semibold">Tarif Konsultasi</th><th class="pb-3 font-semibold text-center">Tindakan Admin</th></tr></thead>
        <tbody>
            @forelse($rooms as $room)
            <tr class="border-b border-slate-50 text-slate-600">
                <td class="py-4 font-semibold text-slate-800">{{ $room->user_name }}</td>
                <td class="py-4 uppercase text-xs font-bold text-slate-500">{{ $room->category }}</td>
                <td class="py-4 font-semibold">Rp{{ number_format($room->price_at_time,0,',','.') }}</td>
                <td class="py-4 flex justify-center space-x-2">
                    <!-- Tombol Balas (Nanti diarahkan ke halaman live chat admin) -->
                    <a href="#" class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-800">Balat Chat</a>
                    
                    <!-- Tombol Batalkan & Balikkan Saldo Otomatis -->
                    <form action="{{ route('admin.chat.refund', $room->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-rose-50 border border-rose-200 text-rose-600 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-rose-100">Dokter Offline (Refund + Reschedule)</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-8 text-center text-slate-400 text-xs">Semua room chat aman atau dokter sedang online membalas aktif.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $rooms->links() }}</div>
</div>
@endsection