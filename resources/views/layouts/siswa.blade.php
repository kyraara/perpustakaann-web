<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>

    <script>
        // Check for saved theme preference or default to light
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-slate-100 dark:bg-slate-900 transition-colors duration-300">
    <!-- Header -->
    <header class="bg-white dark:bg-slate-800 shadow-sm sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Title -->
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-white"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="font-bold text-slate-800 dark:text-white leading-tight">Perpustakaan</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('siswa.dashboard') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('siswa.buku.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.buku.*') ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        <i class="fas fa-book mr-2"></i>Katalog
                    </a>
                    <a href="{{ route('siswa.peminjaman.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.peminjaman.index') ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        <i class="fas fa-hand-holding mr-2"></i>Pinjaman
                    </a>

                    <a href="{{ route('siswa.peminjaman.histori') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.peminjaman.histori') ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                        <i class="fas fa-history mr-2"></i>Riwayat
                    </a>
                </nav>

                <!-- Right Side -->
                <div class="flex items-center space-x-2">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" 
                            class="w-10 h-10 rounded-full flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <i class="fas fa-sun dark:hidden"></i>
                        <i class="fas fa-moon hidden dark:block"></i>
                    </button>

                    <!-- Notification Bell with Dropdown -->
                    @php
                        $peminjamanTerlambat = \App\Models\Peminjaman::with('buku')
                            ->where('user_id', Auth::id())
                            ->where('status', 'dipinjam')
                            ->where('tanggal_kembali', '<', now())
                            ->get();
                        $bukuBaruCount = \App\Models\Buku::where('created_at', '>=', now()->subDays(7))->count();
                    @endphp
                    <div class="relative">
                        <button onclick="toggleNotifDropdown()" 
                                class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors relative">
                            <i class="fas fa-bell"></i>
                            <span id="notifBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-xs font-bold rounded-full items-center justify-center animate-pulse hidden">
                                0
                            </span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-xl z-50 border border-slate-100 dark:border-slate-700 overflow-hidden">
                            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                                <h3 class="font-bold text-slate-800 dark:text-white">
                                    <i class="fas fa-bell text-emerald-500 mr-2"></i>Notifikasi
                                </h3>
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto" id="notifList">
                                @if($peminjamanTerlambat->count() > 0)
                                    @foreach($peminjamanTerlambat as $p)
                                        @php
                                            $hariTerlambat = now()->diffInDays($p->tanggal_kembali);
                                        @endphp
                                        <a href="{{ route('siswa.peminjaman.index') }}" 
                                           class="notif-item block px-4 py-3 hover:bg-rose-50 dark:hover:bg-rose-900/30 border-b border-slate-100 dark:border-slate-700"
                                           data-notif-id="late-{{ $p->id }}"
                                           onclick="markAsRead('late-{{ $p->id }}')">
                                            <div class="flex items-start">
                                                <div class="w-8 h-8 bg-rose-100 dark:bg-rose-900/50 rounded-lg flex items-center justify-center mr-3 shrink-0 mt-0.5">
                                                    <i class="fas fa-exclamation-triangle text-rose-500 text-sm"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">Buku Terlambat!</p>
                                                    <p class="text-xs text-slate-600 dark:text-slate-400 truncate">"{{ Str::limit($p->buku->judul ?? 'Unknown', 25) }}"</p>
                                                    <p class="text-xs text-rose-500">Terlambat {{ $hariTerlambat }} hari</p>
                                                </div>
                                                <span class="notif-dot w-2 h-2 bg-rose-500 rounded-full mt-2 shrink-0"></span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                                
                                @if($bukuBaruCount > 0)
                                    <a href="{{ route('siswa.buku.index') }}" 
                                       class="notif-item block px-4 py-3 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 border-b border-slate-100 dark:border-slate-700"
                                       data-notif-id="new-books"
                                       onclick="markAsRead('new-books')">
                                        <div class="flex items-start">
                                            <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mr-3 shrink-0 mt-0.5">
                                                <i class="fas fa-book text-emerald-500 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">Buku Baru!</p>
                                                <p class="text-xs text-slate-600 dark:text-slate-400">{{ $bukuBaruCount }} buku baru ditambahkan minggu ini</p>
                                            </div>
                                            <span class="notif-dot w-2 h-2 bg-emerald-500 rounded-full mt-2 shrink-0"></span>
                                        </div>
                                    </a>
                                @endif
                                
                                <div id="noNotif" class="px-4 py-8 text-center text-slate-400 hidden">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p class="text-sm">Tidak ada notifikasi</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('siswa.peminjaman.index') }}" class="block px-4 py-2 text-center text-sm text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 border-t border-slate-100 dark:border-slate-700 font-medium">
                                Lihat Semua Pinjaman
                            </a>
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="hidden lg:block text-right">
                        <p class="text-sm font-semibold text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kelas {{ Auth::user()->kelas ?? '-' }}</p>
                    </div>
                    <div class="relative">
                        <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" 
                                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </button>
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl py-2 z-50 border border-slate-100 dark:border-slate-700">
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700 lg:hidden">
                                <p class="font-semibold text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Kelas {{ Auth::user()->kelas ?? '-' }}</p>
                            </div>
                            <!-- Mobile Nav -->
                            <div class="md:hidden border-b border-slate-100 dark:border-slate-700 py-1">
                                <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                                    <i class="fas fa-home mr-2 w-4"></i> Dashboard
                                </a>
                                <a href="{{ route('siswa.buku.index') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                                    <i class="fas fa-book mr-2 w-4"></i> Katalog Buku
                                </a>
                                <a href="{{ route('siswa.peminjaman.index') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                                    <i class="fas fa-hand-holding mr-2 w-4"></i> Pinjaman
                                </a>

                                <a href="{{ route('siswa.peminjaman.histori') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                                    <i class="fas fa-history mr-2 w-4"></i> Riwayat
                                </a>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                                <i class="fas fa-user mr-2 text-slate-400"></i> Profil
                            </a>
                            <hr class="my-1 border-slate-100 dark:border-slate-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-rose-500"></i>
                {{ session('error') }}
            </div>
        @endif

        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}
            </p>
        </div>
    </footer>

    <script>
        // Dark Mode Toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Notification tracking
        const NOTIF_STORAGE_KEY = 'perpus_read_notifs';
        
        function getReadNotifs() {
            try {
                return JSON.parse(localStorage.getItem(NOTIF_STORAGE_KEY) || '[]');
            } catch {
                return [];
            }
        }
        
        function saveReadNotifs(notifs) {
            localStorage.setItem(NOTIF_STORAGE_KEY, JSON.stringify(notifs));
        }
        
        function markAsRead(notifId) {
            const readNotifs = getReadNotifs();
            if (!readNotifs.includes(notifId)) {
                readNotifs.push(notifId);
                saveReadNotifs(readNotifs);
            }
        }
        
        function updateNotifUI() {
            const readNotifs = getReadNotifs();
            const items = document.querySelectorAll('.notif-item');
            let unreadCount = 0;
            
            items.forEach(item => {
                const notifId = item.getAttribute('data-notif-id');
                const dot = item.querySelector('.notif-dot');
                
                if (readNotifs.includes(notifId)) {
                    if (dot) dot.classList.add('hidden');
                    item.classList.add('opacity-60');
                } else {
                    unreadCount++;
                }
            });
            
            // Update badge
            const badge = document.getElementById('notifBadge');
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        }
        
        function toggleNotifDropdown() {
            document.getElementById('notifDropdown').classList.toggle('hidden');
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateNotifUI);
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userDropdown = document.getElementById('userDropdown');
            const notifDropdown = document.getElementById('notifDropdown');
            
            if (!event.target.closest('#userDropdown') && !event.target.closest('button[onclick*="userDropdown"]')) {
                userDropdown.classList.add('hidden');
            }
            
            if (!event.target.closest('#notifDropdown') && !event.target.closest('button[onclick*="toggleNotifDropdown"]')) {
                notifDropdown.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
