<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - UPMD Inventory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans antialiased h-screen w-full relative overflow-hidden">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/bg.jpg') }}"
             alt="Drone FILKOM" 
             class="w-full h-full object-cover">
        
        <div class="absolute inset-0 bg-[#003d79]/85 mix-blend-multiply"></div>
        
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">
        
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden fade-in-up">
            
            <div class="pt-10 pb-6 text-center px-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo UPMD" class="h-20 w-auto drop-shadow-md">
                </div>
                
                <h1 class="text-2xl font-bold text-[#003d79] mb-1 tracking-tight">
                    UPMD <span class="text-[#f1c40f]">FILKOM</span>
                </h1>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-widest mb-6">
                    Inventory Management System
                </p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Sistem informasi peminjaman alat multimedia dan laboratorium Fakultas Ilmu Komputer.
                </p>
            </div>

            @if (session('error'))
                <div class="mx-8 mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm flex items-start gap-2">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="px-8 pb-10 space-y-4">
                
                @auth
                    <div class="text-center space-y-3">
                        <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mb-4">
                            <p class="text-sm text-[#003d79]">Halo, <strong>{{ Auth::user()->name }}</strong>!</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="block w-full bg-[#003d79] hover:bg-blue-900 text-white font-bold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-0.5 text-center">
                            🚀 Buka Dashboard
                        </a>
                    </div>
                @else
                    <a href="{{ route('login.google') }}" class="flex items-center justify-center gap-3 w-full bg-[#003d79] hover:bg-blue-900 text-white font-bold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-0.5 group">
                        <svg class="w-5 h-5 bg-white rounded-full p-0.5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span>Login SSO UB</span>
                        <span class="group-hover:translate-x-1 transition">→</span>
                    </a>

                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-xs uppercase">Atau</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <a href="{{ route('loans.catalog') }}" class="block w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 rounded-lg transition text-center">
                        Lihat Katalog Alat
                    </a>
                @endauth

            </div>

            <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} UPMD Filkom Universitas Brawijaya
                </p>
            </div>
        </div>

    </div>

</body>
</html>