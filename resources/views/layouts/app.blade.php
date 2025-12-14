<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UPMD Inventory')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans antialiased">

    <nav class="bg-[#003d79] text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg leading-none tracking-wide">
                                UPMD <span class="text-[#f1c40f]">FILKOM</span>
                            </span>
                            <span class="text-[9px] text-gray-300 uppercase tracking-widest hidden sm:block">Inventory System</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-[#f1c40f] transition font-medium {{ request()->routeIs('dashboard') ? 'text-[#f1c40f]' : '' }}">Dashboard</a>
                    @endauth
                    
                    <a href="{{ route('loans.catalog') }}" class="hover:text-[#f1c40f] transition font-medium {{ request()->routeIs('loans.catalog') ? 'text-[#f1c40f]' : '' }}">Katalog</a>
                    
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('items.index') }}" class="hover:text-[#f1c40f] transition font-medium {{ request()->routeIs('items.*') ? 'text-[#f1c40f]' : '' }}">Kelola Alat</a>
                        @endif
                    @endauth
                </div>

                <div class="hidden md:flex items-center border-l border-blue-800 pl-6 ml-2">
                    @auth
                        <div class="flex flex-col text-right mr-4">
                            <span class="text-xs text-gray-300">Halo,</span>
                            <span class="text-sm font-semibold leading-none">{{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition shadow-md" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.google') }}" class="bg-white text-[#003d79] px-4 py-2 rounded-lg text-xs font-bold shadow hover:bg-gray-100 flex items-center gap-2">
                            Login SSO
                        </a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button onclick="toggleMenu()" class="text-gray-200 hover:text-white focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-[#003366] border-t border-blue-800">
            <div class="px-4 pt-4 pb-6 space-y-2">
                @auth
                    <div class="pb-4 mb-4 border-b border-blue-800">
                        <p class="text-xs text-gray-400">Login sebagai:</p>
                        <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-[#f1c40f] uppercase">{{ Auth::user()->role }}</p>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-800 {{ request()->routeIs('dashboard') ? 'bg-blue-900 text-[#f1c40f]' : '' }}">Dashboard</a>
                @endauth

                <a href="{{ route('loans.catalog') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-800 {{ request()->routeIs('loans.catalog') ? 'bg-blue-900 text-[#f1c40f]' : '' }}">Katalog Alat</a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('items.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-800 {{ request()->routeIs('items.*') ? 'bg-blue-900 text-[#f1c40f]' : '' }}">Kelola Alat</a>
                    @endif

                    <a href="{{ route('loans.history') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-800">Riwayat Saya</a>

                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium bg-red-600 hover:bg-red-700 text-white">
                            Logout Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login.google') }}" class="block w-full text-center px-3 py-3 mt-4 rounded-md text-base font-bold bg-white text-[#003d79]">
                        Login SSO UB
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow p-4 md:p-6">
        @if(session('success'))
            <div class="max-w-7xl mx-auto mb-4 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 shadow-sm rounded-r text-sm">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto mb-4 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 shadow-sm rounded-r text-sm">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} UPMD FILKOM UB</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
</html>