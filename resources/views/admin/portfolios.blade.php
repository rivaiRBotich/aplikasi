@extends('layouts.admin')
@section('admin_content')
<div class="grid md:grid-cols-3 gap-8 items-start">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
        <h3 class="font-bold text-slate-900 text-base">📰 Post Kegiatan Baru</h3>
        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="title" placeholder="Judul Kegiatan / Berita" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <input type="text" name="category" placeholder="Kategori (Event / Edukasi)" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <textarea name="excerpt" placeholder="Deskripsi ringkas..." class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5 h-20" required></textarea>
            <div>
                <label class="block text-xs text-slate-400 mb-1 font-semibold">Foto Kegiatan (Max 2MB)</label>
                <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition">Post Sekarang</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-4">Portofolio Kegiatan Terpublikasi</h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400">
                    <th class="pb-3 font-semibold">Gambar</th>
                    <th class="pb-3 font-semibold">Judul</th>
                    <th class="pb-3 font-semibold">Kategori</th>
                    <th class="pb-3 font-semibold text-center">Aksi</th> </tr>
            </thead>
            <tbody>
                @foreach($portfolios as $p)
                <tr class="border-b border-slate-50 text-slate-600">
                    <td class="py-3"><img src="{{ asset('storage/' . $p->image) }}" class="w-12 h-10 object-cover rounded-lg"></td>
                    <td class="py-3 font-medium text-slate-800">{{ $p->title }}</td>
                    <td class="py-3 text-xs"><span class="bg-slate-100 px-2 py-1 rounded-full">{{ $p->category }}</span></td>
                    <td class="py-3 text-center">
                        <form action="{{ route('admin.portfolio.delete', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 p-2 transition">
                                <i class="fa-regular fa-trash-can text-base"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $portfolios->links() }}</div>
    </div>
</div>
@endsection