<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ITAM PN Bale Bandung</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f1f5f9; }
    </style>
</head>
<body class="text-gray-800 flex flex-col min-h-screen">

    <header class="h-auto min-h-[70px] md:h-[80px] py-2 md:py-0 bg-white/90 backdrop-blur-md shadow-[0_4px_20px_-10px_rgba(0,0,0,0.08)] border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 z-50 sticky top-0">
        <div class="flex items-center gap-2 sm:gap-3 z-10">
            <div class="bg-[#0f4c3a] p-1.5 rounded-lg shadow-md border border-white/20 shrink-0">
                <img src="{{ asset('images/logo-pnbb.png') }}" alt="Logo PN Bale Bandung" class="h-16 w-auto object-contain">
            </div>
            <div class="hidden sm:block">
                <h1 class="text-[#0f4c3a] font-bold text-[14px] sm:text-[16px] leading-tight uppercase tracking-tight">ITAM System</h1>
                <p class="text-emerald-600 text-[8px] sm:text-[9px] font-black tracking-[0.2em] uppercase m-0">PN Bale Bandung</p>
            </div>
        </div>

        <div class="absolute left-1/2 transform -translate-x-1/2 text-center flex flex-col items-center justify-center w-max max-w-[50%] sm:max-w-max">
            <h2 class="font-black text-[14px] sm:text-[18px] md:text-[22px] tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-[#0f4c3a] via-[#15664d] to-emerald-500 drop-shadow-sm m-0 leading-tight truncate w-full">
                @yield('header_title', 'MONITORING ASET')
            </h2>
            <div class="hidden sm:flex items-center mt-0.5 space-x-2 opacity-80">
                <div class="h-[2px] w-4 sm:w-6 bg-gradient-to-r from-transparent to-emerald-400 rounded-full"></div>
                <span class="text-[8px] sm:text-[9px] font-bold text-[#0f4c3a] tracking-[0.2em] uppercase">@yield('header_subtitle', 'Public Access')</span>
                <div class="h-[2px] w-4 sm:w-6 bg-gradient-to-l from-transparent to-emerald-400 rounded-full"></div>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-4 z-10 shrink-0">
            @yield('header_button')
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="py-8 sm:py-10 text-center px-4">
        <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] sm:tracking-[0.5em] leading-relaxed">
            IT Asset Management &copy; {{ date('Y') }}<br class="block sm:hidden"> PN BALE BANDUNG
        </p>
    </footer>

</body>
</html>