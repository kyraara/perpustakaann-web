<x-admin-layout>
    <x-slot name="title">Laporan Keterlambatan</x-slot>
    <x-slot name="subtitle">Data peminjaman yang terlambat dikembalikan</x-slot>

    <!-- Back & Print -->
    <div class="mb-6 flex justify-between items-center print:hidden">
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-purple-600">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan
        </a>
        <a href="{{ route('admin.laporan.keterlambatan.export') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 inline-flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>

    <!-- Print Header -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-xl font-bold">LAPORAN KETERLAMBATAN</h1>
        <p class="text-sm text-gray-600">Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Buku</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Batas Kembali</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Keterlambatan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjamans as $index => $p)
                        @php
                            $terlambat = $p->status == 'dipinjam' 
                                ? now()->diffInDays($p->tanggal_kembali, false) * -1
                                : $p->tanggal_dikembalikan->diffInDays($p->tanggal_kembali, false) * -1;
                        @endphp
                        <tr class="hover:bg-red-50/50">
                            <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $p->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->buku->judul }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    {{ $terlambat }} hari
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $p->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $p->status == 'dipinjam' ? 'Belum Dikembalikan' : 'Sudah Dikembalikan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                                <p>Tidak ada peminjaman yang terlambat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($peminjamans->count() > 0)
            <div class="px-6 py-4 bg-red-50 border-t">
                <p class="text-sm text-gray-600">Total: <strong class="text-red-600">{{ $peminjamans->count() }}</strong> peminjaman terlambat</p>
            </div>
        @endif
    </div>
</x-admin-layout>
