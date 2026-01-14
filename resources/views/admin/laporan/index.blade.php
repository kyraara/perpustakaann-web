<x-admin-layout>
    <x-slot name="title">Laporan</x-slot>
    <x-slot name="subtitle">Pilih jenis laporan yang ingin dilihat</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.laporan.peminjaman') }}" class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-hand-holding text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Laporan Peminjaman</h3>
            <p class="text-sm text-gray-500">Lihat data peminjaman buku berdasarkan periode</p>
        </a>

        <a href="{{ route('admin.laporan.keterlambatan') }}" class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Laporan Keterlambatan</h3>
            <p class="text-sm text-gray-500">Lihat data peminjaman yang terlambat</p>
        </a>

        <a href="{{ route('admin.laporan.stok-buku') }}" class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-book text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Laporan Stok Buku</h3>
            <p class="text-sm text-gray-500">Lihat stok dan ketersediaan buku</p>
        </a>

        <a href="{{ route('admin.laporan.siswa-aktif') }}" class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Siswa Paling Aktif</h3>
            <p class="text-sm text-gray-500">Lihat siswa yang paling sering meminjam buku</p>
        </a>
    </div>
</x-admin-layout>
