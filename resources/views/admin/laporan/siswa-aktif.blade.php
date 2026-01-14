<x-admin-layout>
    <x-slot name="title">Siswa Paling Aktif</x-slot>
    <x-slot name="subtitle">Top 20 siswa yang paling sering meminjam buku</x-slot>

    <!-- Back & Print -->
    <div class="mb-6 flex justify-between items-center print:hidden">
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-purple-600">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan
        </a>
        <a href="{{ route('admin.laporan.siswa-aktif.export') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 inline-flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>

    <!-- Print Header -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-xl font-bold">LAPORAN SISWA PALING AKTIF</h1>
        <p class="text-sm text-gray-600">Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Peringkat</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Kelas</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Jumlah Peminjaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-purple-50/50">
                            <td class="px-6 py-4">
                                @if($index < 3)
                                    <span class="w-8 h-8 inline-flex items-center justify-center rounded-full 
                                        {{ $index == 0 ? 'bg-yellow-400' : ($index == 1 ? 'bg-gray-300' : 'bg-orange-400') }} text-white font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                @else
                                    <span class="text-gray-600 ml-2">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $siswa->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1 bg-purple-100 text-purple-700 rounded-full font-bold">
                                    {{ $siswa->peminjamans_count }} buku
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-3"></i>
                                <p>Tidak ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
