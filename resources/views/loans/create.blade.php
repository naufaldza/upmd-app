@extends('layouts.app')

@section('title', 'Formulir Peminjaman')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#003d79]">📝 Formulir Peminjaman</h1>
            <p class="text-gray-500 text-sm">Lengkapi data di bawah ini untuk mengajukan peminjaman.</p>
        </div>
        <a href="{{ route('loans.catalog') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
            ← Kembali ke Katalog
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 sticky top-24">
                <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                    @if($item->image_url)
                        <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-4xl">📷</span>
                    @endif
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $item->name }}</h3>
                    <p class="text-xs text-gray-500 font-mono mb-3 bg-gray-100 inline-block px-2 py-1 rounded">
                        {{ $item->inventory_code }}
                    </p>
                    
                    <div class="space-y-2 text-sm text-gray-600 border-t pt-3">
                        <div class="flex justify-between">
                            <span>Kategori:</span>
                            <span class="font-semibold">{{ $item->category->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            <span class="text-green-600 font-bold">Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
                <form action="{{ route('loans.store', $item->id) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Tanggal Mulai Pinjam</label>
                        <input type="date" name="loan_date" 
                               class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-[#003d79] outline-none transition" 
                               value="{{ date('Y-m-d') }}"
                               min="{{ date('Y-m-d') }}" required>
                        <p class="text-xs text-gray-400 mt-1">Minimal hari ini.</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Durasi Peminjaman</label>
                        <select name="duration" class="w-full border border-gray-300 p-2.5 rounded-lg bg-white focus:ring-2 focus:ring-[#003d79] outline-none transition" required>
                            <option value="1">1 Hari</option>
                            <option value="2">2 Hari</option>
                            <option value="3">3 Hari</option>
                            <option value="4">4 Hari</option>
                            <option value="5">5 Hari</option>
                            <option value="6">6 Hari</option>
                            <option value="7">7 Hari (Maksimal)</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 font-bold mb-2">Keperluan Peminjaman</label>
                        <textarea name="purpose" rows="4" 
                                  class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-[#003d79] outline-none transition" 
                                  placeholder="Jelaskan keperluan Anda secara detail (Misal: Untuk tugas mata kuliah Fotografi Dasar)..." required></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="flex-1 bg-[#003d79] text-white px-6 py-3 rounded-lg hover:bg-blue-900 transition shadow-lg font-bold text-center">
                            🚀 Ajukan Peminjaman
                        </button>
                        <a href="{{ route('loans.catalog') }}" class="px-6 py-3 text-gray-500 hover:bg-gray-100 rounded-lg font-medium transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection