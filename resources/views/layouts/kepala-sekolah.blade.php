<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-amber-50 via-orange-50 to-rose-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-amber-600 via-orange-600 to-rose-600 text-white shadow-xl fixed h-full z-50">
            <div class="p-6 border-b border-white/20">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">Perpustakaan</h1>
                        <p class="text-xs text-white/70">Portal Kepala Sekolah</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <p class="text-xs uppercase tracking-wider text-white/50 mb-4 px-3">Menu</p>
                
                <a href="{{ route('kepala-sekolah.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('kepala-sekolah.dashboard') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <p class="text-xs uppercase tracking-wider text-white/50 mb-2 mt-6 px-3">Laporan</p>

                <a href="{{ route('kepala-sekolah.laporan.peminjaman') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('kepala-sekolah.laporan.peminjaman') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-hand-holding w-5 text-center"></i>
                    <span>Peminjaman</span>
                </a>

                <a href="{{ route('kepala-sekolah.laporan.stok-buku') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('kepala-sekolah.laporan.stok-buku') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-book w-5 text-center"></i>
                    <span>Stok Buku</span>
                </a>

                <a href="{{ route('kepala-sekolah.laporan.siswa-aktif') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('kepala-sekolah.laporan.siswa-aktif') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Siswa Aktif</span>
                </a>

                <a href="{{ route('kepala-sekolah.laporan.keterlambatan') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('kepala-sekolah.laporan.keterlambatan') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-exclamation-triangle w-5 text-center"></i>
                    <span>Keterlambatan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 ml-64">
            <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
                        <p class="text-sm text-gray-500">{{ $subtitle ?? 'Monitoring Perpustakaan' }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Kepala Sekolah</p>
                        </div>
                        <div class="relative">
                            <button onclick="document.getElementById('dropdown').classList.toggle('hidden')" 
                                    class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
