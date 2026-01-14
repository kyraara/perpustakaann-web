<x-siswa-layout>
    <x-slot name="title">Pinjaman Aktif</x-slot>

    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-white font-medium">Pinjaman Saya</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="font-bold text-slate-800 dark:text-white">
                <i class="fas fa-hand-holding text-blue-500 mr-2"></i>
                Buku yang Sedang Dipinjam
            </h2>
        </div>

        @if($peminjamans->count() > 0)
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @foreach($peminjamans as $p)
                    @php
                        $isTerlambat = \Carbon\Carbon::now()->gt($p->tanggal_kembali);
                        $sisaHari = \Carbon\Carbon::now()->diffInDays($p->tanggal_kembali, false);
                    @endphp
                    <div class="p-4 {{ $isTerlambat ? 'bg-rose-50 dark:bg-rose-900/30' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50' }} transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-18 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-book text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-800 dark:text-white">{{ $p->buku->judul ?? 'Unknown' }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $p->buku->penulis ?? '' }}</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="inline-flex items-center text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">
                                        <i class="fas fa-calendar-alt mr-1"></i> Pinjam: {{ $p->tanggal_pinjam->format('d M Y') }}
                                    </span>
                                    <span class="inline-flex items-center text-xs {{ $isTerlambat ? 'text-rose-700 dark:text-rose-400 bg-rose-100 dark:bg-rose-900/50' : 'text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50' }} px-2 py-1 rounded">
                                        <i class="fas fa-clock mr-1"></i> Kembali: {{ $p->tanggal_kembali->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                @if($isTerlambat)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-400 rounded-full text-sm font-medium">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat {{ abs($sisaHari) }} hari
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 rounded-full text-sm font-medium">
                                        <i class="fas fa-clock mr-1"></i> {{ $sisaHari }} hari lagi
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-16 text-center text-slate-400">
                <i class="fas fa-book-open text-4xl mb-3"></i>
                <p>Tidak ada buku yang sedang dipinjam</p>
                <a href="{{ route('siswa.buku.index') }}" class="inline-block mt-4 px-4 py-2 bg-emerald-500 text-white rounded-lg text-sm font-medium hover:bg-emerald-600 transition-colors">
                    Cari Buku
                </a>
            </div>
        @endif
    </div>
</x-siswa-layout>
