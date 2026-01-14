<x-siswa-layout>
    <x-slot name="title">Katalog Buku</x-slot>

    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-white font-medium">Katalog Buku</span>
        </nav>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-4 mb-6">
        <form action="{{ route('siswa.buku.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul, penulis, atau kode buku..."
                       class="w-full pl-11 pr-4 py-3 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <select name="kategori_id" class="px-4 py-3 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors font-medium">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
    </div>

    <!-- Book Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @forelse($bukus as $buku)
            <a href="{{ route('siswa.buku.show', $buku) }}" 
               class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-700 transition-all group">
                <div class="aspect-[2/3] overflow-hidden bg-slate-100 dark:bg-slate-700 relative">


                    @if($buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-book text-5xl text-white/50"></i>
                        </div>
                    @endif
                    <!-- Availability Badge -->
                    <div class="absolute top-2 right-2">
                        @if($buku->stokTersedia() > 0)
                            <span class="px-2 py-1 bg-emerald-500 text-white text-xs rounded-full font-medium shadow">
                                Tersedia
                            </span>
                        @else
                            <span class="px-2 py-1 bg-rose-500 text-white text-xs rounded-full font-medium shadow">
                                Habis
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-slate-800 dark:text-white text-sm line-clamp-2 mb-1">{{ $buku->judul }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mb-2">{{ $buku->penulis }}</p>
                    <span class="inline-block px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded text-xs">
                        {{ $buku->kategori->nama_kategori }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 py-16 text-center text-slate-400">
                <i class="fas fa-search text-4xl mb-3"></i>
                <p>Buku tidak ditemukan</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $bukus->links() }}
    </div>
</x-siswa-layout>
