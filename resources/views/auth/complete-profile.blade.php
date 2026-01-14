<x-guest-layout>
    <!-- Complete Profile Header -->
    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user-edit text-2xl text-amber-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800 font-fredoka mb-2">Lengkapi Data Profil</h2>
        <p class="text-slate-500 text-sm">Silakan lengkapi data diri Anda untuk melanjutkan</p>
    </div>

    @if(session('info'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
            <i class="fas fa-info-circle"></i>
            {{ session('info') }}
        </div>
    @endif

    <form method="POST" action="{{ route('siswa.complete-profile.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Display Name (Read-only) -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-user text-emerald-500 mr-2"></i>Nama
            </label>
            <input 
                type="text" 
                value="{{ auth()->user()->name }}" 
                disabled
                class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 text-sm cursor-not-allowed"
            >
        </div>

        <!-- Display Email (Read-only) -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-envelope text-emerald-500 mr-2"></i>Email
            </label>
            <input 
                type="email" 
                value="{{ auth()->user()->email }}" 
                disabled
                class="block w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-600 text-sm cursor-not-allowed"
            >
        </div>

        <!-- NISN -->
        <div>
            <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-id-card text-emerald-500 mr-2"></i>NISN <span class="text-red-500">*</span>
            </label>
            <input 
                id="nisn" 
                type="text" 
                name="nisn" 
                value="{{ old('nisn', auth()->user()->nisn) }}" 
                required
                maxlength="10"
                pattern="[0-9]{10}"
                class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                placeholder="Masukkan 10 digit NISN"
            >
            <p class="mt-1 text-xs text-slate-400">Nomor Induk Siswa Nasional (10 digit)</p>
            <x-input-error :messages="$errors->get('nisn')" class="mt-1.5" />
        </div>

        <!-- Kelas & Jenis Kelamin Row -->
        <div class="grid grid-cols-2 gap-3">
            <!-- Kelas -->
            <div>
                <label for="kelas" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    <i class="fas fa-school text-emerald-500 mr-2"></i>Kelas <span class="text-red-500">*</span>
                </label>
                <select 
                    id="kelas" 
                    name="kelas" 
                    required
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm appearance-none cursor-pointer"
                >
                    <option value="" disabled {{ old('kelas', auth()->user()->kelas) ? '' : 'selected' }}>Pilih Kelas</option>
                    @foreach(['1', '2', '3', '4', '5', '6'] as $k)
                        <option value="{{ $k }}" {{ old('kelas', auth()->user()->kelas) == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('kelas')" class="mt-1.5" />
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    <i class="fas fa-venus-mars text-emerald-500 mr-2"></i>Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select 
                    id="jenis_kelamin" 
                    name="jenis_kelamin" 
                    required
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm appearance-none cursor-pointer"
                >
                    <option value="" disabled {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) ? '' : 'selected' }}>Pilih</option>
                    <option value="L" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1.5" />
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-5">
            <span>Simpan & Lanjutkan</span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <!-- Logout Link -->
    <div class="mt-5 text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-slate-400 hover:text-red-500 transition-colors">
                <i class="fas fa-sign-out-alt mr-1"></i> Keluar dari akun ini
            </button>
        </form>
    </div>
</x-guest-layout>
