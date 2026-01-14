<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan Digital') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Nunito', sans-serif; }
            h1, h2, h3, h4, h5, h6, .font-fredoka { font-family: 'Fredoka', sans-serif; }
            
            .auth-background {
                background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #059669 100%);
                position: relative;
                min-height: 100vh;
            }
            
            .auth-background::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.5;
            }
            
            .floating-icons {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }
            
            .floating-icons i {
                position: absolute;
                color: rgba(255, 255, 255, 0.08);
                animation: float 20s infinite ease-in-out;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                25% { transform: translateY(-15px) rotate(5deg); }
                50% { transform: translateY(-25px) rotate(-5deg); }
                75% { transform: translateY(-10px) rotate(3deg); }
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
                            0 0 0 1px rgba(255, 255, 255, 0.1);
            }
            
            .input-focus:focus {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-background flex flex-col items-center justify-center min-h-screen p-4 sm:p-6">
            <!-- Floating Icons Background -->
            <div class="floating-icons">
                <i class="fas fa-book text-7xl" style="top: 5%; left: 5%; animation-delay: 0s;"></i>
                <i class="fas fa-book-open text-8xl" style="top: 15%; right: 10%; animation-delay: 2s;"></i>
                <i class="fas fa-bookmark text-6xl" style="top: 40%; left: 8%; animation-delay: 4s;"></i>
                <i class="fas fa-graduation-cap text-9xl" style="top: 60%; right: 5%; animation-delay: 6s;"></i>
                <i class="fas fa-book-reader text-7xl" style="bottom: 15%; left: 15%; animation-delay: 8s;"></i>
                <i class="fas fa-pencil-alt text-5xl" style="bottom: 25%; right: 20%; animation-delay: 10s;"></i>
                <i class="fas fa-lightbulb text-6xl" style="top: 75%; left: 25%; animation-delay: 12s;"></i>
                <i class="fas fa-star text-4xl" style="top: 20%; left: 30%; animation-delay: 14s;"></i>
            </div>
            
            <!-- Logo & Branding -->
            <div class="relative z-10 text-center mb-6 sm:mb-8">
                <a href="/" class="inline-flex flex-col items-center group">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-2xl mb-3 group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-book-open text-3xl sm:text-4xl text-white"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white font-fredoka tracking-wide drop-shadow-lg">Perpustakaan Digital</h1>
                </a>
            </div>
            
            <!-- Card Container -->
            <div class="relative z-10 w-full max-w-md">
                <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl">
                    {{ $slot }}
                </div>
            </div>
            
            <!-- Footer -->
            <div class="relative z-10 mt-6 sm:mt-8 text-center text-white/70 text-xs sm:text-sm">
                <p>&copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
