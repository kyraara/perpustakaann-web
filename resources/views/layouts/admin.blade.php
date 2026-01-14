<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Mobile Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 bg-gradient-to-b from-slate-800 via-slate-900 to-slate-950 text-white shadow-2xl fixed h-full z-50 sidebar-transition -translate-x-full lg:translate-x-0">
            <!-- Logo -->
            <div class="p-5 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight text-white">Perpustakaan</h1>
                        <p class="text-xs text-slate-400">{{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-88px)]">
                <p class="text-xs uppercase tracking-wider text-slate-500 mb-3 px-3 font-semibold">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-home w-5 text-center {{ request()->routeIs('admin.dashboard') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <p class="text-xs uppercase tracking-wider text-slate-500 mb-2 mt-5 px-3 font-semibold">Data Master</p>
                
                <a href="{{ route('admin.kategori.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-tags w-5 text-center {{ request()->routeIs('admin.kategori.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Kategori</span>
                </a>

                <a href="{{ route('admin.rak.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.rak.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-archive w-5 text-center {{ request()->routeIs('admin.rak.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Rak Buku</span>
                </a>

                <a href="{{ route('admin.buku.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.buku.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-book w-5 text-center {{ request()->routeIs('admin.buku.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Buku</span>
                </a>

                <a href="{{ route('admin.siswa.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-users w-5 text-center {{ request()->routeIs('admin.siswa.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Siswa</span>
                </a>

                <p class="text-xs uppercase tracking-wider text-slate-500 mb-2 mt-5 px-3 font-semibold">Transaksi</p>

                <a href="{{ route('admin.peminjaman.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-hand-holding w-5 text-center {{ request()->routeIs('admin.peminjaman.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Peminjaman</span>
                </a>

                <p class="text-xs uppercase tracking-wider text-slate-500 mb-2 mt-5 px-3 font-semibold">Lainnya</p>

                <a href="{{ route('admin.laporan.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-chart-bar w-5 text-center {{ request()->routeIs('admin.laporan.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Laporan</span>
                </a>

                <a href="{{ route('admin.pengaturan.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'hover:bg-white/5 text-slate-300 hover:text-white' }}">
                    <i class="fas fa-cog w-5 text-center {{ request()->routeIs('admin.pengaturan.*') ? '' : 'text-emerald-400' }}"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>


            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-72 w-full">
            <!-- Top Bar -->
            <header class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-30 border-b border-slate-200/50">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <div class="hidden sm:block">
                        <h2 class="text-lg sm:text-xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                        <p class="text-xs sm:text-sm text-slate-500">{{ $subtitle ?? 'Selamat datang di sistem perpustakaan' }}</p>
                    </div>
                    
                    @php
                        $notifications = \App\Services\NotificationService::getAdminNotifications();
                    @endphp
                    
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <!-- Global Search -->
                        <form action="{{ route('admin.search.index') }}" method="GET" class="hidden md:block">
                            <div class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" 
                                       placeholder="Cari buku, siswa, peminjaman..." 
                                       class="w-64 pl-10 pr-4 py-2 bg-slate-100 border-0 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white text-sm transition-all">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                            </div>
                        </form>

                        <!-- Notification Bell -->
                        <div class="relative">
                            <button onclick="document.getElementById('notifDropdown').classList.toggle('hidden')" 
                                    class="relative p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                @if($notifications['total'] > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                        {{ $notifications['total'] > 9 ? '9+' : $notifications['total'] }}
                                    </span>
                                @endif
                            </button>
                            <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl py-2 z-50 border border-slate-100">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="font-semibold text-slate-800">Notifikasi</p>
                                </div>
                                @forelse($notifications['items'] as $item)
                                    <a href="{{ $item['link'] }}" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                                        <div class="w-8 h-8 bg-{{ $item['color'] }}-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-{{ $item['icon'] }} text-{{ $item['color'] }}-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-800">{{ $item['title'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $item['desc'] }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-slate-400">
                                        <i class="fas fa-check-circle text-2xl mb-2"></i>
                                        <p class="text-sm">Tidak ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">Administrator</p>
                        </div>
                        <div class="relative">
                            <button onclick="document.getElementById('dropdown').classList.toggle('hidden')" 
                                    class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-shadow">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-slate-100">
                                <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
                                    <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500">Administrator</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <i class="fas fa-user mr-2 text-slate-400"></i> Profil
                                </a>
                                <hr class="my-1 border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Title -->
                <div class="sm:hidden px-4 pb-3">
                    <h2 class="text-lg font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-4 sm:mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 sm:px-6 py-3 sm:py-4 rounded-xl flex items-center shadow-sm">
                        <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                        <span class="text-sm sm:text-base">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-800 px-4 sm:px-6 py-3 sm:py-4 rounded-xl flex items-center shadow-sm">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <span class="text-sm sm:text-base">{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-800 px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-sm">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                            <span class="font-semibold text-sm sm:text-base">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside ml-6 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdown');
            const button = event.target.closest('button');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
