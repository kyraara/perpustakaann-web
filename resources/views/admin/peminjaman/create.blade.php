<x-admin-layout>
    <x-slot name="title">Peminjaman Baru</x-slot>
    <x-slot name="subtitle">Catat peminjaman buku baru</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-5">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-xl">Form Peminjaman Buku</h3>
                            <p class="text-emerald-100 text-sm">Lengkapi data peminjaman di bawah ini</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="p-6" id="peminjamanForm">
                    @csrf
                    
                    <!-- Step 1: Pilih Siswa -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold shadow-lg shadow-emerald-200">1</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Pilih Siswa</h4>
                                <p class="text-sm text-gray-500">Pilih siswa yang akan meminjam buku</p>
                            </div>
                        </div>
                        
                        <div class="ml-11">
                            <!-- Search Input -->
                            <div class="relative mb-3">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchSiswa" placeholder="Cari nama siswa, NISN, atau kelas..."
                                       class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50">
                            </div>
                            
                            <!-- Siswa Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-2" id="siswaList">
                                @forelse($siswas as $siswa)
                                    <label class="siswa-card cursor-pointer block" data-nama="{{ strtolower($siswa->name) }}" data-nisn="{{ $siswa->nisn }}" data-kelas="{{ $siswa->kelas }}">
                                        <input type="radio" name="user_id" value="{{ $siswa->id }}" class="hidden peer" {{ old('user_id') == $siswa->id ? 'checked' : '' }}
                                               data-nama="{{ $siswa->name }}" data-kelas="{{ $siswa->kelas }}" data-nisn="{{ $siswa->nisn }}" data-jk="{{ $siswa->jenis_kelamin }}">
                                        <div class="p-3 border-2 border-gray-100 rounded-xl hover:border-emerald-300 hover:bg-emerald-50/50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:shadow-lg peer-checked:shadow-emerald-100">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold mr-3 shadow-sm
                                                    {{ $siswa->jenis_kelamin == 'P' ? 'bg-gradient-to-br from-pink-400 to-rose-500' : 'bg-gradient-to-br from-blue-400 to-indigo-500' }}">
                                                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-800 text-sm truncate">{{ $siswa->name }}</p>
                                                    <p class="text-xs text-gray-500">Kelas {{ $siswa->kelas ?? '-' }} • {{ $siswa->nisn ?? '-' }}</p>
                                                </div>
                                                <div class="peer-checked:block hidden">
                                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="col-span-2 text-center py-8 text-gray-400">
                                        <i class="fas fa-users text-3xl mb-2"></i>
                                        <p>Tidak ada siswa tersedia</p>
                                    </div>
                                @endforelse
                            </div>
                            @error('user_id')
                                <p class="mt-2 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-dashed border-gray-200 my-6"></div>

                    <!-- Step 2: Pilih Buku -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold shadow-lg shadow-emerald-200">2</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Pilih Buku</h4>
                                <p class="text-sm text-gray-500">Pilih buku yang akan dipinjam</p>
                            </div>
                        </div>
                        
                        <div class="ml-11">
                            <!-- Search Input -->
                            <div class="relative mb-3">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchBuku" placeholder="Cari judul buku atau kode buku..."
                                       class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50">
                            </div>
                            
                            <!-- Buku Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-2" id="bukuList">
                                @forelse($bukus as $buku)
                                    <label class="buku-card cursor-pointer block" data-judul="{{ strtolower($buku->judul) }}" data-kode="{{ strtolower($buku->kode_buku) }}">
                                        <input type="radio" name="buku_id" value="{{ $buku->id }}" class="hidden peer" {{ old('buku_id') == $buku->id ? 'checked' : '' }}
                                               data-judul="{{ $buku->judul }}" data-kode="{{ $buku->kode_buku }}" data-stok="{{ $buku->stokTersedia() }}">
                                        <div class="p-3 border-2 border-gray-100 rounded-xl hover:border-emerald-300 hover:bg-emerald-50/50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:shadow-lg peer-checked:shadow-emerald-100">
                                            <div class="flex items-center">
                                                <div class="w-12 h-14 bg-gradient-to-br from-amber-100 to-orange-100 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                                                    <i class="fas fa-book text-amber-600"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-800 text-sm truncate">{{ Str::limit($buku->judul, 25) }}</p>
                                                    <p class="text-xs text-gray-500">{{ $buku->kode_buku }}</p>
                                                    <p class="text-xs text-emerald-600 font-medium mt-0.5">
                                                        <i class="fas fa-layer-group mr-1"></i>{{ $buku->stokTersedia() }} tersedia
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="col-span-2 text-center py-8 text-gray-400">
                                        <i class="fas fa-book text-3xl mb-2"></i>
                                        <p>Tidak ada buku tersedia</p>
                                    </div>
                                @endforelse
                            </div>
                            @error('buku_id')
                                <p class="mt-2 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.peminjaman.index') }}" 
                           class="flex-1 py-3.5 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors text-center font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <button type="submit" id="submitBtn" class="flex-1 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all font-medium disabled:opacity-50 disabled:cursor-not-allowed" {{ $bukus->count() == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-check-circle mr-2"></i> Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg p-5" id="previewCard">
                <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-eye text-emerald-500 mr-2"></i>
                    Preview Peminjaman
                </h4>
                
                <div id="previewContent" class="space-y-4">
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-hand-pointer text-3xl mb-2"></i>
                        <p class="text-sm">Pilih siswa dan buku untuk melihat preview</p>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-5 border border-emerald-100">
                <h4 class="font-bold text-emerald-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle text-emerald-600 mr-2"></i>
                    Informasi Peminjaman
                </h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center text-emerald-700">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-calendar-check text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="font-medium">Tanggal Pinjam</p>
                            <p class="text-emerald-600">{{ now()->format('d M Y') }}</p>
                        </div>
                    </li>
                    <li class="flex items-center text-emerald-700">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-clock text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="font-medium">Lama Pinjam</p>
                            <p class="text-emerald-600">{{ \App\Models\Pengaturan::getValue('lama_pinjam', 7) }} Hari</p>
                        </div>
                    </li>
                    <li class="flex items-center text-emerald-700">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-calendar-alt text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="font-medium">Batas Kembali</p>
                            <p class="text-emerald-600">{{ now()->addDays((int) \App\Models\Pengaturan::getValue('lama_pinjam', 7))->format('d M Y') }}</p>
                        </div>
                    </li>
                    <li class="flex items-center text-emerald-700">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-layer-group text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="font-medium">Maks Peminjaman</p>
                            <p class="text-emerald-600">{{ \App\Models\Pengaturan::getValue('max_pinjam', 2) }} Buku per siswa</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Tips Card -->
            <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100">
                <h4 class="font-bold text-amber-800 mb-3 flex items-center">
                    <i class="fas fa-lightbulb text-amber-500 mr-2"></i>
                    Tips
                </h4>
                <ul class="space-y-2 text-sm text-amber-700">
                    <li class="flex items-start">
                        <i class="fas fa-check text-amber-500 mr-2 mt-0.5"></i>
                        <span>Gunakan pencarian untuk menemukan siswa/buku dengan cepat</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-amber-500 mr-2 mt-0.5"></i>
                        <span>Pastikan siswa belum mencapai batas maks peminjaman</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-amber-500 mr-2 mt-0.5"></i>
                        <span>Buku yang sudah dipinjam siswa tidak bisa dipinjam lagi</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Search Siswa
        document.getElementById('searchSiswa').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.siswa-card').forEach(card => {
                const nama = card.dataset.nama;
                const nisn = card.dataset.nisn || '';
                const kelas = card.dataset.kelas || '';
                if (nama.includes(query) || nisn.includes(query) || kelas.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Search Buku
        document.getElementById('searchBuku').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.buku-card').forEach(card => {
                const judul = card.dataset.judul;
                const kode = card.dataset.kode || '';
                if (judul.includes(query) || kode.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Preview Update
        function updatePreview() {
            const siswaInput = document.querySelector('input[name="user_id"]:checked');
            const bukuInput = document.querySelector('input[name="buku_id"]:checked');
            const previewContent = document.getElementById('previewContent');

            if (siswaInput || bukuInput) {
                let html = '';
                
                if (siswaInput) {
                    const jk = siswaInput.dataset.jk;
                    const gradientClass = jk === 'P' ? 'from-pink-400 to-rose-500' : 'from-blue-400 to-indigo-500';
                    html += `
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-2">Peminjam</p>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br ${gradientClass} rounded-lg flex items-center justify-center text-white font-bold mr-3">
                                    ${siswaInput.dataset.nama.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">${siswaInput.dataset.nama}</p>
                                    <p class="text-xs text-gray-500">Kelas ${siswaInput.dataset.kelas || '-'}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                if (bukuInput) {
                    html += `
                        <div class="p-3 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-2">Buku Dipinjam</p>
                            <div class="flex items-center">
                                <div class="w-10 h-12 bg-gradient-to-br from-amber-100 to-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">${bukuInput.dataset.judul}</p>
                                    <p class="text-xs text-gray-500">${bukuInput.dataset.kode}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                if (siswaInput && bukuInput) {
                    html += `
                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                            <div class="flex items-center justify-center text-emerald-600">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span class="font-medium text-sm">Siap diproses!</span>
                            </div>
                        </div>
                    `;
                }
                
                previewContent.innerHTML = html;
            } else {
                previewContent.innerHTML = `
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-hand-pointer text-3xl mb-2"></i>
                        <p class="text-sm">Pilih siswa dan buku untuk melihat preview</p>
                    </div>
                `;
            }
        }

        document.querySelectorAll('input[name="user_id"], input[name="buku_id"]').forEach(input => {
            input.addEventListener('change', updatePreview);
        });

        // Initial preview update
        updatePreview();
    </script>
</x-admin-layout>
