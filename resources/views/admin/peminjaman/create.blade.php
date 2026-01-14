<x-admin-layout>
    <x-slot name="title">Peminjaman Baru</x-slot>
    <x-slot name="subtitle">Catat peminjaman buku baru</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa *</label>
                    <select name="user_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">
                                {{ $siswa->name }} ({{ $siswa->kelas ?? 'No Class' }}) - {{ $siswa->nisn ?? 'No NISN' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku *</label>
                    <select name="buku_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Buku --</option>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}">
                                [{{ $buku->kode_buku }}] {{ $buku->judul }} (Tersedia: {{ $buku->stokTersedia() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="p-4 bg-blue-50 rounded-xl mb-6">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Tanggal pinjam akan otomatis ditetapkan hari ini dan tanggal kembali sesuai pengaturan sistem.
                    </p>
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('admin.peminjaman.index') }}" 
                       class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all">
                        <i class="fas fa-save mr-2"></i> Proses Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
