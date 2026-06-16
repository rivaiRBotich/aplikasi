@extends('layouts.admin')
@section('admin_content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="mb-4">
        <h3 class="font-bold text-slate-900">Daftar Pasien Terdaftar</h3>
        <p class="text-xs text-slate-400 mt-0.5">Berikut adalah seluruh data rekam pengguna/pasien yang terregistrasi di sistem MBC Clinic.</p>
    </div>
    <table class="w-full text-left border-collapse text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-slate-400">
                <th class="pb-3 font-semibold">Nama Pasien</th>
                <th class="pb-3 font-semibold">Tanggal Bergabung</th>
                <th class="pb-3 font-semibold text-right">Sisa Saldo</th>
                <th class="pb-3 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b border-slate-50 text-slate-600">
                <td class="py-3.5 font-semibold text-slate-800">{{ $user->name }}<br><span class="text-xs font-normal text-slate-400">{{ $user->email }}</span></td>
                <td class="py-3.5 text-slate-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                <td class="py-3.5 font-bold text-teal-600 text-right">Rp{{ number_format($user->balance, 0, ',', '.') }}</td>
                <td class="py-3.5 text-center">
                    <form action="{{ route('admin.user.reset_password', $user->id) }}" method="POST" onsubmit="return confirm('Reset password pasien ini jadi password123?')">
                        @csrf
                        <button type="submit" class="text-amber-600 hover:text-amber-800 text-xs font-medium border border-amber-200 px-2 py-1 rounded-lg bg-amber-50">
                            <i class="fa-solid fa-key"></i> Reset Password
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection