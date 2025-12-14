@extends('layouts.app')

@section('title', 'Edit Alat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-[#003d79]">✏️ Edit Alat</h1>
        <a href="{{ route('items.index') }}" class="text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nama Alat</label>
                    <input type="text" name="name" value="{{ $item->name }}" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kode Inventaris</label>
                    <input type="text" name="inventory_code" value="{{ $item->inventory_code }}" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                    <select name="category_id" class="w-full border p-2 rounded bg-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status</label>
                    <select name="status" class="w-full border p-2 rounded bg-white">
                        <option value="ready" {{ $item->status == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="maintenance" {{ $item->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="lost" {{ $item->status == 'lost' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 font-bold mb-2">Update Foto (Biarkan kosong jika tidak ganti)</label>
                @if($item->image_url)
                    <div class="mb-2">
                        <img src="{{ Storage::url($item->image_url) }}" class="h-20 w-20 object-cover rounded border">
                    </div>
                @endif
                <input type="file" name="image" class="w-full border p-2 rounded bg-gray-50 text-sm">
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none">{{ $item->description }}</textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('items.index') }}" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#003d79] text-white rounded hover:bg-blue-900 transition shadow font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection