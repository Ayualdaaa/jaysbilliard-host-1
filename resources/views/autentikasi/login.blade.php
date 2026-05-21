<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Jay's Billiard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="relative flex items-center justify-center min-h-screen p-8 md:p-6 sm:p-4">
        {{-- Background --}}
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/login-bg.png') }}" alt="Background" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/65 backdrop-blur-sm"></div>
        </div>

        {{-- Login Card --}}
        <div class="relative z-10 w-full max-w-md bg-[#0f141e]/85 backdrop-blur-custom border border-primary/15 rounded-2xl p-10 md:p-8 sm:p-7 shadow-2xl">
            <a href="{{ url('/') }}" class="flex items-center justify-center w-10 h-10 bg-white/5 border border-primary/20 rounded-lg text-white/40 mb-6 transition-all hover:bg-primary/10 hover:text-primary hover:border-primary/40 hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-3xl md:text-2xl font-extrabold text-white mb-2">Login</h1>
            <p class="text-white/50 text-sm leading-relaxed mb-8">Masuk ke akun Anda untuk memesan meja, makanan dan lain-lain</p>

            @if(session('success'))
                <div class="bg-primary/10 border border-primary/30 rounded-xl px-4 py-3 mb-4">
                    <p class="text-primary text-sm m-0 leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500/15 border border-red-500/30 rounded-xl px-4 py-3 mb-4">
                    <p class="text-red-400 text-sm m-0 leading-relaxed">{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/15 border border-red-500/30 rounded-xl px-4 py-3 mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-red-400 text-sm m-0 leading-relaxed">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                {{-- Username --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-white">Username</label>
                    <div class="flex items-center bg-white/5 border border-primary/20 rounded-xl px-4 transition-all focus-within:border-primary focus-within:shadow-neon-sm">
                        <span class="flex items-center text-white/35 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input type="text" name="username" class="flex-1 bg-transparent border-none outline-none text-white text-sm py-3.5 placeholder:text-white/30" placeholder="Masukkan username anda" value="{{ old('username') }}" required>
                    </div>
                </div>

                {{-- Kata Sandi --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-white">Kata Sandi</label>
                    <div class="flex items-center bg-white/5 border border-primary/20 rounded-xl px-4 transition-all focus-within:border-primary focus-within:shadow-neon-sm">
                        <span class="flex items-center text-white/35 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                        </span>
                        <input type="password" name="password" id="passwordInput" class="flex-1 bg-transparent border-none outline-none text-white text-sm py-3.5 placeholder:text-white/30" placeholder="Masukkan kata sandi anda" required>
                        <button type="button" class="flex items-center bg-transparent border-none text-white/40 cursor-pointer p-1 transition-colors hover:text-primary" onclick="togglePassword()">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm text-white/60 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-primary cursor-pointer">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-primary transition-opacity hover:opacity-80">Lupa Kata Sandi?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-primary to-primary-dark text-black font-bold text-base px-4 py-3.5 rounded-xl border-none cursor-pointer transition-all hover:shadow-neon hover:-translate-y-0.5">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                </button>
            </form>

            <div class="relative flex py-4 items-center">
                <div class="flex-grow border-t border-white/10"></div>
                <span class="flex-shrink mx-4 text-white/40 text-xs font-semibold uppercase">atau</span>
                <div class="flex-grow border-t border-white/10"></div>
            </div>

            <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full bg-white/5 border border-white/10 hover:border-white/20 text-white font-semibold text-sm px-4 py-3.5 rounded-xl cursor-pointer transition-all hover:bg-white/10 hover:-translate-y-0.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>

            <p class="text-center text-sm text-white/50 mt-6">
                Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-semibold transition-opacity hover:opacity-80">Sign Up</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>
