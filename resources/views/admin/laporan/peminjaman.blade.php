<x-admin-layout>
    <x-slot name="title">Laporan Peminjaman</x-slot>
    <x-slot name="subtitle">Data peminjaman buku berdasarkan periode</x-slot>

    <!-- Back & Filter -->
    <div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center print:hidden">
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-purple-600">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan
        </a>

        <div class="flex flex-wrap gap-3 items-center">
            <form action="{{ route('admin.laporan.peminjaman') }}" method="GET" class="flex flex-wrap gap-3 items-center">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                       class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                <span class="text-gray-500">s/d</span>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                       class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                <select name="status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
            </form>
            <a href="{{ route('admin.laporan.peminjaman.export', request()->query()) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 inline-flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Print Header -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-xl font-bold">LAPORAN PEMINJAMAN BUKU</h1>
        <p class="text-sm text-gray-600">Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Buku</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tgl Kembali</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $index => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $p->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->buku->judul }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $p->status == 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Tidak ada data peminjaman</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($peminjamans->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-t">
                <p class="text-sm text-gray-600">Total: <strong>{{ $peminjamans->count() }}</strong> data peminjaman</p>
            </div>
        @endif
    </div>
</x-admin-layout>
