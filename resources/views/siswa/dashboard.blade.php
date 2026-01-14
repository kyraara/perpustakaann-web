<x-siswa-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Welcome -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 dark:text-slate-400">Selamat datang di Perpustakaan Digital</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Buku Dipinjam</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $jumlahDipinjam }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-emerald-600 dark:text-emerald-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Sisa Kuota</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $sisaKuota }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-layer-group text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalPeminjaman }}</p>
                </div>
                <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-violet-600 dark:text-violet-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-sm border border-slate-100 dark:border-slate-700 {{ $peminjamanTerlambat->count() > 0 ? 'border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-900/30' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs {{ $peminjamanTerlambat->count() > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-500 dark:text-slate-400' }} font-medium">Terlambat</p>
                    <p class="text-2xl font-bold {{ $peminjamanTerlambat->count() > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-white' }}">{{ $peminjamanTerlambat->count() }}</p>
                </div>
                <div class="w-10 h-10 {{ $peminjamanTerlambat->count() > 0 ? 'bg-rose-100 dark:bg-rose-900/50' : 'bg-slate-100 dark:bg-slate-700' }} rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle {{ $peminjamanTerlambat->count() > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400' }}"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Late Warning -->
    @if($peminjamanTerlambat->count() > 0)
        <div class="mb-6 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 rounded-xl p-4">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/50 rounded-lg flex items-center justify-center mr-3 shrink-0">
                    <i class="fas fa-bell text-rose-600 dark:text-rose-400"></i>
                </div>
                <div>
                    <h3 class="font-bold text-rose-800 dark:text-rose-300">⚠️ Perhatian!</h3>
                    <p class="text-sm text-rose-600 dark:text-rose-400">Kamu memiliki {{ $peminjamanTerlambat->count() }} buku yang terlambat dikembalikan. Segera kembalikan ke perpustakaan.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Active Loans -->
    @if($peminjamanAktif->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-6">
            <div class="p-4 border-b border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-slate-800 dark:text-white">
                        <i class="fas fa-bookmark text-emerald-500 mr-2"></i>
                        Pinjaman Aktif
                    </h2>
                    <a href="{{ route('siswa.peminjaman.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($peminjamanAktif->take(3) as $p)
                        @php
                            $isTerlambat = \Carbon\Carbon::now()->gt($p->tanggal_kembali);
                            $sisaHari = \Carbon\Carbon::now()->diffInDays($p->tanggal_kembali, false);
                        @endphp
                        <div class="flex items-center p-3 rounded-lg {{ $isTerlambat ? 'bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800' : 'bg-slate-50 dark:bg-slate-700/50' }}">
                            <div class="w-12 h-16 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-slate-800 dark:text-white text-sm truncate">{{ Str::limit($p->buku->judul ?? 'Unknown', 25) }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Kembali: {{ $p->tanggal_kembali->format('d M') }}</p>
                                @if($isTerlambat)
                                    <span class="text-xs text-rose-600 dark:text-rose-400 font-medium">Terlambat {{ abs($sisaHari) }} hari</span>
                                @else
                                    <span class="text-xs text-emerald-600 dark:text-emerald-400">{{ $sisaHari }} hari lagi</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Buku Terbaru -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-slate-800 dark:text-white">
                    <i class="fas fa-sparkles text-amber-500 mr-2"></i>
                    Buku Terbaru
                </h2>
                <a href="{{ route('siswa.buku.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($bukuTerbaru as $buku)
                    <div class="group relative">
                        <div class="aspect-[3/4] bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl overflow-hidden mb-2 relative shadow-sm group-hover:shadow-md transition-shadow">
                            <a href="{{ route('siswa.buku.show', $buku) }}" class="block w-full h-full">
                                @if($buku->cover)
                                    <img src="{{ Storage::url($buku->cover) }}" alt="Cover" class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-book text-3xl text-white/50"></i>
                                    </div>
                                @endif
                            </a>

                            @if($buku->stokTersedia() > 0)
                                <span class="absolute top-1 left-1 w-2 h-2 bg-emerald-400 rounded-full border border-white dark:border-slate-800"></span>
                            @endif
                        </div>
                        <a href="{{ route('siswa.buku.show', $buku) }}">
                            <h3 class="font-medium text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ Str::limit($buku->judul, 30) }}</h3>
                        </a>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $buku->penulis }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-siswa-layout>
