@extends('layouts.app')

@section('title', 'Kelola Inventaris')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#003d79]">📦 Daftar Inventaris</h1>
            <p class="text-gray-500 text-xs md:text-sm">Total: {{ $items->count() }} Alat</p>
        </div>
        <a href="{{ route('items.create') }}" class="bg-[#003d79] text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition shadow flex items-center gap-2 text-sm font-bold">
            <span>+</span> <span class="hidden md:inline">Tambah Alat</span>
        </a>
    </div>

    <div class="hidden md:block bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="p-4 border-b">Kode QR</th>
                    <th class="p-4 border-b">Nama Alat</th>
                    <th class="p-4 border-b">Kategori</th>
                    <th class="p-4 border-b">Status</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                @forelse($items as $item)
                <tr class="hover:bg-blue-50 transition">
                    <td class="p-4 font-mono text-xs text-gray-500">{{ $item->inventory_code }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $item->name }}</td>
                    <td class="p-4"><span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full border">{{ $item->category->name }}</span></td>
                    <td class="p-4">
                        @if($item->status == 'ready') <span class="text-green-600 font-bold text-xs">● Ready</span>
                        @elseif($item->status == 'borrowed') <span class="text-blue-600 font-bold text-xs">● Dipinjam</span>
                        @else <span class="text-red-600 font-bold text-xs">● {{ ucfirst($item->status) }}</span> @endif
                    </td>
                    <td class="p-4 text-center flex justify-center gap-2">
                        <a href="{{ route('items.edit', $item->id) }}" class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($items as $item)
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex gap-4">
            <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                @if($item->image_url)
                    <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400 text-lg">📷</div>
                @endif
            </div>
            
            <div class="flex-grow">
                <div class="flex justify-between items-start">
                    <h3 class="font-bold text-gray-800 text-sm">{{ $item->name }}</h3>
                    <span class="text-[10px] font-mono text-gray-400">{{ $item->inventory_code }}</span>
                </div>
                <p class="text-xs text-gray-500 mb-2">{{ $item->category->name }}</p>
                
                <div class="flex justify-between items-center mt-2">
                    @if($item->status == 'ready') <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded font-bold">Ready</span>
                    @elseif($item->status == 'borrowed') <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-1 rounded font-bold">Dipinjam</span>
                    @else <span class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded font-bold">Maintenence</span> @endif

                    <div class="flex gap-2">
                        <a href="{{ route('items.edit', $item->id) }}" class="text-yellow-600 font-bold text-xs border border-yellow-200 px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold text-xs border border-red-200 px-2 py-1 rounded">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-10">Belum ada data.</div>
        @endforelse
    </div>

</div>
@endsection