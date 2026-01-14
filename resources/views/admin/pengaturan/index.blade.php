<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>
    <x-slot name="subtitle">Konfigurasi sistem perpustakaan</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                @csrf

                <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-book text-indigo-500 mr-2"></i>
                    Pengaturan Peminjaman
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lama Pinjam Maks (Hari)</label>
                        <input type="number" name="lama_pinjam" min="1" max="30" required
                               value="{{ $pengaturans->firstWhere('key', 'lama_pinjam')?->value ?? 7 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Denda Per Hari (Rp)</label>
                        <input type="number" name="denda_per_hari" min="0" required
                               value="{{ $pengaturans->firstWhere('key', 'denda_per_hari')?->value ?? 500 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Maks Pinjam (Buku)</label>
                        <input type="number" name="max_pinjam" min="1" max="10" required
                               value="{{ $pengaturans->firstWhere('key', 'max_pinjam')?->value ?? 2 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Opsi Durasi Peminjaman
                        <span class="text-gray-500 font-normal">(pisahkan dengan koma, contoh: 3,5,7,14)</span>
                    </label>
                    <input type="text" name="durasi_opsi" required
                           value="{{ $pengaturans->firstWhere('key', 'durasi_opsi')?->value ?? '3,5,7' }}"
                           placeholder="3,5,7,14"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <p class="text-xs text-gray-500 mt-1">Pilihan durasi yang akan tampil saat siswa meminjam buku</p>
                </div>


                <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-school text-indigo-500 mr-2"></i>
                    Informasi Sekolah
                </h4>

                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" required
                               value="{{ $pengaturans->firstWhere('key', 'nama_sekolah')?->value ?? 'SD Negeri 3 Prabumulih' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" rows="2" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $pengaturans->firstWhere('key', 'alamat_sekolah')?->value ?? '' }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
