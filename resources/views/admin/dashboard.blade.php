<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Ringkasan Aktivitas Perpustakaan</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Total Buku -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg p-4 sm:p-6 border-l-4 border-emerald-500 transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Total Buku</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalBuku) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-lg sm:text-xl lg:text-2xl text-emerald-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg p-4 sm:p-6 border-l-4 border-teal-500 transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Total Siswa</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalSiswa) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-teal-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-lg sm:text-xl lg:text-2xl text-teal-500"></i>
                </div>
            </div>
        </div>

        <!-- Buku Dipinjam -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg p-4 sm:p-6 border-l-4 border-amber-500 transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Dipinjam</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 mt-1">{{ number_format($bukuDipinjam) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-amber-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <i class="fas fa-hand-holding text-lg sm:text-xl lg:text-2xl text-amber-500"></i>
                </div>
            </div>
        </div>

        <!-- Keterlambatan -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg p-4 sm:p-6 border-l-4 border-rose-500 transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Terlambat</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 mt-1">{{ number_format($peminjamanTerlambat) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-rose-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-lg sm:text-xl lg:text-2xl text-rose-500"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
        <!-- Peminjaman Terbaru -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">
                    <i class="fas fa-clock text-emerald-500 mr-2"></i>
                    Peminjaman Terbaru
                </h3>
                <a href="{{ route('admin.peminjaman.index') }}" class="text-emerald-600 hover:text-emerald-800 text-xs sm:text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($peminjamanTerbaru->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($peminjamanTerbaru as $peminjaman)
                        <div class="flex items-center p-3 sm:p-4 bg-slate-50 rounded-lg sm:rounded-xl hover:bg-slate-100 transition-colors">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg sm:rounded-xl flex items-center justify-center text-white font-bold mr-3 sm:mr-4 text-sm sm:text-base shrink-0">
                                {{ strtoupper(substr($peminjaman->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ $peminjaman->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs sm:text-sm text-slate-500 truncate">{{ Str::limit($peminjaman->buku->judul ?? 'Unknown', 25) }}</p>
                            </div>
                            <div class="text-right shrink-0 ml-2">
                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium
                                    {{ $peminjaman->status === 'dipinjam' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1 hidden sm:block">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 sm:py-12 text-slate-400">
                    <i class="fas fa-inbox text-3xl sm:text-4xl mb-3"></i>
                    <p class="text-sm sm:text-base">Belum ada peminjaman</p>
                </div>
            @endif
        </div>

        <!-- Buku Populer -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">
                    <i class="fas fa-fire text-orange-500 mr-2"></i>
                    Buku Populer
                </h3>
                <a href="{{ route('admin.buku.index') }}" class="text-emerald-600 hover:text-emerald-800 text-xs sm:text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($bukuPopuler->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($bukuPopuler as $index => $buku)
                        <div class="flex items-center p-3 sm:p-4 bg-slate-50 rounded-lg sm:rounded-xl hover:bg-slate-100 transition-colors">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-orange-400 to-rose-500 rounded-lg flex items-center justify-center text-white font-bold mr-3 sm:mr-4 text-sm shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ Str::limit($buku->judul, 30) }}</p>
                                <p class="text-xs sm:text-sm text-slate-500 truncate">{{ $buku->penulis }}</p>
                            </div>
                            <div class="text-right shrink-0 ml-2">
                                <span class="text-base sm:text-lg font-bold text-emerald-600">{{ $buku->peminjamans_count }}</span>
                                <p class="text-xs text-slate-400 hidden sm:block">kali dipinjam</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 sm:py-12 text-slate-400">
                    <i class="fas fa-book text-3xl sm:text-4xl mb-3"></i>
                    <p class="text-sm sm:text-base">Belum ada data buku</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="mt-6 lg:mt-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4">
            <i class="fas fa-chart-line text-purple-500 mr-2"></i>
            Analytics & Statistik
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Tren Peminjaman -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <h4 class="font-semibold text-slate-700 mb-3 text-sm">Tren Peminjaman (6 Bulan)</h4>
                <div class="h-48">
                    <canvas id="trenChart"></canvas>
                </div>
            </div>

            <!-- Distribusi Kategori -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <h4 class="font-semibold text-slate-700 mb-3 text-sm">Distribusi Kategori</h4>
                <div class="h-48">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            <!-- Statistik Keterlambatan -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <h4 class="font-semibold text-slate-700 mb-3 text-sm">Statistik Pengembalian</h4>
                <div class="h-48">
                    <canvas id="keterlambatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4 sm:mt-6 lg:mt-8 bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6">
        <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-4 sm:mb-6">
            <i class="fas fa-bolt text-amber-500 mr-2"></i>
            Aksi Cepat
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('admin.peminjaman.create') }}" class="flex flex-col items-center p-4 sm:p-6 bg-gradient-to-br from-emerald-50 to-teal-100 rounded-xl hover:shadow-lg transition-all group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white mb-2 sm:mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-plus text-lg sm:text-xl"></i>
                </div>
                <span class="font-medium text-slate-700 text-xs sm:text-sm text-center">Pinjam Buku</span>
            </a>
            <a href="{{ route('admin.buku.create') }}" class="flex flex-col items-center p-4 sm:p-6 bg-gradient-to-br from-teal-50 to-cyan-100 rounded-xl hover:shadow-lg transition-all group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center text-white mb-2 sm:mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-teal-500/30">
                    <i class="fas fa-book-medical text-lg sm:text-xl"></i>
                </div>
                <span class="font-medium text-slate-700 text-xs sm:text-sm text-center">Tambah Buku</span>
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="flex flex-col items-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl hover:shadow-lg transition-all group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-slate-600 to-slate-700 rounded-xl flex items-center justify-center text-white mb-2 sm:mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-slate-500/30">
                    <i class="fas fa-user-plus text-lg sm:text-xl"></i>
                </div>
                <span class="font-medium text-slate-700 text-xs sm:text-sm text-center">Tambah Siswa</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="flex flex-col items-center p-4 sm:p-6 bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl hover:shadow-lg transition-all group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white mb-2 sm:mb-3 group-hover:scale-110 transition-transform shadow-lg shadow-amber-500/30">
                    <i class="fas fa-chart-pie text-lg sm:text-xl"></i>
                </div>
                <span class="font-medium text-slate-700 text-xs sm:text-sm text-center">Lihat Laporan</span>
            </a>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tren Peminjaman Chart (Line)
            new Chart(document.getElementById('trenChart'), {
                type: 'line',
                data: {
                    labels: @json($trenPeminjaman['labels']),
                    datasets: [{
                        label: 'Peminjaman',
                        data: @json($trenPeminjaman['data']),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#10B981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });

            // Distribusi Kategori Chart (Doughnut)
            new Chart(document.getElementById('kategoriChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($distribusiKategori['labels']),
                    datasets: [{
                        data: @json($distribusiKategori['data']),
                        backgroundColor: [
                            '#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 8, font: { size: 11 } }
                        }
                    }
                }
            });

            // Statistik Keterlambatan Chart (Pie)
            new Chart(document.getElementById('keterlambatanChart'), {
                type: 'pie',
                data: {
                    labels: @json($statistikKeterlambatan['labels']),
                    datasets: [{
                        data: @json($statistikKeterlambatan['data']),
                        backgroundColor: @json($statistikKeterlambatan['colors']),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 8, font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
