@extends('layouts.app')

@section('title', 'Konfirmasi Peminjaman')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#003d79]">📋 Konfirmasi Peminjaman</h1>
            <p class="text-gray-500 text-xs md:text-sm">Setujui atau tolak pengajuan peminjaman alat.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">Kembali</a>
    </div>

    <div class="hidden md:block bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase font-bold text-xs tracking-wider">
                <tr>
                    <th class="p-4 border-b">Peminjam</th>
                    <th class="p-4 border-b">Alat</th>
                    <th class="p-4 border-b">Tanggal</th>
                    <th class="p-4 border-b">Status</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($loans as $loan)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-gray-800">{{ $loan->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $loan->user->email }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-medium">{{ $loan->item->name }}</div>
                        <div class="text-xs text-gray-500 font-mono">{{ $loan->item->inventory_code }}</div>
                    </td>
                    <td class="p-4">
                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }} 
                        <span class="text-gray-400 text-xs">-</span> 
                        {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M') }}
                    </td>
                    <td class="p-4">
                        @if($loan->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold uppercase">Menunggu</span>
                        @elseif($loan->status == 'approved')
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold uppercase">Disetujui</span>
                        @elseif($loan->status == 'returned')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold uppercase">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold uppercase">Ditolak</span>
                        @endif
                    </td>
                    <td class="p-4 text-center space-x-1">
                        @if($loan->status == 'pending')
                            <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button onclick="return confirm('Terima pengajuan ini?')" class="bg-green-500 text-white px-3 py-1.5 rounded hover:bg-green-600 text-xs font-bold transition">✔ Terima</button>
                            </form>
                            <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button onclick="return confirm('Tolak pengajuan ini?')" class="bg-red-500 text-white px-3 py-1.5 rounded hover:bg-red-600 text-xs font-bold transition">✖ Tolak</button>
                            </form>
                        @elseif($loan->status == 'approved')
                             <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button onclick="return confirm('Barang sudah dikembalikan?')" class="bg-gray-700 text-white px-3 py-1.5 rounded hover:bg-gray-800 text-xs font-bold transition">📥 Tandai Kembali</button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada pengajuan peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($loans as $loan)
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 relative overflow-hidden">
            
            <div class="absolute left-0 top-0 bottom-0 w-1.5 
                {{ $loan->status == 'pending' ? 'bg-yellow-400' : 
                  ($loan->status == 'approved' ? 'bg-blue-500' : 
                  ($loan->status == 'returned' ? 'bg-green-500' : 'bg-red-500')) }}">
            </div>

            <div class="pl-3">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Peminjam</p>
                        <h3 class="font-bold text-gray-800 text-base leading-tight">{{ $loan->user->name }}</h3>
                        <p class="text-xs text-gray-400">{{ $loan->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase mb-1
                            {{ $loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                              ($loan->status == 'approved' ? 'bg-blue-100 text-blue-800' : 
                              ($loan->status == 'returned' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $loan->status }}
                        </span>
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-3">
                    <p class="text-[10px] uppercase font-bold text-gray-500 mb-1">Barang yang dipinjam</p>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">{{ $loan->item->name }}</span>
                        <span class="font-mono text-xs text-gray-400 bg-white px-1 rounded border">{{ $loan->item->inventory_code }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <span>📅</span> 
                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }} 
                        <span>s.d</span> 
                        {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M') }}
                    </div>
                    @if($loan->purpose)
                        <p class="mt-2 text-xs text-gray-500 italic border-t border-gray-200 pt-1">"{{ Str::limit($loan->purpose, 50) }}"</p>
                    @endif
                </div>

                @if($loan->status == 'pending')
                    <div class="grid grid-cols-2 gap-3">
                        <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button onclick="return confirm('Tolak pengajuan ini?')" class="w-full py-2.5 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition shadow-sm">
                                ✖ Tolak
                            </button>
                        </form>
                        <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button onclick="return confirm('Terima pengajuan ini?')" class="w-full py-2.5 bg-[#003d79] text-white rounded-lg text-sm font-bold hover:bg-blue-900 transition shadow-md">
                                ✔ Terima
                            </button>
                        </form>
                    </div>
                @elseif($loan->status == 'approved')
                    <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button onclick="return confirm('Barang sudah dikembalikan?')" class="w-full py-2.5 bg-gray-700 text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow-md flex justify-center items-center gap-2">
                            <span>📥</span> Tandai Barang Kembali
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-10 bg-white rounded-xl border border-gray-200 border-dashed">
            <p class="text-4xl mb-2">📭</p>
            <p>Belum ada pengajuan masuk.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection