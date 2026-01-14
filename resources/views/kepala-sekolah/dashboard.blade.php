<x-kepala-sekolah-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Statistik dan Monitoring Perpustakaan</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Buku</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalBuku) }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-2xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalSiswa) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-green-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Peminjaman Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($peminjamanBulanIni) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-2xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Keterlambatan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($keterlambatan) }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">
                <i class="fas fa-chart-bar text-amber-500 mr-2"></i>
                Grafik Peminjaman 6 Bulan Terakhir
            </h3>
            <div class="space-y-4">
                @foreach($chartData as $data)
                    <div class="flex items-center">
                        <span class="w-20 text-sm text-gray-600">{{ $data['bulan'] }}</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-6 rounded-full flex items-center justify-end pr-2"
                                     style="width: {{ $totalPeminjaman > 0 ? min(100, ($data['jumlah'] / max(1, max(array_column($chartData, 'jumlah')))) * 100) : 0 }}%">
                                    <span class="text-xs text-white font-medium">{{ $data['jumlah'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Buku Populer -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">
                <i class="fas fa-fire text-orange-500 mr-2"></i>
                Buku Paling Sering Dipinjam
            </h3>
            @if($bukuPopuler->count() > 0)
                <div class="space-y-4">
                    @foreach($bukuPopuler as $index => $buku)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center text-white font-bold mr-3 text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 text-sm">{{ Str::limit($buku->judul, 30) }}</p>
                                <p class="text-xs text-gray-500">{{ $buku->penulis }}</p>
                            </div>
                            <span class="text-amber-600 font-bold">{{ $buku->peminjamans_count }}x</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-400 py-8">Belum ada data</p>
            @endif
        </div>
    </div>

    <!-- Siswa Aktif -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">
            <i class="fas fa-medal text-yellow-500 mr-2"></i>
            Siswa Paling Aktif
        </h3>
        @if($siswaAktif->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($siswaAktif as $index => $siswa)
                    <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl">
                        <div class="w-12 h-12 mx-auto bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold mb-2">
                            {{ strtoupper(substr($siswa->name, 0, 1)) }}
                        </div>
                        <p class="font-medium text-gray-800 text-sm">{{ Str::limit($siswa->name, 15) }}</p>
                        <p class="text-xs text-gray-500">{{ $siswa->kelas ?? '-' }}</p>
                        <p class="text-amber-600 font-bold mt-1">{{ $siswa->peminjamans_count }} buku</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-400 py-8">Belum ada data</p>
        @endif
    </div>
</x-kepala-sekolah-layout>
