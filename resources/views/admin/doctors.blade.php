@extends('layouts.admin')
@section('admin_content')
<div class="grid md:grid-cols-3 gap-8 items-start">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
        <h3 class="font-bold text-slate-900 text-base">🩺 Daftarkan Dokter Baru</h3>
        <form action="{{ route('admin.doctor.store') }}" method="POST" class="space-y-3">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap Dokter (e.g. dr. Linda)" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <input type="email" name="email" placeholder="Email Akun Login" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            
            <div>
                <label class="block text-xs text-slate-400 mb-1 font-semibold">Spesialisasi Klinik</label>
                <select name="specialist" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
                    <option value="umum">🩺 Klinik Umum</option>
                    <option value="kecantikan">✨ Klinik Kecantikan (Estetika)</option>
                    <option value="gigi">🦷 Dokter Gigi</option>
                </select>
            </div>

            <input type="password" name="password" placeholder="Password Akun (Min 8 Karakter)" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition">Daftarkan Dokter</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-4">Tim Dokter Aktif</h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400">
                    <th class="pb-3 font-semibold">Nama Dokter</th>
                    <th class="pb-3 font-semibold">Spesialisasi</th>
                    <th class="pb-3 font-semibold text-center">Aksi Kontrol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doc)
                <tr class="border-b border-slate-50 text-slate-600">
                    <td class="py-3 font-bold text-slate-800">{{ $doc->name }}<br><span class="text-xs font-normal text-slate-400">{{ $doc->email }}</span></td>
                    <td class="py-3">
                        <span class="px-2.5 py-1 text-xs rounded-full font-semibold {{ $doc->specialist == 'kecantikan' ? 'bg-pink-50 text-pink-700' : ($doc->specialist == 'gigi' ? 'bg-sky-50 text-sky-700' : 'bg-emerald-50 text-emerald-700') }}">
                            {{ ucfirst($doc->clinic_category) }}
                        </span>
                    </td>
                    <td class="py-3 flex justify-center space-x-2">
                        <!-- Reset Password -->
                        <form action="{{ route('admin.user.reset_password', $doc->id) }}" method="POST" onsubmit="return confirm('Reset password dokter ini jadi password123?')">
                            @csrf
                            <button type="submit" class="bg-amber-50 text-amber-600 border border-amber-200 px-2 py-1 rounded-lg text-xs font-medium hover:bg-amber-100">
                                <i class="fa-solid fa-key"></i> Reset
                            </button>
                        </form>
                        <!-- Hapus Dokter -->
                        <form action="{{ route('admin.doctor.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun dokter ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-50 text-rose-600 border border-rose-200 px-2 py-1 rounded-lg text-xs font-medium hover:bg-rose-100">
                                <i class="fa-regular fa-trash-can"></i> Haps
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $doctors->links() }}</div>
    </div>
</div>
@endsection