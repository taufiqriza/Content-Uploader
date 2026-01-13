<!-- Navbar Component -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-play text-white text-sm"></i>
                </div>
                <span class="font-bold text-lg text-gray-900">Al-Amani<span class="text-blue-600">Hub</span></span>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-1">
                @php
                    $currentPath = request()->path();
                    $navItems = [
                        ['url' => '/', 'label' => 'Beranda', 'match' => '/'],
                        ['url' => '/about', 'label' => 'Tentang', 'match' => 'about'],
                        ['url' => '/pricing', 'label' => 'Harga', 'match' => 'pricing'],
                        ['url' => '/faq', 'label' => 'FAQ', 'match' => 'faq'],
                        ['url' => '/contact', 'label' => 'Kontak', 'match' => 'contact'],
                    ];
                @endphp
                
                @foreach($navItems as $item)
                    @php
                        $isActive = ($item['match'] === '/' && $currentPath === '/') || 
                                   ($item['match'] !== '/' && str_contains($currentPath, $item['match']));
                    @endphp
                    <a href="{{ $item['url'] }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ $isActive ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            
            <div class="flex items-center gap-3">
                @php
                    $isLoginPage = str_contains($currentPath, 'login');
                    $isRegisterPage = str_contains($currentPath, 'register');
                @endphp
                
                @if(!$isLoginPage)
                    <a href="/login" class="text-gray-600 hover:text-blue-600 text-sm font-medium transition {{ $isLoginPage ? 'text-blue-600' : '' }}">Masuk</a>
                @endif
                @if(!$isRegisterPage)
                    <a href="/register" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-600/30 transition">
                        Daftar Gratis
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation -->
    <div class="md:hidden border-t border-gray-100">
        <div class="flex justify-around py-2">
            @php
                $mobileItems = [
                    ['url' => '/', 'label' => 'Home', 'icon' => 'fas fa-home', 'match' => '/'],
                    ['url' => '/about', 'label' => 'About', 'icon' => 'fas fa-info-circle', 'match' => 'about'],
                    ['url' => '/pricing', 'label' => 'Harga', 'icon' => 'fas fa-tag', 'match' => 'pricing'],
                    ['url' => '/faq', 'label' => 'FAQ', 'icon' => 'fas fa-question-circle', 'match' => 'faq'],
                    ['url' => '/contact', 'label' => 'Kontak', 'icon' => 'fas fa-envelope', 'match' => 'contact'],
                ];
            @endphp
            
            @foreach($mobileItems as $item)
                @php
                    $isActive = ($item['match'] === '/' && $currentPath === '/') || 
                               ($item['match'] !== '/' && str_contains($currentPath, $item['match']));
                @endphp
                <a href="{{ $item['url'] }}" 
                   class="flex flex-col items-center px-2 py-1 {{ $isActive ? 'text-blue-600' : 'text-gray-500' }}">
                    <i class="{{ $item['icon'] }} text-sm"></i>
                    <span class="text-[10px] mt-0.5">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</nav>
