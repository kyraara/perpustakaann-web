<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital {{ $setting->get('nama_sekolah', 'SD N 9 Prabumulih') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Fredoka', sans-serif; }
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
<body class="antialiased text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-900 transition-colors duration-300">

    <!-- 1. Navigation (Glassmorphic) -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-4 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-white"></i>
                    </div>
                    <span class="text-xl font-bold font-fredoka tracking-wide">Perpustakaan</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#beranda" class="hover:text-emerald-300 transition-colors font-medium">Beranda</a>
                    <a href="#koleksi" class="hover:text-emerald-300 transition-colors font-medium">Koleksi</a>
                    <a href="#panduan" class="hover:text-emerald-300 transition-colors font-medium">Panduan</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <button onclick="toggleDarkMode()" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
                        <i class="fas fa-sun dark:hidden"></i>
                        <i class="fas fa-moon hidden dark:block"></i>
                    </button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full font-bold transition-all shadow-lg shadow-emerald-500/30 text-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white text-emerald-600 hover:bg-emerald-50 rounded-full font-bold transition-all shadow-lg text-sm">
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-white hover:text-emerald-300 transition-colors">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Dropdown) -->
        <div id="mobile-menu" class="hidden md:hidden bg-slate-900/95 backdrop-blur-xl absolute w-full left-0 top-full border-t border-white/10">
            <div class="px-4 py-4 space-y-2">
                <a href="#beranda" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/10">Beranda</a>
                <a href="#koleksi" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/10">Koleksi</a>
                <a href="#panduan" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/10">Panduan</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full text-center px-5 py-3 mt-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-5 py-3 mt-4 bg-white text-emerald-600 hover:bg-gray-100 rounded-xl font-bold">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section (Search-Centric Portal) -->
    <section id="beranda" class="relative min-h-[600px] flex items-center justify-center pt-24 pb-16 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/70 to-slate-900/80 z-10"></div>
            <img src="{{ asset('images/hero_bg.png') }}" alt="Library Background" class="w-full h-full object-cover object-center scale-105 animate-slow-zoom">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
            <div class="space-y-8 max-w-4xl mx-auto">

                {{-- Headline --}}
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-tight animate-fade-in-up delay-100 font-fredoka drop-shadow-lg">
                    Selamat Datang Di Perpustakaan<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">Ayo mulai membaca </span>
                </h1>

                {{-- Search Bar --}}
                <div class="max-w-3xl mx-auto mt-10 animate-fade-in-up delay-200">
                    <form action="{{ route('siswa.buku.index') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 md:pl-6 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 group-focus-within:text-emerald-500 transition-colors text-lg md:text-xl"></i>
                        </div>
                        <input type="text" 
                            name="search"
                            class="block w-full pl-12 md:pl-16 pr-24 md:pr-28 py-4 md:py-6 rounded-full bg-white border-2 border-white/20 text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500 text-base md:text-lg shadow-2xl transition-all duration-300" 
                            placeholder="Cari buku..."
                            autocomplete="off">
                        <button type="submit" class="absolute inset-y-2 right-2 px-4 md:px-8 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full font-bold transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2 text-sm md:text-base">
                            Cari <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                    
                    {{-- Quick Tags --}}
                    <div class="mt-6 flex flex-wrap justify-center gap-3 text-sm text-white/90 font-medium">
                        <span class="drop-shadow-md">Pencarian Populer:</span>
                        <a href="{{ route('siswa.buku.index', ['search' => 'Matematika']) }}" class="px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 border border-white/20 transition-colors cursor-pointer">Matematika</a>
                        <a href="{{ route('siswa.buku.index', ['search' => 'IPA']) }}" class="px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 border border-white/20 transition-colors cursor-pointer">IPA</a>
                        <a href="{{ route('siswa.buku.index', ['search' => 'Cerita']) }}" class="px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 border border-white/20 transition-colors cursor-pointer">Cerita</a>
                        <a href="{{ route('siswa.buku.index', ['search' => 'Kamus']) }}" class="px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 border border-white/20 transition-colors cursor-pointer">Kamus</a>
                    </div>
                </div>
            </div>
        </div>
        

    </section>

    <!-- 3. Quick Access Categories -->
    <section class="py-12 -mt-10 relative z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                @foreach($pilihanKategori as $kategori)
                <a href="{{ route('siswa.buku.index', ['kategori_id' => $kategori->id]) }}" class="group bg-white dark:bg-slate-800 p-4 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 hover:border-emerald-500 dark:hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 text-center flex flex-col items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 line-clamp-1">{{ $kategori->nama_kategori }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. Info Board & Announcements -->
    <!-- <section class="py-16 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 h-full">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-clock text-emerald-500"></i> Jam Operasional
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
                            <span class="text-slate-500 dark:text-slate-400">Senin - Kamis</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">07:00 - 14:00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
                            <span class="text-slate-500 dark:text-slate-400">Jumat</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">07:00 - 11:30</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
                            <span class="text-slate-500 dark:text-slate-400">Sabtu</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">07:00 - 12:00</span>
                        </div>
                        <div class="mt-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-sm text-emerald-700 dark:text-emerald-300 flex gap-3">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <p>Perpustakaan tutup pada hari Minggu dan hari libur nasional.</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-emerald-600 dark:bg-emerald-900 rounded-3xl p-8 shadow-lg relative overflow-hidden text-white flex flex-col justify-center">
                    <div class="relative z-10">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold mb-4 backdrop-blur-sm border border-white/20">
                            <i class="fas fa-bullhorn mr-1"></i> Pengumuman Terbaru
                        </span>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4 font-fredoka">Selamat Datang Semester Baru!</h3>
                        <p class="text-emerald-100 text-lg mb-8 max-w-xl">
                            Koleksi buku baru telah tersedia! Segera kunjungi perpustakaan untuk meminjam buku paket pelajaran dan buku cerita terbaru.
                        </p>
                        <a href="{{ route('siswa.buku.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-emerald-600 rounded-xl font-bold hover:bg-emerald-50 transition-colors shadow-lg">
                            Lihat Buku Baru <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="absolute right-0 bottom-0 opacity-10">
                        <i class="fas fa-book-reader text-9xl transform translate-x-10 translate-y-10"></i>
                    </div>
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </section> -->



    <!-- 6. Buku Populer -->
    <section id="koleksi" class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-2 font-fredoka">Sedang Banyak Dibaca</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">Buku-buku yang sedang populer di kalangan teman-temanmu.</p>
                </div>
                <a href="{{ route('siswa.buku.index') }}" class="hidden md:inline-flex items-center justify-center px-6 py-3 border border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors">
                    Lihat Semua Koleksi <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            @if($bukuPopuler->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($bukuPopuler as $buku)
                <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-full hover:-translate-y-1">
                    <div class="aspect-[2/3] overflow-hidden bg-slate-100 dark:bg-slate-700 relative">
                        @if ($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                <i class="fas fa-book text-4xl mb-2"></i>
                                <span class="text-xs">No Cover</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white text-xs font-bold bg-emerald-500 px-2.5 py-1 rounded-lg shadow-sm">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-2 mb-2 leading-tight text-sm font-fredoka" title="{{ $buku->judul }}">{{ $buku->judul }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-auto">{{ Str::limit($buku->penulis, 20) }}</p>
                        <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-eye"></i> {{ $buku->peminjamans_count }}x Pinjam
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <p class="text-slate-500 dark:text-slate-400">Belum ada data buku populer saat ini.</p>
            </div>
            @endif
            
            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('siswa.buku.index') }}" class="inline-block px-6 py-3 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl font-bold hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors">Jelajahi Semua Buku</a>
            </div>
        </div>
    </section>

    <!-- 7. Panduan (Steps) -->
    <section id="panduan" class="py-20 bg-white dark:bg-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-4 font-fredoka">Cara Meminjam Buku</h2>
                <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto text-lg">Ikuti 4 langkah mudah ini untuk mulai membaca buku favoritmu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Connector Line -->
                <div class="hidden md:block absolute top-10 left-0 w-full h-1 bg-gradient-to-r from-emerald-100 via-blue-100 to-emerald-100 dark:from-slate-700 dark:via-slate-600 dark:to-slate-700 -z-10 rounded-full"></div>

                <!-- Step 1 -->
                <div class="relative flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-2xl border-2 border-emerald-100 dark:border-slate-600 flex items-center justify-center text-3xl shadow-lg mb-6 z-10 group-hover:scale-110 group-hover:border-emerald-500 transition-all duration-300">
                        🔑
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2 font-fredoka">1. Login</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Masuk menggunakan akun siswa yang telah diberikan oleh gurumu.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="relative flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-2xl border-2 border-emerald-100 dark:border-slate-600 flex items-center justify-center text-3xl shadow-lg mb-6 z-10 group-hover:scale-110 group-hover:border-blue-500 transition-all duration-300">
                        🔍
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2 font-fredoka">2. Cari Buku</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Jelajahi katalog kami dan temukan buku yang menarik hatimu.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="relative flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-2xl border-2 border-emerald-100 dark:border-slate-600 flex items-center justify-center text-3xl shadow-lg mb-6 z-10 group-hover:scale-110 group-hover:border-amber-500 transition-all duration-300">
                        🖱️
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2 font-fredoka">3. Klik Pinjam</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Tekan tombol pinjam pada buku yang kamu pilih.</p>
                </div>
                
                <!-- Step 4 -->
                <div class="relative flex flex-col items-center text-center group">
                    <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-2xl border-2 border-emerald-100 dark:border-slate-600 flex items-center justify-center text-3xl shadow-lg mb-6 z-10 group-hover:scale-110 group-hover:border-rose-500 transition-all duration-300">
                        📖
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2 font-fredoka">4. Ambil Buku</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Datang ke perpustakaan untuk mengambil bukumu. Selamat membaca!</p>
                </div>
            </div>
        </div>
    </section>



    <!-- 9. Footer (Dark) -->
    <footer class="bg-slate-900 text-slate-300 pt-20 pb-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white text-2xl shadow-lg">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white font-fredoka">Perpustakaan</h3>
                            <p class="text-sm text-slate-500 font-medium tracking-wider">{{ strtoupper($setting->get('nama_sekolah', 'SD N 3 Prabumulih')) }}</p>
                        </div>
                    </div>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        Platform perpustakaan digital yang dirancang untuk meningkatkan minat baca dan mempermudah akses literasi bagi siswa sekolah dasar.
                    </p>
                    <div class="flex gap-4 pt-2">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white rounded-full flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-pink-600 text-slate-400 hover:text-white rounded-full flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white rounded-full flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-white mb-8 relative inline-block">
                        Menu Pintas
                        <div class="absolute -bottom-2 left-0 w-12 h-1 bg-emerald-500 rounded-full"></div>
                    </h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#beranda" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Beranda</a></li>
                        <li><a href="#koleksi" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Koleksi Buku</a></li>
                        <li><a href="#panduan" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Panduan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Login Siswa</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-white mb-8 relative inline-block">
                        Kontak
                        <div class="absolute -bottom-2 left-0 w-12 h-1 bg-emerald-500 rounded-full"></div>
                    </h4>
                    <ul class="space-y-5 text-sm">
                        <li class="flex items-start gap-4 group">
                            <div class="mt-1 w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="leading-relaxed">Jl. A. Hamid, Kec. Prabumulih Utara, Kota Prabumulih, Prov. Sumatera Selatan</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                             <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>322903</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                             <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span>sdnsembilanpbm@yahoo.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}. All rights reserved.</p>
                <div class="flex items-center gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent', 'py-4', 'text-white');
                navbar.classList.add('bg-white/90', 'dark:bg-slate-900/90', 'backdrop-blur-md', 'shadow-md', 'py-2', 'text-slate-800', 'dark:text-white');
                
                // Update specific elements if needed
                const links = navbar.querySelectorAll('a.font-medium');
                links.forEach(link => {
                    link.classList.remove('hover:text-emerald-300');
                    link.classList.add('hover:text-emerald-500');
                });
            } else {
                navbar.classList.add('bg-transparent', 'py-4', 'text-white');
                navbar.classList.remove('bg-white/90', 'dark:bg-slate-900/90', 'backdrop-blur-md', 'shadow-md', 'py-2', 'text-slate-800', 'dark:text-white');
                
                const links = navbar.querySelectorAll('a.font-medium');
                links.forEach(link => {
                    link.classList.add('hover:text-emerald-300');
                    link.classList.remove('hover:text-emerald-500');
                });
            }
        });

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
    </script>

</body>
</html>

