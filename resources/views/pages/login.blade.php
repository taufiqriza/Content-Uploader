<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke Al-Amani Content Hub">
    <title>Masuk - Al-Amani Content Hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased min-h-screen">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-64px)] bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -left-40 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-purple-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-64px)] py-12 px-4">
            <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Side - Branding -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-sparkles"></i>
                        <span>Platform Terpercaya</span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Selamat Datang<br>
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Kembali!</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 max-w-md">
                        Masuk untuk mengelola konten Anda dan menjangkau audiens di semua platform.
                    </p>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check text-emerald-600"></i>
                            </div>
                            <span class="text-gray-700">Upload ke 4 platform sekaligus</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check text-emerald-600"></i>
                            </div>
                            <span class="text-gray-700">Scheduling & Auto-publish</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check text-emerald-600"></i>
                            </div>
                            <span class="text-gray-700">Dashboard analitik real-time</span>
                        </div>
                    </div>

                    <!-- Platforms -->
                    <div class="mt-8 flex items-center gap-4 justify-center lg:justify-start">
                        <span class="text-gray-400 text-sm">Didukung:</span>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-youtube text-red-600 text-sm"></i>
                            </div>
                            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-instagram text-pink-600 text-sm"></i>
                            </div>
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-tiktok text-gray-800 text-sm"></i>
                            </div>
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-facebook text-blue-600 text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full max-w-md">
                    <div class="glass-card rounded-3xl shadow-2xl shadow-gray-200/50 p-8 lg:p-10 border border-white/50">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-600/30">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h2>
                            <p class="text-gray-500 text-sm mt-1">Lanjutkan perjalanan Anda</p>
                        </div>

                        @if(session('status'))
                            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" required 
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white input-focus transition-all duration-200"
                                        placeholder="nama@email.com"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password" id="password" required 
                                        class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white input-focus transition-all duration-200"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="toggle-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                                </label>
                                <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    Lupa password?
                                </a>
                            </div>

                            <button type="submit" 
                                class="w-full py-4 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                <span>Masuk</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="my-8 flex items-center gap-4">
                            <div class="flex-1 h-px bg-gray-200"></div>
                            <span class="text-gray-400 text-sm">atau</span>
                            <div class="flex-1 h-px bg-gray-200"></div>
                        </div>

                        <!-- Register Link -->
                        <p class="text-center text-gray-600">
                            Belum punya akun? 
                            <a href="/register" class="text-blue-600 hover:text-blue-700 font-semibold">
                                Daftar Gratis
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
