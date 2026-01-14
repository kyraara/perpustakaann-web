<x-guest-layout>
    <!-- Forgot Password Header -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-key text-2xl text-amber-600"></i>
        </div>
        <h2 class="text-3xl font-bold text-slate-800 font-fredoka mb-2">Lupa Password?</h2>
        <p class="text-slate-500 text-sm leading-relaxed">
            Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                <i class="fas fa-envelope text-emerald-500 mr-2"></i>Email
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
                class="block w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200"
                placeholder="nama@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
            <i class="fas fa-paper-plane"></i>
            <span>Kirim Link Reset</span>
        </button>
    </form>

    <!-- Back to Login Link -->
    <p class="mt-8 text-center text-sm text-slate-500">
        <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors inline-flex items-center gap-2">
            <i class="fas fa-arrow-left text-xs"></i>
            Kembali ke halaman login
        </a>
    </p>
</x-guest-layout>
