<x-admin-layout>
    <x-slot name="title">Manajemen Peminjaman</x-slot>
    <x-slot name="subtitle">Kelola peminjaman dan pengembalian buku</x-slot>

    <!-- Stats Cards -->
    @php
        $totalDipinjam = $peminjamans->where('status', 'dipinjam')->count();
        $totalTerlambat = $peminjamans->filter(fn($p) => $p->status === 'dipinjam' && \Carbon\Carbon::now()->gt($p->tanggal_kembali))->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Dipinjam</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDipinjam }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200">
                    <i class="fas fa-book-reader text-white text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 {{ $totalTerlambat > 0 ? 'border-red-200 bg-red-50' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs {{ $totalTerlambat > 0 ? 'text-red-500' : 'text-gray-500' }} font-medium uppercase tracking-wider">Terlambat</p>
                    <p class="text-2xl font-bold {{ $totalTerlambat > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">{{ $totalTerlambat }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br {{ $totalTerlambat > 0 ? 'from-red-400 to-rose-500 shadow-red-200' : 'from-gray-300 to-gray-400 shadow-gray-200' }} rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Dikembalikan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i class="fas fa-check-circle text-white text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Data</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamans->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                    <i class="fas fa-database text-white text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-hand-holding-heart text-indigo-500 mr-2"></i>
                        Daftar Peminjaman
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola semua transaksi peminjaman buku</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex flex-wrap gap-2">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari siswa atau buku..."
                                   class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto">
                        </div>
                        <select name="status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>📚 Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>✅ Dikembalikan</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>⚠️ Terlambat</option>
                        </select>
                        <button type="submit" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-colors">
                            <i class="fas fa-filter"></i>
                        </button>
                    </form>
                    <a href="{{ route('admin.peminjaman.create') }}" 
                       class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg hover:shadow-indigo-200 transition-all flex items-center justify-center font-medium">
                        <i class="fas fa-plus mr-2"></i> Peminjaman Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Bulk Return Form -->
        <form id="bulkReturnForm" action="{{ route('admin.peminjaman.bulk-return') }}" method="POST">
            @csrf
            
            <!-- Bulk Action Bar -->
            <div id="bulkActionBar" class="hidden px-6 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-double text-indigo-600"></i>
                    </div>
                    <span class="text-indigo-700 font-medium">
                        <span id="selectedCount" class="text-lg font-bold">0</span> item dipilih
                    </span>
                </div>
                <button type="submit" onclick="return confirm('Kembalikan semua buku yang dipilih?')" 
                        class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:shadow-lg transition-all font-medium">
                    <i class="fas fa-undo mr-2"></i> Kembalikan Sekaligus
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 text-left font-semibold">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </th>
                            <th class="py-4 px-6 text-left font-semibold">Peminjam</th>
                            <th class="py-4 px-6 text-left font-semibold">Buku</th>
                            <th class="py-4 px-6 text-center font-semibold">Periode</th>
                            <th class="py-4 px-6 text-center font-semibold">Status</th>
                            <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjamans as $p)
                            @php
                                $isTerlambat = $p->status === 'dipinjam' && \Carbon\Carbon::now()->gt($p->tanggal_kembali);
                                $sisaHari = $p->status === 'dipinjam' ? \Carbon\Carbon::now()->diffInDays($p->tanggal_kembali, false) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors {{ $isTerlambat ? 'bg-red-50/50' : '' }}">
                                <td class="py-4 px-6">
                                    @if($p->status === 'dipinjam')
                                        <input type="checkbox" name="peminjaman_ids[]" value="{{ $p->id }}" 
                                               class="bulk-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    @else
                                        <span class="text-gray-300"><i class="fas fa-minus"></i></span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-11 h-11 bg-gradient-to-br {{ $p->user->jenis_kelamin == 'P' ? 'from-pink-400 to-rose-500' : 'from-blue-400 to-indigo-500' }} rounded-xl flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                                            {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $p->user->name ?? 'Unknown' }}</p>
                                            <p class="text-sm text-gray-500">Kelas {{ $p->user->kelas ?? '-' }} • {{ $p->user->nisn ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-10 h-12 bg-gradient-to-br from-amber-100 to-orange-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-book text-amber-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ Str::limit($p->buku->judul ?? 'Unknown', 28) }}</p>
                                            <p class="text-sm text-gray-500">{{ $p->buku->kode_buku ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-sm text-gray-600">{{ $p->tanggal_pinjam->format('d M') }}</span>
                                        <i class="fas fa-arrow-down text-gray-300 text-xs my-1"></i>
                                        <span class="text-sm {{ $isTerlambat ? 'text-red-600 font-semibold' : 'text-gray-600' }}">{{ $p->tanggal_kembali->format('d M') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($p->status === 'dikembalikan')
                                        <div class="inline-flex items-center px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium">
                                            <i class="fas fa-check-circle mr-1.5"></i> Dikembalikan
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">{{ $p->tanggal_dikembalikan?->format('d M Y') }}</p>
                                    @elseif($isTerlambat)
                                        <div class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-medium animate-pulse">
                                            <i class="fas fa-exclamation-circle mr-1.5"></i> Terlambat
                                        </div>
                                        <p class="text-xs text-red-500 font-medium mt-1">{{ $p->hari_terlambat }} hari</p>
                                    @else
                                        <div class="inline-flex items-center px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-sm font-medium">
                                            <i class="fas fa-clock mr-1.5"></i> Dipinjam
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ abs($sisaHari) }} hari lagi</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($p->status === 'dipinjam')
                                            <form action="{{ route('admin.peminjaman.kembalikan', $p) }}" method="POST"
                                                  onsubmit="return confirm('Proses pengembalian buku ini?')">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors text-sm font-medium shadow-sm hover:shadow">
                                                    <i class="fas fa-undo mr-1.5"></i> Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.peminjaman.destroy', $p) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada data peminjaman</p>
                                        <p class="text-sm text-gray-400 mt-1">Klik tombol "Peminjaman Baru" untuk menambah</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $peminjamans->links() }}
        </div>
    </div>

    <script>
        // Select All functionality
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.bulk-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActionBar();
        });

        // Individual checkbox change
        document.querySelectorAll('.bulk-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActionBar);
        });

        function updateBulkActionBar() {
            const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
            const bar = document.getElementById('bulkActionBar');
            const count = document.getElementById('selectedCount');
            
            if (checked > 0) {
                bar.classList.remove('hidden');
                count.textContent = checked;
            } else {
                bar.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
