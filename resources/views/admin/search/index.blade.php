<x-admin-layout>
    <x-slot name="title">Hasil Pencarian</x-slot>
    <x-slot name="subtitle">{{ $totalResults }} hasil untuk "{{ $query }}"</x-slot>

    <div class="space-y-6">
        @if(strlen($query) < 2)
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <i class="fas fa-search text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">Masukkan minimal 2 karakter untuk mencari</p>
            </div>
        @elseif($totalResults === 0)
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">Tidak ditemukan hasil untuk "{{ $query }}"</p>
            </div>
        @else
            <!-- Buku Results -->
            @if(count($results['buku']) > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-book text-emerald-600"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Buku ({{ count($results['buku']) }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['buku'] as $buku)
                            <a href="{{ route('admin.buku.edit', $buku) }}" class="flex items-center gap-4 py-3 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                <div class="w-12 h-16 bg-slate-200 rounded-lg overflow-hidden shrink-0">
                                    @if($buku->cover)
                                        <img src="{{ Storage::url($buku->cover) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-800 truncate">{{ $buku->judul }}</p>
                                    <p class="text-sm text-slate-500">{{ $buku->penulis }} • {{ $buku->kode_buku }}</p>
                                </div>
                                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Siswa Results -->
            @if(count($results['siswa']) > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Siswa ({{ count($results['siswa']) }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['siswa'] as $siswa)
                            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="flex items-center gap-4 py-3 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold shrink-0">
                                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-800 truncate">{{ $siswa->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $siswa->nisn }} • {{ $siswa->kelas }}</p>
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-lg">{{ $siswa->email }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Peminjaman Results -->
            @if(count($results['peminjaman']) > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hand-holding text-amber-600"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Peminjaman ({{ count($results['peminjaman']) }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['peminjaman'] as $p)
                            <div class="flex items-center gap-4 py-3 px-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold shrink-0">
                                    {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-800 truncate">{{ $p->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-slate-500">{{ $p->buku->judul ?? 'Unknown' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $p->status === 'dipinjam' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                    <p class="text-xs text-slate-400 mt-1">{{ $p->tanggal_pinjam->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-admin-layout>
