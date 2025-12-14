@extends('layouts.app')

@section('title', 'Tambah Alat Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-[#003d79]">➕ Tambah Alat Baru</h1>
        <a href="{{ route('items.index') }}" class="text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nama Alat</label>
                    <input type="text" name="name" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kode Inventaris</label>
                    <input type="text" name="inventory_code" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="category_id" class="w-full border p-2 rounded bg-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status Awal</label>
                    <select name="status" class="w-full border p-2 rounded bg-white">
                        <option value="ready">Ready (Bisa Dipinjam)</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 font-bold mb-2">Foto Alat (Opsional)</label>
                <input type="file" name="image" class="w-full border p-2 rounded bg-gray-50 text-sm">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('items.index') }}" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#003d79] text-white rounded hover:bg-blue-900 transition shadow font-bold">Simpan Alat</button>
            </div>
        </form>
    </div>
</div>
@endsection