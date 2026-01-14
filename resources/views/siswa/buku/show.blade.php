<x-siswa-layout>
    <x-slot name="title">Detail Buku</x-slot>

    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <i class="fas fa-home"></i>
            </a>
            <span class="text-slate-300 dark:text-slate-600">/</span>
            <a href="{{ route('siswa.buku.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Katalog</a>
            <span class="text-slate-300 dark:text-slate-600">/</span>
            <span class="text-slate-800 dark:text-white font-medium truncate max-w-[150px]">{{ $buku->judul }}</span>
        </nav>
    </div>

    <div class="w-full">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="lg:flex">
                <!-- Book Cover Section -->
                <div class="lg:w-1/3 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 p-8 lg:p-10 flex items-center justify-center relative overflow-hidden">
                    <!-- Decorative circles -->
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-white/5 rounded-full"></div>
                    
                    @if($buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" 
                             alt="Cover {{ $buku->judul }}" 
                             class="relative z-10 max-w-full max-h-80 rounded-xl shadow-2xl ring-4 ring-white/20 object-cover" 
                             loading="lazy">
                    @else
                        <div class="relative z-10 w-48 h-64 bg-white/10 backdrop-blur-sm rounded-xl border-2 border-dashed border-white/30 flex flex-col items-center justify-center gap-3">
                            <i class="fas fa-book text-6xl text-white/40"></i>
                            <span class="text-white/50 text-sm font-medium">No Cover</span>
                        </div>
                    @endif
                </div>

                <!-- Book Details Section -->
                <div class="lg:w-2/3 p-6 lg:p-8">
                    <!-- Header: Category & Code -->
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full text-sm font-semibold border border-emerald-100 dark:border-emerald-800">
                            <i class="fas fa-tag text-xs"></i>
                            {{ $buku->kategori->nama_kategori }}
                        </span>
                        <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-lg text-xs font-mono tracking-wider">
                            {{ $buku->kode_buku }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-white mb-6 leading-tight">
                        {{ $buku->judul }}
                    </h1>

                    <!-- Book Metadata -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-pen text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Penulis</p>
                                <p class="font-semibold text-slate-800 dark:text-white text-sm">{{ $buku->penulis }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Penerbit</p>
                                <p class="font-semibold text-slate-800 dark:text-white text-sm">{{ $buku->penerbit }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Tahun</p>
                                <p class="font-semibold text-slate-800 dark:text-white text-sm">{{ $buku->tahun }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Lokasi</p>
                                <p class="font-semibold text-slate-800 dark:text-white text-sm">{{ $buku->rak->nama_rak }} <span class="text-slate-400 font-normal">({{ $buku->rak->lokasi ?? '-' }})</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($buku->deskripsi)
                        <div class="mb-6">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                                <i class="fas fa-align-left text-slate-400"></i>
                                Deskripsi
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-4">
                                {{ $buku->deskripsi }}
                            </p>
                        </div>
                    @endif

                    <!-- Availability Card -->
                    <div class="flex items-center justify-between p-4 rounded-2xl mb-6 {{ $stokTersedia > 0 ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800' }}">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Ketersediaan</p>
                            <p class="text-xl font-bold {{ $stokTersedia > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $stokTersedia }} buku tersedia
                            </p>
                        </div>
                        <div class="w-14 h-14 {{ $stokTersedia > 0 ? 'bg-emerald-100 dark:bg-emerald-900/50' : 'bg-rose-100 dark:bg-rose-900/50' }} rounded-full flex items-center justify-center">
                            <i class="fas fa-{{ $stokTersedia > 0 ? 'check' : 'times' }} text-xl {{ $stokTersedia > 0 ? 'text-emerald-500' : 'text-rose-500' }}"></i>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Back Button -->
                        <a href="{{ route('siswa.buku.index') }}" 
                           class="w-12 h-12 flex items-center justify-center border-2 border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 transition-all" 
                           title="Kembali ke Katalog">
                            <i class="fas fa-arrow-left"></i>
                        </a>



                        <!-- Borrow Form -->
                        @if($stokTersedia > 0)
                            <form action="{{ route('siswa.peminjaman.ajukan', $buku) }}" method="POST" 
                                  class="flex-1 flex items-center gap-2"
                                  onsubmit="return confirm('Yakin ingin meminjam buku ini?')">
                                @csrf
                                <select name="durasi" 
                                        class="w-24 h-12 px-3 border-2 border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-semibold text-center appearance-none cursor-pointer">
                                    @foreach($durasiOpsi as $durasi)
                                        <option value="{{ $durasi }}" {{ $durasi == end($durasiOpsi) ? 'selected' : '' }}>{{ $durasi }} hari</option>
                                    @endforeach
                                </select>
                                <button type="submit" 
                                        class="flex-1 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-hand-holding"></i>
                                    <span>Pinjam Sekarang</span>
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="flex-1 h-12 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-xl cursor-not-allowed font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-ban"></i>
                                <span>Buku Tidak Tersedia</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-siswa-layout>
