<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar Al-Amani Content Hub - Gratis!">
    <title>Daftar - Al-Amani Content Hub</title>
    
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
        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
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
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-emerald-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-64px)] py-12 px-4">
            <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Side - Branding -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-gift"></i>
                        <span>100% Gratis untuk Memulai</span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Bergabung dengan<br>
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Al-Amani Hub</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 max-w-md">
                        Daftarkan diri Anda sekarang dan mulai upload konten ke semua platform dalam hitungan menit.
                    </p>

                    <!-- Benefits -->
                    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto lg:mx-0">
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-infinity text-blue-600"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">Unlimited Upload</p>
                        </div>
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-bolt text-purple-600"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">Super Cepat</p>
                        </div>
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-shield-alt text-emerald-600"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">100% Aman</p>
                        </div>
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-headset text-orange-600"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">Support 24/7</p>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="mt-8 bg-white/60 backdrop-blur-sm rounded-xl p-4 max-w-md mx-auto lg:mx-0 hidden lg:block">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                U
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm italic">"Al-Amani Hub menghemat waktu saya 3x lipat. Upload sekali, publish kemana-mana!"</p>
                                <p class="text-gray-800 text-sm font-semibold mt-1">Ustaz Ahmad - Content Creator</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="w-full max-w-md">
                    <div class="glass-card rounded-3xl shadow-2xl shadow-gray-200/50 p-8 lg:p-10 border border-white/50">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-600/30">
                                <i class="fas fa-user-plus text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                            <p class="text-gray-500 text-sm mt-1">Gratis, tanpa kartu kredit</p>
                        </div>

                        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" required 
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white input-focus transition-all duration-200"
                                        placeholder="Nama Anda"
                                        value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

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
                                        placeholder="Minimal 8 karakter"
                                        oninput="checkPasswordStrength(this.value)">
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="toggle-icon"></i>
                                    </button>
                                </div>
                                <!-- Password Strength Indicator -->
                                <div class="flex gap-1 mt-2">
                                    <div id="str-1" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="str-2" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="str-3" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="str-4" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                </div>
                                <p id="strength-text" class="text-xs text-gray-400 mt-1"></p>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" required 
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white input-focus transition-all duration-200"
                                        placeholder="Ulangi password">
                                </div>
                            </div>

                            <div class="flex items-start gap-2 pt-2">
                                <input type="checkbox" name="terms" required class="w-4 h-4 mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-600">
                                    Saya setuju dengan <a href="/terms" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> 
                                    dan <a href="/privacy" class="text-blue-600 hover:underline">Kebijakan Privasi</a>
                                </span>
                            </div>

                            <button type="submit" 
                                class="w-full py-4 px-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/30 hover:shadow-xl hover:shadow-emerald-600/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                <span>Daftar Sekarang</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="my-6 flex items-center gap-4">
                            <div class="flex-1 h-px bg-gray-200"></div>
                            <span class="text-gray-400 text-sm">atau</span>
                            <div class="flex-1 h-px bg-gray-200"></div>
                        </div>

                        <!-- Login Link -->
                        <p class="text-center text-gray-600">
                            Sudah punya akun? 
                            <a href="/login" class="text-blue-600 hover:text-blue-700 font-semibold">
                                Masuk
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

        function checkPasswordStrength(password) {
            const bars = [
                document.getElementById('str-1'),
                document.getElementById('str-2'),
                document.getElementById('str-3'),
                document.getElementById('str-4')
            ];
            const text = document.getElementById('strength-text');
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            bars.forEach((bar, i) => {
                if (i < strength) {
                    if (strength === 1) bar.classList.add('bg-red-400');
                    else if (strength === 2) bar.classList.add('bg-yellow-400');
                    else if (strength === 3) bar.classList.add('bg-blue-400');
                    else bar.classList.add('bg-emerald-400');
                    bar.classList.remove('bg-gray-200');
                } else {
                    bar.className = 'password-strength flex-1 bg-gray-200 rounded-full';
                }
            });

            const msgs = ['', 'Lemah', 'Cukup', 'Baik', 'Kuat'];
            text.textContent = password.length > 0 ? msgs[strength] : '';
        }
    </script>
</body>
</html>
