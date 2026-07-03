<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Formulir</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAFBFF;
        }
        /* Prevent SweetAlert2 from shifting layout */
        body.swal2-shown {
            padding-right: 0 !important;
            overflow: hidden !important;
            height: 100vh !important;
        }
        html.swal2-shown {
            overflow: hidden !important;
            height: 100% !important;
        }
        /* Keep the app wrapper always filling full height */
        body > .flex {
            height: 100vh !important;
            max-height: 100vh !important;
        }
    </style>
</head>
<body class="text-gray-800 h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 min-w-[256px] max-w-[256px] bg-white border-r border-gray-200 flex-shrink-0 flex flex-col overflow-hidden">
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 gap-3 border-b border-gray-200 whitespace-nowrap min-w-max w-64">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-kai.svg') }}" class="w-8 h-8" alt="Logo KAI">
                <span class="font-bold text-lg text-gray-900">Formulir</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-6 space-y-2 overflow-y-auto whitespace-nowrap min-w-max w-64">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('formulir.index') }}" class="{{ request()->routeIs('formulir.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Formulir</span>
            </a>
        </nav>
        
        <!-- User Profile -->
        <div class="px-5 py-4 border-t border-gray-200 whitespace-nowrap min-w-max w-64">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Admin+KAI&background=0D8ABC&color=fff" alt="User" class="w-10 h-10 rounded-full flex-shrink-0">
                <div>
                    <p class="text-sm font-medium text-gray-900">Admin KAI</p>
                    <p class="text-xs text-gray-500">admin@kai.id</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 bg-white shadow-[inset_1px_0_0_0_rgba(0,0,0,0.05)]">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0 transition-all duration-300">
            <div class="flex items-center gap-4">
                <!-- Page Title -->
                <h1 class="text-xl font-bold text-gray-900">@yield('title')</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-200 shadow-sm">
                     <img src="https://ui-avatars.com/api/?name=Admin+KAI&background=0D8ABC&color=fff" alt="User">
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main id="scroll-wrapper" class="flex-1 overflow-y-auto bg-[#FAFBFF]">
            <div id="scroll-content" class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
    
    @include('components.custom-datepicker')
    
    <!-- Lenis Smooth Scroll -->
    <script src="https://unpkg.com/lenis@1.0.45/dist/lenis.min.js"></script>
    <script>
        const scrollWrapper = document.getElementById('scroll-wrapper');
        const scrollContent = document.getElementById('scroll-content');
        
        const lenis = new Lenis({
            wrapper: scrollWrapper,
            content: scrollContent,
            lerp: 0.15, // 0.15 membuat scroll terasa lebih ringan dan responsif
            smoothWheel: true,
            wheelMultiplier: 1.5, // Meningkatkan kecepatan respons scroll
        })
        
        function raf(time) {
            lenis.raf(time)
            requestAnimationFrame(raf)
        }
        
        requestAnimationFrame(raf)
    </script>
    
    @yield('scripts')
</body>
</html>
