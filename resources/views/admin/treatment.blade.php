@extends('layouts.admin')
@section('admin_content')
<div class="grid md:grid-cols-3 gap-8 items-start">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
        <h3 class="font-bold text-slate-900 text-base">📦 Tambah Treatment Baru</h3>
        <form action="{{ route('admin.treatment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="name" placeholder="Nama Treatment" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <input type="text" name="solution" placeholder="Solusi Masalah Kulit/Medis" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <input type="number" name="price" placeholder="Harga Jual (Rp)" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <input type="number" name="discount" placeholder="Masukan discount" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm p-2.5" required>
            <div>
                <label class="block text-xs text-slate-400 mb-1 font-semibold">File Gambar Treatment (Max 2MB)</label>
                <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition">Upload Treatment</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 overflow-hidden">
        <h3 class="font-bold text-slate-900 mb-4">Daftar harga treatment Klinik</h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400">
                    <th class="pb-3 font-semibold">Gambar</th>
                    <th class="pb-3 font-semibold">Nama</th>
                    <th class="pb-3 font-semibold">Kategori</th>
                    <th class="pb-3 font-semibold">Harga</th>
                    <th class="pb-3 font-semibold">discount</th>
                    <th class="pb-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($treatment as $item)
                <tr class="border-b border-slate-50 text-slate-600">
                    <td class="py-3"><img src="{{ asset('storage/' . $item->image) }}" class="w-10 h-10 object-cover rounded-lg"></td>
                    <td class="py-3 font-medium text-slate-800">{{ $item->name }}</td>
                    <td class="py-3">{{ $item->solution }}</td>
                    <td class="py-3 font-semibold text-teal-600">Rp{{ number_format($item->price,0,',','.') }}</td>
                    <td class="py-3 font-semibold text-teal-600">{{$item->discount }} %</td>
                    <td class="py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Tombol Edit --}}
                            <button type="button"
                                onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->solution) }}', {{ $item->price }}, {{ $item->discount ?? 0 }}, '{{ asset('storage/' . $item->image) }}')"
                                class="text-teal-600 hover:text-teal-800 p-2 transition">
                                <i class="fa-regular fa-pen-to-square text-base"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.treatment.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus treatment ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 p-2 transition">
                                    <i class="fa-regular fa-trash-can text-base"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $treatment->links() }}
        </div>
    </div>
</div>

{{-- ✅ MODAL EDIT TREATMENT --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEditModal()"></div>

    {{-- Panel Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 space-y-4 z-10">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-base">✏️ Edit Treatment</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- Preview Gambar Saat Ini --}}
        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
            <img id="edit-preview-image" src="" alt="Preview" class="w-16 h-16 object-cover rounded-lg shrink-0">
            <div>
                <p class="text-xs text-slate-400 font-semibold">Gambar saat ini</p>
                <p id="edit-preview-name" class="text-sm font-bold text-slate-700 mt-0.5"></p>
            </div>
        </div>

        {{-- Form Edit --}}
        <form id="edit-form" action="" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-slate-500 mb-1 font-semibold">Nama Treatment</label>
                <input type="text" id="edit-name" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm p-2.5 focus:outline-none focus:border-teal-500" required>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1 font-semibold">Kategori / Solusi</label>
                <input type="text" id="edit-solution" name="solution" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm p-2.5 focus:outline-none focus:border-teal-500" required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-slate-500 mb-1 font-semibold">Harga (Rp)</label>
                    <input type="number" id="edit-price" name="price" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm p-2.5 focus:outline-none focus:border-teal-500" required>
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1 font-semibold">Discount</label>
                    <input type="number" id="edit-discount" name="discount" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm p-2.5 focus:outline-none focus:border-teal-500">
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1 font-semibold">Ganti Gambar <span class="text-slate-300">(opsional, max 2MB)</span></label>
                <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium py-2.5 rounded-xl text-sm transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl text-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id, name, solution, price, discount, imageUrl) {
        // Isi data ke form
        document.getElementById('edit-form').action = `/admin/treatment/update/${id}`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-solution').value = solution;
        document.getElementById('edit-price').value = price;
        document.getElementById('edit-discount').value = discount;
        document.getElementById('edit-preview-image').src = imageUrl;
        document.getElementById('edit-preview-name').textContent = name;

        // Tampilkan modal
        document.getElementById('edit-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Cegah scroll background
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Tutup modal kalau tekan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeEditModal();
    });
</script>
@endpush
@endsection