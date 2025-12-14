@extends('layouts.app')

@section('title', 'Dashboard - UPMD Inventory')

@section('content')
<div class="max-w-6xl mx-auto mt-2 md:mt-6">
    
    @if(Auth::user()->role === 'admin')
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
            
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-blue-500">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-wider">Total Aset</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $totalItems }} <span class="hidden md:inline text-sm font-normal text-gray-400">Unit</span></p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-purple-500">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-wider">Dipinjam</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $activeLoans }} <span class="hidden md:inline text-sm font-normal text-gray-400">Unit</span></p>
            </div>

            <a href="{{ route('admin.loans') }}" class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-yellow-500 hover:bg-yellow-50 transition relative group">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-wider text-yellow-700">Konfirmasi</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $pendingLoans }} <span class="hidden md:inline text-sm font-normal text-gray-400">Request</span></p>
                @if($pendingLoans > 0)
                    <span class="absolute top-2 right-2 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                @endif
            </a>

            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-green-500">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-wider">User</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 md:mb-8 gap-2">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-[#003d79]">
                        👋 Halo, <span class="text-black">{{ explode(' ', Auth::user()->name)[0] }}</span>!
                    </h2>
                    <p class="text-gray-500 text-xs md:text-sm mt-1">
                        Selamat datang di Sistem Inventory UPMD.
                    </p>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full border border-gray-200 w-fit">
                    {{ \Carbon\Carbon::now()->format('d M Y') }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                
                <div class="border p-4 md:p-6 rounded-xl bg-white shadow-sm border-gray-200 order-1 md:order-2">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm md:text-base">
                        🚀 Menu Cepat
                    </h3>
                    
                    <div class="space-y-3">
                        @if(Auth::user()->role === 'admin')
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <a href="{{ route('items.index') }}" class="flex flex-col items-center justify-center bg-blue-50 border border-blue-200 text-[#003d79] py-3 rounded-lg hover:bg-blue-100 transition shadow-sm font-bold text-xs">
                                    <span class="text-xl mb-1">📦</span> Kelola Alat
                                </a>
                                <a href="{{ route('admin.loans') }}" class="flex flex-col items-center justify-center bg-[#003d79] text-white py-3 rounded-lg hover:bg-blue-900 transition shadow-md font-bold text-xs relative">
                                    <span class="text-xl mb-1">📋</span> Konfirmasi
                                    @if($pendingLoans > 0)
                                        <span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full">!</span>
                                    @endif
                                </a>
                            </div>
                        @endif
                
                        <a href="{{ route('loans.catalog') }}" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-gray-200 rounded-lg active:scale-95 transition shadow-sm">
                            <span class="font-semibold text-sm">➕ Pinjam Alat Baru</span>
                            <span class="text-gray-400">→</span>
                        </a>
                        
                        <a href="{{ route('loans.history') }}" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-gray-200 rounded-lg active:scale-95 transition shadow-sm">
                            <span class="font-semibold text-sm text-gray-600">📜 Riwayat Saya</span>
                            <span class="text-gray-400">→</span>
                        </a>
                    </div>
                </div>

                <div class="border p-4 md:p-6 rounded-xl bg-blue-50 border-blue-100 order-2 md:order-1">
                    <h3 class="font-bold text-[#003d79] mb-4 flex items-center gap-2 text-sm md:text-base">
                        👤 Profil Anda
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-semibold text-right">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="flex justify-between border-b border-blue-100 pb-2">
                            <span class="text-gray-500">Email</span>
                            <span class="font-semibold text-xs md:text-sm">{{ Auth::user()->email }}</span>
                        </li>
                        <li class="flex justify-between items-center pt-1">
                            <span class="text-gray-500">Role</span>
                            <span class="uppercase font-bold text-[10px] px-2 py-1 rounded tracking-wider {{ Auth::user()->role == 'admin' ? 'bg-[#003d79] text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection