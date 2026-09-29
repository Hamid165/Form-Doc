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
<body class="text-gray-800 h-screen flex overflow-hidden" x-data="{ sidebarOpen: true, roleModalOpen: false, roleTarget: '', roleTargetName: '', rolePassword: '' }">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-64 min-w-[256px] max-w-[256px]' : 'w-20 min-w-[80px] max-w-[80px]'" class="bg-white border-r border-gray-200 flex-shrink-0 flex flex-col overflow-hidden transition-all duration-300">
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-5 gap-3 border-b border-gray-200 whitespace-nowrap overflow-hidden flex-shrink-0">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-1 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none flex-shrink-0" title="Toggle Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex items-center gap-3 transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                <img src="{{ asset('images/logo-kai.svg') }}" class="w-8 h-8 flex-shrink-0" alt="Logo KAI">
                <span class="font-bold text-lg text-gray-900">Formulir</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-6 space-y-2 overflow-y-auto whitespace-nowrap overflow-hidden">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">Dashboard</span>
            </a>
            <a href="{{ route('formulir.index') }}" class="{{ request()->routeIs('formulir.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">Formulir</span>
            </a>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'bg-orange-50 text-orange-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                    <svg class="w-6 h-6 flex-shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">Kelola Petugas</span>
                </a>
                <a href="{{ route('logs.index') }}" class="{{ request()->routeIs('logs.*') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-4 px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                    <svg class="w-6 h-6 flex-shrink-0 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">Log Aktivitas</span>
                </a>
            @endif

            @if(auth()->check() && in_array(auth()->user()->role, ['pimpinan', 'admin']))
                @php
                    $u = auth()->user();
                    $pendingQuery = \App\Models\FormBastik\FormBastik::where('status', 'submitted');
                    if ($u->role === 'pimpinan') {
                        $pendingQuery->whereHas('pimpinan', function ($sq) use ($u) {
                            $sq->where('nipp', $u->nip_kwt)
                               ->orWhere('nama', $u->name);
                        });
                    }
                    $pendingCount = $pendingQuery->count();
                @endphp
                <a href="{{ route('form-bastik.pending-approval') }}" class="{{ request()->routeIs('form-bastik.pending-approval') ? 'bg-amber-50 text-amber-700 font-bold' : 'text-gray-600 hover:bg-amber-50 hover:text-amber-800' }} flex items-center justify-between px-4 py-2.5 mx-3 rounded-lg font-medium transition-colors">
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">Pending Approval</span>
                    </div>
                    @if($pendingCount > 0)
                        <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="px-2 py-0.5 text-xs font-bold bg-amber-500 text-white rounded-full transition-opacity duration-300">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endif
        </nav>
        
        <!-- User Profile -->
        <div class="px-5 py-4 border-t border-gray-200 whitespace-nowrap overflow-hidden flex-shrink-0">
            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 hover:opacity-80 transition" title="Lihat Profil Saya">
                @php
                    $u = auth()->user();
                @endphp
                <img src="https://ui-avatars.com/api/?name={{ urlencode($u ? $u->name : 'Admin KAI') }}&background=0D8ABC&color=fff" alt="User" class="w-10 h-10 rounded-full flex-shrink-0 -ml-1">
                <div :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" class="transition-opacity duration-300">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $u ? $u->name : 'Admin KAI' }}</p>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold text-orange-600">{{ $u ? ($u->role ?? 'Petugas') : 'Administrator' }}</p>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 bg-white shadow-[inset_1px_0_0_0_rgba(0,0,0,0.05)]">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0 transition-all duration-300">
            <div class="flex items-center gap-4">
                @yield('back_button')
                <!-- Page Title -->
                <h1 class="text-xl font-bold text-gray-900">@yield('title')</h1>
            </div>
            
            <div class="flex items-center gap-4">
                @php
                    $u = auth()->user();
                @endphp

                <!-- Switch Role Quick Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 text-xs font-medium text-gray-700 transition">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-gray-900">Peran:</span>
                        <span class="uppercase text-orange-600 font-bold">{{ $u ? ($u->role ?? 'Petugas') : 'Admin' }}</span>
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-1.5 w-60 bg-white text-gray-800 rounded-lg shadow-xl py-1 border border-gray-200 z-50">
                        <div class="px-3 py-1.5 text-[10px] border-b border-gray-100 font-bold text-gray-400 uppercase">Pilih Akun / Peran:</div>
                        @php
                            $allUsersList = \App\Models\User::orderBy('name', 'asc')->get();
                        @endphp
                        @foreach($allUsersList as $userItem)
                            <button type="button" 
                                    @click="open = false; roleTarget = '{{ $userItem->role }}'; roleTargetName = '{{ e($userItem->name) }} ({{ strtoupper($userItem->role) }})'; rolePassword = ''; roleModalOpen = true;" 
                                    class="w-full text-left px-4 py-2 text-xs hover:bg-gray-50 font-medium flex items-center justify-between {{ (auth()->user()->id ?? null) === $userItem->id ? 'bg-orange-50 font-bold text-orange-600' : '' }}">
                                <div class="truncate mr-2">
                                    <span class="block truncate font-semibold">{{ $userItem->name }}</span>
                                    <span class="block text-[10px] text-gray-400 font-normal uppercase">{{ $userItem->role }}</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </button>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('profile.show') }}" class="w-8 h-8 rounded-full overflow-hidden border border-gray-200 shadow-sm flex-shrink-0 hover:ring-2 hover:ring-orange-400 transition" title="Profil Saya">
                     <img src="https://ui-avatars.com/api/?name={{ urlencode($u ? $u->name : 'Admin KAI') }}&background=0D8ABC&color=fff" alt="User">
                </a>
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

    <!-- Modal Password Verifikasi Ganti Peran -->
    <div x-show="roleModalOpen" 
         x-cloak 
         style="display: none;"
         class="fixed inset-0 z-[999] overflow-y-auto flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 relative"
             @click.away="roleModalOpen = false">
            
            <div class="flex items-center gap-3.5 mb-5 pb-4 border-b border-gray-100">
                <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 border border-orange-200 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Verifikasi Password Peran</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Beralih ke peran: <span class="font-bold text-orange-600" x-text="roleTargetName"></span></p>
                </div>
            </div>

            <form action="{{ route('switch-role') }}" method="POST">
                @csrf
                <input type="hidden" name="role" :value="roleTarget">
                
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Password Akses Peran <span class="text-rose-500">*</span></label>
                    <div class="relative" x-data="{ showPass: false }">
                        <input :type="showPass ? 'text' : 'password'" 
                               name="password" 
                               x-model="rolePassword" 
                               required 
                               placeholder="Masukkan password..." 
                               class="w-full h-11 pl-3.5 pr-10 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition shadow-sm">
                        <button type="button" 
                                @click="showPass = !showPass" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition p-1"
                                title="Tampilkan / Sembunyikan Password">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" x-cloak class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.04 10.04 0 012.122-.363c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.59-4.59a3 3 0 10-4.243-4.243m4.242 4.242L3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-2 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Default password: <code class="bg-gray-100 text-gray-800 font-mono px-1.5 py-0.5 rounded border border-gray-200">password</code></span>
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-gray-100">
                    <button type="button" 
                            @click="roleModalOpen = false" 
                            class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl transition shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Konfirmasi & Ganti Peran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
