<x-kepala-sekolah-layout>
    <x-slot name="title">Laporan Keterlambatan</x-slot>
    <x-slot name="subtitle">Data peminjaman yang terlambat dikembalikan</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-4 text-left rounded-l-xl">Siswa</th>
                        <th class="py-4 px-4 text-left">Buku</th>
                        <th class="py-4 px-4 text-center">Tgl Pinjam</th>
                        <th class="py-4 px-4 text-center">Batas Kembali</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $p)
                        @php
                            $hariTerlambat = $p->status === 'dipinjam' 
                                ? \Carbon\Carbon::now()->diffInDays($p->tanggal_kembali, false) 
                                : ($p->tanggal_dikembalikan ? $p->tanggal_dikembalikan->diffInDays($p->tanggal_kembali, false) : 0);
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors {{ $p->status === 'dipinjam' ? 'bg-red-50' : '' }}">
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">{{ $p->user->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-500">{{ $p->user->kelas ?? '' }}</p>
                            </td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ Str::limit($p->buku->judul ?? 'Unknown', 25) }}</td>
                            <td class="py-4 px-4 text-center text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center text-sm text-red-600">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-center">
                                @if($p->status === 'dipinjam')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                        Belum dikembalikan ({{ abs($hariTerlambat) }} hari)
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                        Terlambat {{ abs($hariTerlambat) }} hari
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="text-red-600 font-bold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                <i class="fas fa-check-circle text-4xl text-green-400 mb-3"></i>
                                <p>Tidak ada keterlambatan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $peminjamans->links() }}</div>
    </div>
</x-kepala-sekolah-layout>
