<x-admin-layout>
    <x-slot name="title">Manajemen Siswa</x-slot>
    <x-slot name="subtitle">Kelola data siswa perpustakaan</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-users text-indigo-500 mr-2"></i>
                Daftar Siswa
            </h3>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, NISN, email..."
                           class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <select name="kelas" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.siswa.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Siswa
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-4 text-left rounded-l-xl">Siswa</th>
                        <th class="py-4 px-4 text-left">NISN</th>
                        <th class="py-4 px-4 text-center">Kelas</th>
                        <th class="py-4 px-4 text-center">Peminjaman Aktif</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                        {{ strtoupper(substr($siswa->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $siswa->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $siswa->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-mono text-gray-600">{{ $siswa->nisn ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $siswa->kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 {{ $siswa->active_loans > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }} rounded-full text-sm font-medium">
                                    {{ $siswa->active_loans }} buku
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.siswa.edit', $siswa) }}" 
                                       class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                <i class="fas fa-users text-4xl mb-3"></i>
                                <p>Belum ada siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $siswas->links() }}
        </div>
    </div>
</x-admin-layout>
