<x-admin-layout>
    <x-slot name="title">Manajemen Rak</x-slot>
    <x-slot name="subtitle">Kelola rak buku perpustakaan</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-archive text-indigo-500 mr-2"></i>
                Daftar Rak
            </h3>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                    class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Rak
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-6 text-left rounded-l-xl">No</th>
                        <th class="py-4 px-6 text-left">Nama Rak</th>
                        <th class="py-4 px-6 text-left">Lokasi</th>
                        <th class="py-4 px-6 text-center">Jumlah Buku</th>
                        <th class="py-4 px-6 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($raks as $index => $rak)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 text-gray-600">{{ $raks->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                <span class="font-medium text-gray-800">{{ $rak->nama_rak }}</span>
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ $rak->lokasi ?? '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    {{ $rak->bukus_count }} buku
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="openEditModal({{ $rak->id }}, '{{ $rak->nama_rak }}', '{{ $rak->lokasi }}')" 
                                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.rak.destroy', $rak) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus rak ini?')">
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
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Belum ada rak</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $raks->links() }}
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Tambah Rak</h3>
                <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.rak.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Rak</label>
                    <input type="text" name="nama_rak" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Contoh: Rak A1">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Contoh: Baris 1 Kiri">
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')"
                            class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Edit Rak</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Rak</label>
                    <input type="text" name="nama_rak" id="editNamaRak" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi" id="editLokasi"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                            class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditModal(id, nama, lokasi) {
            document.getElementById('editForm').action = '/admin/rak/' + id;
            document.getElementById('editNamaRak').value = nama;
            document.getElementById('editLokasi').value = lokasi || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
    @endpush
</x-admin-layout>
