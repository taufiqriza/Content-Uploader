<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Al-Amani Content Hub - Platform Multi-Platform Content Uploader untuk upload konten ke YouTube, Instagram, TikTok, dan Facebook secara bersamaan.">
    <title>Al-Amani Content Hub | Multi-Platform Content Uploader</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-play text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-lg text-gray-900">Al-Amani<span class="text-blue-600">Hub</span></span>
                </a>
                
                <div class="hidden md:flex items-center gap-6">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 text-sm font-medium transition">Fitur</a>
                    <a href="#platforms" class="text-gray-600 hover:text-blue-600 text-sm font-medium transition">Platform</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 text-sm font-medium transition">Cara Kerja</a>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="/admin/login" class="text-gray-600 hover:text-blue-600 text-sm font-medium transition">Masuk</a>
                    <a href="/admin/register" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition">
                        Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-12 lg:py-20 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white/5 rounded-full"></div>
        
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <div class="inline-block px-4 py-1.5 bg-white/10 rounded-full text-blue-200 text-sm font-medium mb-6">
                <i class="fas fa-rocket mr-2"></i>Upload ke 4 Platform Sekaligus
            </div>
            
            <h1 class="text-3xl lg:text-5xl font-bold mb-4">
                Multi-Platform<br>Content Uploader
            </h1>
            <p class="text-blue-200 text-base lg:text-lg mb-8 max-w-2xl mx-auto">
                Upload video dan gambar ke YouTube, Instagram, TikTok, dan Facebook dalam satu klik. Hemat waktu, tingkatkan produktivitas!
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-10">
                <a href="/admin/register" class="w-full sm:w-auto px-8 py-3.5 bg-white text-blue-600 font-semibold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
                    <span>Mulai Gratis</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#how-it-works" class="w-full sm:w-auto px-8 py-3.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-play-circle"></i>
                    <span>Lihat Demo</span>
                </a>
            </div>
            
            <!-- Quick Tags -->
            <div class="flex flex-wrap items-center justify-center gap-2">
                <span class="text-blue-200 text-xs">Didukung:</span>
                <span class="px-3 py-1 bg-red-500/20 text-white text-xs rounded-full"><i class="fab fa-youtube mr-1"></i>YouTube</span>
                <span class="px-3 py-1 bg-pink-500/20 text-white text-xs rounded-full"><i class="fab fa-instagram mr-1"></i>Instagram</span>
                <span class="px-3 py-1 bg-black/20 text-white text-xs rounded-full"><i class="fab fa-tiktok mr-1"></i>TikTok</span>
                <span class="px-3 py-1 bg-blue-500/20 text-white text-xs rounded-full"><i class="fab fa-facebook mr-1"></i>Facebook</span>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="max-w-7xl mx-auto px-4 -mt-8 lg:-mt-12 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
            <div class="bg-white rounded-xl p-4 shadow-lg flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-share-alt text-blue-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-xl lg:text-2xl font-bold text-gray-900">4+</div>
                    <div class="text-xs text-gray-500">Platform</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg flex items-center gap-3">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-upload text-emerald-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-xl lg:text-2xl font-bold text-gray-900">1x</div>
                    <div class="text-xs text-gray-500">Upload</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg flex items-center gap-3">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-purple-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-xl lg:text-2xl font-bold text-gray-900">75%</div>
                    <div class="text-xs text-gray-500">Lebih Cepat</div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg flex items-center gap-3">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-infinity text-orange-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-xl lg:text-2xl font-bold text-gray-900">∞</div>
                    <div class="text-xs text-gray-500">Reach</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="max-w-7xl mx-auto px-4 py-12 lg:py-16" id="features">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full mb-3">
                <i class="fas fa-sparkles mr-1"></i>FITUR UNGGULAN
            </span>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">Satu Dashboard, Semua Platform</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kelola konten multi-platform dengan mudah dan efisien dari satu tempat</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-cloud-upload-alt text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Multi-Platform Upload</h3>
                <p class="text-gray-600 text-sm">Upload sekali, publish ke YouTube, Instagram, TikTok, dan Facebook sekaligus dalam hitungan detik.</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Scheduled Publishing</h3>
                <p class="text-gray-600 text-sm">Jadwalkan posting untuk waktu terbaik. Konten akan otomatis terbit sesuai jadwal.</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Real-time Status</h3>
                <p class="text-gray-600 text-sm">Pantau status upload secara real-time. Lihat mana yang berhasil dan yang perlu retry.</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-sync-alt text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Auto Retry</h3>
                <p class="text-gray-600 text-sm">Gagal upload? Sistem otomatis mencoba ulang. Anda juga bisa retry manual kapan saja.</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Secure OAuth</h3>
                <p class="text-gray-600 text-sm">Koneksi aman dengan OAuth. Token terenkripsi dan auto-refresh sebelum expired.</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition group">
                <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-cloud text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600">Cloud Storage</h3>
                <p class="text-gray-600 text-sm">File tersimpan aman di Cloudflare R2. Tidak perlu khawatir storage lokal penuh.</p>
            </div>
        </div>
    </section>

    <!-- Platforms -->
    <section class="bg-white py-12 lg:py-16" id="platforms">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-full mb-3">
                    <i class="fas fa-link mr-1"></i>TERINTEGRASI
                </span>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">Platform yang Didukung</h2>
                <p class="text-gray-600">Hubungkan semua akun sosial media Anda dengan mudah</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
                <div class="bg-gray-50 rounded-xl p-6 text-center hover:bg-red-50 hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <i class="fab fa-youtube text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">YouTube</h4>
                    <p class="text-gray-500 text-sm">Video & Shorts</p>
                    <span class="inline-block mt-3 px-3 py-1 bg-emerald-100 text-emerald-600 text-xs rounded-full"><i class="fas fa-check mr-1"></i>Aktif</span>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 text-center hover:bg-pink-50 hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 via-red-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <i class="fab fa-instagram text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Instagram</h4>
                    <p class="text-gray-500 text-sm">Feed, Reels & Story</p>
                    <span class="inline-block mt-3 px-3 py-1 bg-emerald-100 text-emerald-600 text-xs rounded-full"><i class="fas fa-check mr-1"></i>Aktif</span>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 text-center hover:bg-gray-100 hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <i class="fab fa-tiktok text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">TikTok</h4>
                    <p class="text-gray-500 text-sm">Video Posts</p>
                    <span class="inline-block mt-3 px-3 py-1 bg-emerald-100 text-emerald-600 text-xs rounded-full"><i class="fas fa-check mr-1"></i>Aktif</span>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6 text-center hover:bg-blue-50 hover:shadow-lg transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <i class="fab fa-facebook-f text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-1">Facebook</h4>
                    <p class="text-gray-500 text-sm">Page Posts & Videos</p>
                    <span class="inline-block mt-3 px-3 py-1 bg-emerald-100 text-emerald-600 text-xs rounded-full"><i class="fas fa-check mr-1"></i>Aktif</span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="max-w-7xl mx-auto px-4 py-12 lg:py-16" id="how-it-works">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full mb-3">
                <i class="fas fa-list-ol mr-1"></i>CARA KERJA
            </span>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">3 Langkah Mudah</h2>
            <p class="text-gray-600">Mulai upload konten multi-platform dalam hitungan menit</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 relative">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                    <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 hidden md:block">
                        <i class="fas fa-arrow-right text-gray-300"></i>
                    </div>
                </div>
                <h4 class="font-bold text-gray-900 text-lg mb-2">Hubungkan Akun</h4>
                <p class="text-gray-600 text-sm">Login dengan OAuth ke YouTube, Instagram, TikTok, dan Facebook Anda.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 relative">
                    <span class="text-2xl font-bold text-purple-600">2</span>
                    <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 hidden md:block">
                        <i class="fas fa-arrow-right text-gray-300"></i>
                    </div>
                </div>
                <h4 class="font-bold text-gray-900 text-lg mb-2">Upload Konten</h4>
                <p class="text-gray-600 text-sm">Upload video atau gambar, tulis caption, dan pilih platform tujuan.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-emerald-600">3</span>
                </div>
                <h4 class="font-bold text-gray-900 text-lg mb-2">Publish!</h4>
                <p class="text-gray-600 text-sm">Klik publish dan sistem akan upload ke semua platform secara otomatis.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl p-8 lg:p-12 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl lg:text-3xl font-bold mb-4">Siap Meningkatkan Produktivitas?</h2>
                <p class="text-blue-200 mb-8 max-w-xl mx-auto">Mulai upload konten multi-platform sekarang. Gratis untuk memulai, tanpa kartu kredit!</p>
                <a href="/admin/register" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-blue-600 font-semibold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition">
                    <span>Daftar Sekarang</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 lg:py-12 mt-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <a href="/" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-play text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-lg text-gray-900">Al-Amani<span class="text-blue-600">Hub</span></span>
                    </a>
                    <p class="text-gray-600 text-sm max-w-sm">Platform upload konten multi-platform untuk kreator dan bisnis. Kelola semua sosial media dari satu dashboard.</p>
                </div>
                
                <div>
                    <h5 class="font-bold text-gray-900 mb-4">Platform</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">YouTube</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Instagram</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">TikTok</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Facebook</a></li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="font-bold text-gray-900 mb-4">Tautan</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/admin/login" class="text-gray-600 hover:text-blue-600 transition">Masuk</a></li>
                        <li><a href="/admin/register" class="text-gray-600 hover:text-blue-600 transition">Daftar</a></li>
                        <li><a href="https://alamani.edu.my" class="text-gray-600 hover:text-blue-600 transition">Al-Amani</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">© 2026 Al-Amani Content Hub. All rights reserved.</p>
                <p class="text-gray-500 text-sm">Made with <span class="text-red-500">❤</span> by <a href="https://alamani.edu.my" class="text-blue-600 hover:underline">Madrasah Tahfiz Al-Amani</a></p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
