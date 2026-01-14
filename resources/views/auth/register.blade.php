<x-guest-layout>
    <!-- Register Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800 font-fredoka mb-1">Daftar Akun Siswa</h2>
        <p class="text-slate-500 text-sm">Lengkapi data diri untuk membuat akun perpustakaan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-user text-emerald-500 mr-2"></i>Nama Lengkap
            </label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                placeholder="Masukkan nama lengkap"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- NISN -->
        <div>
            <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-id-card text-emerald-500 mr-2"></i>NISN
            </label>
            <input 
                id="nisn" 
                type="text" 
                name="nisn" 
                value="{{ old('nisn') }}" 
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
                    <i class="fas fa-school text-emerald-500 mr-2"></i>Kelas
                </label>
                <select 
                    id="kelas" 
                    name="kelas" 
                    required
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm appearance-none cursor-pointer"
                >
                    <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih Kelas</option>
                    <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>Kelas 1</option>
                    <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>Kelas 2</option>
                    <option value="3" {{ old('kelas') == '3' ? 'selected' : '' }}>Kelas 3</option>
                    <option value="4" {{ old('kelas') == '4' ? 'selected' : '' }}>Kelas 4</option>
                    <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kelas 5</option>
                    <option value="6" {{ old('kelas') == '6' ? 'selected' : '' }}>Kelas 6</option>
                </select>
                <x-input-error :messages="$errors->get('kelas')" class="mt-1.5" />
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    <i class="fas fa-venus-mars text-emerald-500 mr-2"></i>Jenis Kelamin
                </label>
                <select 
                    id="jenis_kelamin" 
                    name="jenis_kelamin" 
                    required
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm appearance-none cursor-pointer"
                >
                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1.5" />
            </div>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-envelope text-emerald-500 mr-2"></i>Email
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username"
                class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                placeholder="nama@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-lock text-emerald-500 mr-2"></i>Password
            </label>
            <div class="relative">
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                    placeholder="Minimal 8 karakter"
                >
                <button type="button" onclick="togglePassword('password', 'password-icon')" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i id="password-icon" class="fas fa-eye"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                <i class="fas fa-lock text-emerald-500 mr-2"></i>Konfirmasi Password
            </label>
            <div class="relative">
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                    placeholder="Ulangi password"
                >
                <button type="button" onclick="togglePassword('password_confirmation', 'password-confirm-icon')" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i id="password-confirm-icon" class="fas fa-eye"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-5">
            <span>Daftar Sekarang</span>
            <i class="fas fa-user-plus"></i>
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-5 text-center text-sm text-slate-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
            Masuk sekarang
        </a>
    </p>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
