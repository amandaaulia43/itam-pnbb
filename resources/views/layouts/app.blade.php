<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITAM - PN Bale Bandung</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* Mengubah font default seluruh website menjadi Poppins */
        body { font-family: 'Poppins', sans-serif; }
        
        /* Class tambahan kalau sewaktu-waktu butuh Inter */
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* Custom Scrollbar yang Elegan */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid #f1f5f9; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f1f5f9] text-gray-800 flex h-screen overflow-hidden selection:bg-[#0f4c3a] selection:text-white">

    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-30 hidden lg:hidden backdrop-blur-sm transition-opacity cursor-pointer"></div>

    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-[280px] bg-gradient-to-b from-[#0f4c3a] via-[#0d4031] to-[#082a20] flex flex-col shadow-2xl flex-shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        
        <div class="absolute top-0 left-0 w-full h-40 bg-white/5 blur-2xl rounded-full -translate-y-1/2 pointer-events-none"></div>

        <div class="h-20 flex items-center px-6 border-b border-white/10 bg-black/20 backdrop-blur-sm relative z-10 justify-between lg:justify-start">
            <div class="flex items-center">
                    <div class="bg-[#0f4c3a] p-1.5 rounded-lg shadow-md border border-white/20 shrink-0 mr-3">
                    <img src="{{ asset('images/logo-pnbb.png') }}" alt="Logo PN Bale Bandung" class="h-16 w-auto object-contain">
                </div>
                <div>
                    <h1 class="text-white font-bold text-[18px] tracking-wide m-0 leading-tight">ITAM System</h1>
                    <p class="text-emerald-400 text-[10px] font-semibold tracking-widest uppercase m-0 mt-0.5">PN Bale Bandung</p>
                </div>
            </div>
            <button id="closeSidebarMobile" class="lg:hidden text-gray-400 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto relative z-10">
            <p class="text-white/40 text-xs font-bold px-3 mb-4 tracking-wider uppercase">Menu Utama</p>

            <a href="{{ url('/') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('/') ? 'bg-gradient-to-r from-emerald-500/20 to-transparent border-l-4 border-emerald-400 text-white shadow-[inset_0px_1px_0px_rgba(255,255,255,0.1)]' : 'text-gray-300 hover:bg-white/10 hover:text-white hover:translate-x-1 border-l-4 border-transparent' }}">
                <div class="p-2 rounded-lg {{ request()->is('/') ? 'bg-emerald-500/30 text-emerald-300' : 'bg-white/5 text-gray-400 group-hover:bg-white/10 group-hover:text-white' }} mr-3 transition-colors">
                    <i class="bi bi-grid-1x2-fill text-lg"></i> 
                </div>
                <span class="font-medium">Overview</span>
            </a>
            
            <a href="{{ route('assets.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('assets*') ? 'bg-gradient-to-r from-emerald-500/20 to-transparent border-l-4 border-emerald-400 text-white shadow-[inset_0px_1px_0px_rgba(255,255,255,0.1)]' : 'text-gray-300 hover:bg-white/10 hover:text-white hover:translate-x-1 border-l-4 border-transparent' }}">
                <div class="p-2 rounded-lg {{ request()->is('assets*') ? 'bg-emerald-500/30 text-emerald-300' : 'bg-white/5 text-gray-400 group-hover:bg-white/10 group-hover:text-white' }} mr-3 transition-colors">
                    <i class="bi bi-pc-display-horizontal text-lg"></i> 
                </div>
                <span class="font-medium">Manajemen Aset</span>
            </a>
            
            <a href="{{ route('spk.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('spk.*') ? 'bg-gradient-to-r from-emerald-500/20 to-transparent border-l-4 border-emerald-400 text-white shadow-[inset_0px_1px_0px_rgba(255,255,255,0.1)]' : 'text-gray-300 hover:bg-white/10 hover:text-white hover:translate-x-1 border-l-4 border-transparent' }}">
                <div class="p-2 rounded-lg {{ request()->routeIs('spk.*') ? 'bg-yellow-500/30 text-yellow-400' : 'bg-white/5 text-gray-400 group-hover:bg-yellow-500/20 group-hover:text-yellow-400' }} mr-3 transition-colors">
                    <i class="bi bi-star-fill text-lg"></i> 
                </div>
                <span class="font-medium">Ranking SPK SAW</span>
                @if(request()->routeIs('spk.*'))
                    <span class="ml-auto w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399] animate-pulse"></span>
                @endif
            </a>

            <a href="{{ route('maintenances.laporan_masuk') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('maintenances.laporan_masuk') || request()->routeIs('maintenances.proses_laporan') ? 'bg-gradient-to-r from-emerald-500/20 to-transparent border-l-4 border-emerald-400 text-white shadow-[inset_0px_1px_0px_rgba(255,255,255,0.1)]' : 'text-gray-300 hover:bg-white/10 hover:text-white hover:translate-x-1 border-l-4 border-transparent' }}">
                <div class="p-2 rounded-lg {{ request()->routeIs('maintenances.laporan_masuk') || request()->routeIs('maintenances.proses_laporan') ? 'bg-red-500/30 text-red-400' : 'bg-white/5 text-gray-400 group-hover:bg-red-500/20 group-hover:text-red-400' }} mr-3 transition-colors">
                    <i class="bi bi-inbox-fill text-lg"></i> 
                </div>
                <span class="font-medium">Laporan Masuk</span>
                <span class="ml-auto w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444] animate-pulse"></span>
            </a>
            
            <a href="{{ route('maintenances.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('maintenances.index') ? 'bg-gradient-to-r from-emerald-500/20 to-transparent border-l-4 border-emerald-400 text-white shadow-[inset_0px_1px_0px_rgba(255,255,255,0.1)]' : 'text-gray-300 hover:bg-white/10 hover:text-white hover:translate-x-1 border-l-4 border-transparent' }}">
                <div class="p-2 rounded-lg {{ request()->routeIs('maintenances.index') ? 'bg-emerald-500/30 text-emerald-300' : 'bg-white/5 text-gray-400 group-hover:bg-white/10 group-hover:text-white' }} mr-3 transition-colors">
                    <i class="bi bi-tools text-lg"></i> 
                </div>
                <span class="font-medium">Riwayat Maintenance</span>
            </a>
        </nav>
        
        <div class="p-5 border-t border-white/10 bg-black/10 relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-emerald-400">
                    <i class="bi bi-shield-check text-xl"></i>
                </div>
                <div>
                    <p class="text-white/80 text-xs font-semibold m-0">Sistem Aman</p>
                    <p class="text-white/40 text-[10px] m-0">v2.0 Beta Release</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        
        <header class="h-[80px] bg-white/90 backdrop-blur-md shadow-[0_4px_20px_-10px_rgba(0,0,0,0.08)] border-b border-gray-100 flex items-center justify-between px-4 lg:px-6 z-20 sticky top-0">
            <div class="flex items-center gap-3">
                <button id="toggleSidebar" class="p-2.5 rounded-xl text-gray-500 hover:text-[#0f4c3a] hover:bg-emerald-50 transition-all focus:outline-none focus:ring-2 focus:ring-emerald-100 group">
                    <i class="bi bi-list text-[26px] transition-transform group-hover:scale-110"></i>
                </button>

                <h2 class="lg:hidden font-bold text-lg text-transparent bg-clip-text bg-gradient-to-r from-[#0f4c3a] to-emerald-500 m-0">
                    ITAM System
                </h2>
            </div>

            <div class="absolute left-1/2 transform -translate-x-1/2 text-center hidden lg:flex flex-col items-center justify-center">
                <h2 class="font-black text-[22px] tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-[#0f4c3a] via-[#15664d] to-emerald-500 drop-shadow-sm m-0 leading-tight">
                    MANAJEMEN ASET IT
                </h2>
                <div class="flex items-center mt-0.5 space-x-2 opacity-80">
                    <div class="h-[2px] w-6 bg-gradient-to-r from-transparent to-emerald-400 rounded-full"></div>
                    <span class="text-[10px] font-bold text-[#0f4c3a] tracking-[0.2em] uppercase">PN Bale Bandung</span>
                    <div class="h-[2px] w-6 bg-gradient-to-l from-transparent to-emerald-400 rounded-full"></div>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">
                <div class="hidden md:flex items-center text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-100 shadow-sm uppercase tracking-wider">
                    <i class="bi bi-calendar3 mr-2 text-emerald-600 text-sm"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                </div>

                <div class="hidden md:block h-8 w-px bg-gray-200"></div> 
                
                @auth
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="text-right hidden sm:block mt-1">
                            <p class="text-[14px] font-bold text-gray-800 m-0 leading-none">Halo, {{ explode(' ', Auth::user()->name)[0] }} 👋</p>
                            <p class="text-[11px] text-emerald-600 m-0 font-medium mt-1">Administrator</p>
                        </div>
                        
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-tr from-[#0f4c3a] to-emerald-400 text-white flex items-center justify-center font-bold text-base sm:text-lg shadow-md ring-2 ring-emerald-100 ring-offset-2">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="m-0 sm:border-l sm:border-gray-200 sm:pl-3 sm:ml-1">
                            @csrf
                            <button type="submit" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Keluar">
                                <i class="bi bi-box-arrow-right text-[18px] sm:text-[20px]"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="w-full">
                @yield('content')
            </div>
        </main>
        
    </div>

    <script>
        const btnToggle = document.getElementById('toggleSidebar');
        const btnCloseMobile = document.getElementById('closeSidebarMobile');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleMenu() {
            if (window.innerWidth < 1024) { // Layar Mobile/Tablet
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            } else { // Layar Desktop
                // Menyembunyikan sidebar ke kiri di desktop
                sidebar.classList.toggle('lg:-ml-[280px]');
            }
        }

        btnToggle.addEventListener('click', toggleMenu);
        btnCloseMobile.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Reset class jika ukuran layar di-resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.add('-translate-x-full'); // Reset mobile state
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('lg:-ml-[280px]'); // Reset desktop state
            }
        });
    </script>

</body>
</html>