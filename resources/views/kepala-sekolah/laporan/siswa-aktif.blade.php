<x-kepala-sekolah-layout>
    <x-slot name="title">Siswa Paling Aktif</x-slot>
    <x-slot name="subtitle">Siswa dengan peminjaman terbanyak</x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm">
                        <th class="py-4 px-4 text-center rounded-l-xl">Peringkat</th>
                        <th class="py-4 px-4 text-left">Nama Siswa</th>
                        <th class="py-4 px-4 text-center">NISN</th>
                        <th class="py-4 px-4 text-center">Kelas</th>
                        <th class="py-4 px-4 text-center rounded-r-xl">Total Peminjaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($siswas as $index => $siswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 text-center">
                                @if($siswas->firstItem() + $index <= 3)
                                    <span class="w-8 h-8 inline-flex items-center justify-center rounded-full 
                                        {{ $siswas->firstItem() + $index == 1 ? 'bg-yellow-400 text-white' : '' }}
                                        {{ $siswas->firstItem() + $index == 2 ? 'bg-gray-300 text-white' : '' }}
                                        {{ $siswas->firstItem() + $index == 3 ? 'bg-amber-600 text-white' : '' }}
                                        font-bold">
                                        {{ $siswas->firstItem() + $index }}
                                    </span>
                                @else
                                    {{ $siswas->firstItem() + $index }}
                                @endif
                            </td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ $siswa->name }}</td>
                            <td class="py-4 px-4 text-center font-mono text-sm">{{ $siswa->nisn ?? '-' }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $siswa->kelas ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="text-lg font-bold text-amber-600">{{ $siswa->peminjamans_count }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $siswas->links() }}</div>
    </div>
</x-kepala-sekolah-layout>
