<x-admin-layout>
    <x-slot name="title">Laporan Stok Buku</x-slot>
    <x-slot name="subtitle">Data stok dan ketersediaan buku</x-slot>

    <!-- Back & Print -->
    <div class="mb-6 flex justify-between items-center print:hidden">
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-purple-600">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan
        </a>
        <a href="{{ route('admin.laporan.stok-buku.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 inline-flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>

    <!-- Print Header -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-xl font-bold">LAPORAN STOK BUKU</h1>
        <p class="text-sm text-gray-600">Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Judul Buku</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Lokasi</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Stok Total</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Dipinjam</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bukus as $index => $buku)
                        @php
                            $tersedia = $buku->stok - $buku->dipinjam;
                        @endphp
                        <tr class="hover:bg-green-50/50">
                            <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-gray-500">{{ $buku->kode_buku }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $buku->judul }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">
                                    {{ $buku->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $buku->rak->nama_rak }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $buku->stok }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-blue-600 font-medium">{{ $buku->dipinjam }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $tersedia > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $tersedia }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-book text-4xl mb-3"></i>
                                <p>Tidak ada data buku</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bukus->count() > 0)
            <div class="px-6 py-4 bg-green-50 border-t flex justify-between">
                <p class="text-sm text-gray-600">Total: <strong>{{ $bukus->count() }}</strong> judul buku</p>
                <p class="text-sm text-gray-600">Total Stok: <strong>{{ $bukus->sum('stok') }}</strong> eksemplar</p>
            </div>
        @endif
    </div>
</x-admin-layout>
