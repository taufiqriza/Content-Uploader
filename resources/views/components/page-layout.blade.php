<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Al-Amani Content Hub - Multi-Platform Content Uploader' }}">
    <title>{{ $title ?? 'Page' }} - Al-Amani Content Hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased">
    <!-- Navbar -->
    <x-navbar />

    <!-- Breadcrumb (if not homepage) -->
    @if(isset($title) && $title !== 'Beranda')
    <div class="bg-gray-100 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center gap-2 text-sm">
                <a href="/" class="text-gray-500 hover:text-blue-600 transition">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-700 font-medium">{{ $title }}</span>
            </nav>
        </div>
    </div>
    @endif

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />
</body>
</html>
