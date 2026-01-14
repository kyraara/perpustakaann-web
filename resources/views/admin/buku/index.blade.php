<x-admin-layout>
    <x-slot name="title">Manajemen Buku</x-slot>
    <x-slot name="subtitle">Kelola koleksi buku perpustakaan</x-slot>

    <div class="bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6">
        <!-- Header with Search -->
        <div class="flex flex-col gap-4 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">
                    <i class="fas fa-book text-emerald-500 mr-2"></i>
                    Daftar Buku
                </h3>
                <div class="flex flex-wrap gap-2">
                    <!-- Export Button -->
                    <a href="{{ route('admin.buku.export') }}" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all text-sm font-medium">
                        <i class="fas fa-file-excel mr-2"></i> Export
                    </a>
                    
                    <!-- Import Button -->
                    <button onclick="document.getElementById('importModal').classList.remove('hidden')" 
                            class="inline-flex items-center justify-center px-3 py-2 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition-all text-sm font-medium">
                        <i class="fas fa-file-import mr-2"></i> Import
                    </button>
                    
                    <!-- Add Book Button -->
                    <a href="{{ route('admin.buku.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:shadow-lg transition-all text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i> Tambah Buku
                    </a>
                </div>
            </div>
            
            <!-- Search & Filter -->
            <form action="{{ route('admin.buku.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari judul, kode, penulis..."
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <select name="kategori_id" class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Cards (visible on small screens) -->
        <div class="block sm:hidden space-y-3">
            @forelse($bukus as $buku)
                <div class="bg-slate-50 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        @if($buku->cover)
                            <img src="{{ Storage::url($buku->cover) }}" alt="Cover" class="w-14 h-18 object-cover rounded-lg shrink-0" loading="lazy">
                        @else
                            <div class="w-14 h-18 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-book text-white text-lg"></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-800 text-sm truncate">{{ $buku->judul }}</p>
                            <p class="text-xs text-slate-500">{{ $buku->penulis }}</p>
                            <div class="flex flex-wrap gap-1 mt-2">
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs">{{ $buku->kategori->nama_kategori }}</span>
                                <span class="px-2 py-0.5 {{ $buku->stok > 0 ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }} rounded-full text-xs">
                                    Stok: {{ $buku->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-3 pt-3 border-t border-slate-200">
                        <a href="{{ route('admin.buku.edit', $buku) }}" class="px-3 py-1.5 bg-slate-200 text-slate-700 rounded-lg text-xs font-medium">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-rose-100 text-rose-700 rounded-lg text-xs font-medium">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400">
                    <i class="fas fa-book text-3xl mb-3"></i>
                    <p class="text-sm">Belum ada buku</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table (hidden on small screens) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-sm">
                        <th class="py-4 px-4 text-left rounded-l-xl">Kode</th>
                        <th class="py-4 px-4 text-left">Buku</th>
                        <th class="py-4 px-4 text-left">Kategori</th>
                        <th class="py-4 px-4 text-left">Rak</th>
                        <th class="py-4 px-4 text-center">Stok</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bukus as $buku)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono">
                                    {{ $buku->kode_buku }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    @if($buku->cover)
                                        <img src="{{ Storage::url($buku->cover) }}" alt="Cover" class="w-10 h-14 object-cover rounded-lg mr-3" loading="lazy">
                                    @else
                                        <div class="w-10 h-14 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg mr-3 flex items-center justify-center">
                                            <i class="fas fa-book text-white text-sm"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-slate-800">{{ Str::limit($buku->judul, 35) }}</p>
                                        <p class="text-sm text-slate-500">{{ $buku->penulis }} • {{ $buku->tahun }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm">
                                    {{ $buku->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-600">{{ $buku->rak->nama_rak }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 {{ $buku->stok > 0 ? 'bg-teal-100 text-teal-800' : 'bg-rose-100 text-rose-800' }} rounded-full text-sm font-medium">
                                    {{ $buku->stok }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.buku.edit', $buku) }}" 
                                       class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fas fa-book text-4xl mb-3"></i>
                                <p>Belum ada buku</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 sm:mt-6">
            {{ $bukus->links() }}
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">
                    <i class="fas fa-file-import text-amber-500 mr-2"></i>
                    Import Data Buku
                </h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.buku.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">File Excel (.xlsx, .xls)</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 text-sm">
                    <p class="text-xs text-slate-500 mt-2">
                        Format: Kode Buku, Judul, Penulis, Penerbit, Tahun, Kategori, Rak, Stok, Deskripsi
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-amber-500 text-white rounded-xl hover:bg-amber-600">
                        <i class="fas fa-upload mr-2"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
