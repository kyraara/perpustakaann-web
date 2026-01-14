<x-siswa-layout>
    <x-slot name="title">Riwayat Peminjaman</x-slot>

    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('siswa.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-white font-medium">Riwayat Peminjaman</span>
        </nav>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="font-bold text-slate-800 dark:text-white">
                <i class="fas fa-history text-violet-500 mr-2"></i>
                Semua Riwayat Peminjaman
            </h2>
        </div>

        @if($peminjamans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-sm">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Buku</th>
                            <th class="py-3 px-4 text-center font-medium hidden sm:table-cell">Tgl Pinjam</th>
                            <th class="py-3 px-4 text-center font-medium hidden sm:table-cell">Tgl Kembali</th>
                            <th class="py-3 px-4 text-center font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($peminjamans as $p)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-12 bg-gradient-to-br from-violet-400 to-purple-500 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                            <i class="fas fa-book text-white text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-slate-800 dark:text-white truncate">{{ Str::limit($p->buku->judul ?? 'Unknown', 25) }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $p->buku->kode_buku ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-slate-600 dark:text-slate-400 hidden sm:table-cell">
                                    {{ $p->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-slate-600 dark:text-slate-400 hidden sm:table-cell">
                                    {{ $p->tanggal_dikembalikan ? $p->tanggal_dikembalikan->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($p->status === 'dikembalikan')
                                        <span class="inline-flex items-center px-2 py-1 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 rounded-full text-xs font-medium">
                                            <i class="fas fa-check mr-1"></i> Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 rounded-full text-xs font-medium">
                                            <i class="fas fa-clock mr-1"></i> Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 dark:border-slate-700">
                {{ $peminjamans->links() }}
            </div>
        @else
            <div class="py-16 text-center text-slate-400">
                <i class="fas fa-history text-4xl mb-3"></i>
                <p>Belum ada riwayat peminjaman</p>
            </div>
        @endif
    </div>
</x-siswa-layout>
