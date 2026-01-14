<x-admin-layout>
    <x-slot name="title">Manajemen Peminjaman</x-slot>
    <x-slot name="subtitle">Kelola peminjaman dan pengembalian buku</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-hand-holding text-indigo-500 mr-2"></i>
                Daftar Peminjaman
            </h3>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari siswa atau buku..."
                           class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.peminjaman.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i> Peminjaman Baru
                </a>
            </div>
        </div>

        <!-- Bulk Return Form -->
        <form id="bulkReturnForm" action="{{ route('admin.peminjaman.bulk-return') }}" method="POST">
            @csrf
            
            <!-- Bulk Action Bar -->
            <div id="bulkActionBar" class="hidden mb-4 p-3 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between">
                <span class="text-indigo-700 text-sm font-medium">
                    <span id="selectedCount">0</span> item dipilih
                </span>
                <button type="submit" onclick="return confirm('Kembalikan semua buku yang dipilih?')" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm font-medium">
                    <i class="fas fa-undo mr-2"></i> Kembalikan Sekaligus
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="py-4 px-4 text-left rounded-l-xl">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </th>
                            <th class="py-4 px-4 text-left">Peminjam</th>
                            <th class="py-4 px-4 text-left">Buku</th>
                            <th class="py-4 px-4 text-center">Tgl Pinjam</th>
                            <th class="py-4 px-4 text-center">Tgl Kembali</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-4 text-center">Denda</th>
                            <th class="py-4 px-4 text-center rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjamans as $p)
                            @php
                                $isTerlambat = $p->status === 'dipinjam' && \Carbon\Carbon::now()->gt($p->tanggal_kembali);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $isTerlambat ? 'bg-red-50' : '' }}">
                                <td class="py-4 px-4">
                                    @if($p->status === 'dipinjam')
                                        <input type="checkbox" name="peminjaman_ids[]" value="{{ $p->id }}" 
                                               class="bulk-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $p->user->name ?? 'Unknown' }}</p>
                                            <p class="text-sm text-gray-500">{{ $p->user->kelas ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-medium text-gray-800">{{ Str::limit($p->buku->judul ?? 'Unknown', 30) }}</p>
                                    <p class="text-sm text-gray-500">{{ $p->buku->kode_buku ?? '' }}</p>
                                </td>
                                <td class="py-4 px-4 text-center text-gray-600">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                <td class="py-4 px-4 text-center text-gray-600">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if($p->status === 'dikembalikan')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            Dikembalikan
                                        </span>
                                    @elseif($isTerlambat)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($p->status === 'dikembalikan' && $p->denda > 0)
                                        <span class="text-red-600 font-medium">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @elseif($isTerlambat)
                                        <div>
                                            <span class="text-red-600 font-bold">Rp {{ number_format($p->denda_otomatis, 0, ',', '.') }}</span>
                                            <p class="text-xs text-red-500">{{ $p->hari_terlambat }} hari</p>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if($p->status === 'dipinjam')
                                            <form action="{{ route('admin.peminjaman.kembalikan', $p) }}" method="POST"
                                                  onsubmit="return confirm('Proses pengembalian buku ini?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                                                    <i class="fas fa-undo mr-1"></i> Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.peminjaman.destroy', $p) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-400">
                                    <i class="fas fa-hand-holding text-4xl mb-3"></i>
                                    <p>Belum ada peminjaman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-6">
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
