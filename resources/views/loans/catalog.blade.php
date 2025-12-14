@extends('layouts.app')

@section('title', 'Katalog Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="md:flex justify-between items-center gap-4">
            
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-[#003d79]">📷 Katalog Alat</h1>
                <p class="text-gray-500 text-sm">Cari dan pinjam alat sesuai kebutuhan Anda.</p>
            </div>

            <form action="{{ route('loans.catalog') }}" method="GET" class="mt-4 md:mt-0 flex flex-col md:flex-row gap-3 w-full md:w-auto">
                
                <select name="category_id" class="w-full md:w-auto border p-2 rounded-lg text-sm bg-gray-50 focus:ring-2 focus:ring-[#003d79] outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <div class="relative w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat..." class="w-full md:w-64 pl-3 pr-10 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#003d79] outline-none">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#003d79]">
                        🔍
                    </button>
                </div>
                
                @if(request('search') || request('category_id'))
                    <a href="{{ route('loans.catalog') }}" class="w-full md:w-auto px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-300 transition text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($items as $item)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 border border-gray-100 flex flex-col">
            <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden relative group">
                @if($item->image_url)
                    <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                @else
                    <span class="text-gray-400 text-4xl">📷</span>
                @endif
                
                <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-[#003d79] text-[10px] px-2 py-1 rounded font-bold shadow-sm">
                    {{ $item->category->name }}
                </span>
            </div>
            
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 line-clamp-1" title="{{ $item->name }}">{{ $item->name }}</h3>
                    <p class="text-xs text-gray-400 mb-2 font-mono">{{ $item->inventory_code }}</p>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 h-10 leading-snug">
                        {{ $item->description ?? 'Tidak ada deskripsi alat.' }}
                    </p>
                </div>
                
                <div class="pt-3 border-t flex justify-between items-center">
                    <span class="text-green-600 font-bold text-xs flex items-center gap-1 bg-green-50 px-2 py-1 rounded">
                        ● Ready
                    </span>
                    
                    <a href="{{ route('loans.create', $item->id) }}" class="bg-[#003d79] text-white px-4 py-1.5 rounded text-sm hover:bg-blue-900 transition shadow font-medium">
                        Pinjam
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="inline-block p-4 rounded-full bg-gray-100 mb-4 text-4xl">🔍</div>
            <h3 class="text-lg font-bold text-gray-600">Alat tidak ditemukan</h3>
            <p class="text-gray-500 text-sm">Coba cari dengan kata kunci lain atau reset filter.</p>
            <a href="{{ route('loans.catalog') }}" class="mt-4 inline-block text-[#003d79] hover:underline">Reset Pencarian</a>
        </div>
        @endforelse
    </div>
</div>
@endsection