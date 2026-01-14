<x-kepala-sekolah-layout>
    <x-slot name="title">Laporan Peminjaman</x-slot>
    <x-slot name="subtitle">Data peminjaman buku perpustakaan</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form action="{{ route('kepala-sekolah.laporan.peminjaman') }}" method="GET" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                       class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                       class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Status</label>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl hover:shadow-lg transition-all">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-4 text-left rounded-l-xl">Siswa</th>
                        <th class="py-4 px-4 text-left">Buku</th>
                        <th class="py-4 px-4 text-center">Tgl Pinjam</th>
                        <th class="py-4 px-4 text-center">Tgl Kembali</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">{{ $p->user->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-500">Kelas {{ $p->user->kelas ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">{{ Str::limit($p->buku->judul ?? 'Unknown', 30) }}</p>
                            </td>
                            <td class="py-4 px-4 text-center text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center text-sm">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 {{ $p->status === 'dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-xs">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $peminjamans->links() }}</div>
    </div>
</x-kepala-sekolah-layout>
