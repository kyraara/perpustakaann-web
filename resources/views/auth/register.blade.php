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

    <!-- Divider -->
    <div class="relative my-5">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="px-4 bg-white text-slate-400 text-xs">atau daftar dengan</span>
        </div>
    </div>

    <!-- Google Register Button -->
    <a href="{{ route('auth.google') }}" 
       class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white border border-slate-200 rounded-xl shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:shadow-md transition-all duration-300 group">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors text-sm">Daftar dengan Google</span>
    </a>

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
