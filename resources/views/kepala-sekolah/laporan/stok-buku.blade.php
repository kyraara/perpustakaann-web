<x-kepala-sekolah-layout>
    <x-slot name="title">Laporan Stok Buku</x-slot>
    <x-slot name="subtitle">Data ketersediaan buku perpustakaan</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-4 text-left rounded-l-xl">Kode</th>
                        <th class="py-4 px-4 text-left">Judul Buku</th>
                        <th class="py-4 px-4 text-left">Kategori</th>
                        <th class="py-4 px-4 text-left">Rak</th>
                        <th class="py-4 px-4 text-center">Stok Total</th>
                        <th class="py-4 px-4 text-center">Dipinjam</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($bukus as $buku)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 font-mono text-sm">{{ $buku->kode_buku }}</td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ Str::limit($buku->judul, 35) }}</td>
                            <td class="py-4 px-4 text-sm">{{ $buku->kategori->nama_kategori }}</td>
                            <td class="py-4 px-4 text-sm">{{ $buku->rak->nama_rak }}</td>
                            <td class="py-4 px-4 text-center">{{ $buku->stok }}</td>
                            <td class="py-4 px-4 text-center text-yellow-600">{{ $buku->dipinjam }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 {{ ($buku->stok - $buku->dipinjam) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-sm">
                                    {{ $buku->stok - $buku->dipinjam }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $bukus->links() }}</div>
    </div>
</x-kepala-sekolah-layout>
