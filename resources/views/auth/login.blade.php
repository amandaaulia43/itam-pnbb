<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ITAM PN Bale Bandung</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animasi masuk (Fade in up) biar terasa hidup saat baru buka halaman */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Pattern titik-titik halus untuk panel hijau */
        .dot-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f4f6f9] flex items-center justify-center p-4 sm:p-8 relative overflow-hidden selection:bg-[#0f4c3a] selection:text-white">

    <div class="absolute top-[-15%] left-[-10%] w-[500px] h-[500px] bg-emerald-400/10 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute bottom-[-15%] right-[-10%] w-[500px] h-[500px] bg-[#0f4c3a]/10 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="w-full max-w-4xl bg-white rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(15,76,58,0.15)] flex flex-col md:flex-row overflow-hidden relative z-10 animate-fade-in border border-gray-100">
        
        <div class="md:w-5/12 bg-gradient-to-br from-[#0f4c3a] to-[#0a3629] p-10 lg:p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 dot-pattern opacity-50"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl"></div>

            <div class="justify-center relative z-10">
                <div class="flex justify-center items-center w-full">
                    <div class="flex justify-center items-centerbg-white/10 backdrop-blur-sm w-fit p-3 rounded-xl border border-white/20 mb-8 shadow-sm">
                        <img src="{{ asset('images/logo-pnbb.png') }}" alt="Logo PN Bale Bandung" class="h-16 w-auto object-contain">
                    </div>
                </div>
                
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">APLIKASI ITAM</h1>
                <div class="w-12 h-1 bg-emerald-400 rounded-full mb-6"></div>
                
                <p class="text-emerald-50/90 text-sm lg:text-base leading-relaxed font-light">
                    Sistem Manajemen Aset IT terintegrasi untuk <span class="font-medium text-white">Pengadilan Negeri Bale Bandung</span>. Kelola inventaris dengan lebih cerdas dan efisien.
                </p>
            </div>

            <div class="relative z-10 hidden md:block mt-12 space-y-4">
                <div class="flex items-center gap-3 text-emerald-100/80 text-sm">
                    <i class="bi bi-shield-check text-emerald-400 text-lg"></i>
                    <span>Sistem Aman & Terenkripsi</span>
                </div>
                <div class="flex items-center gap-3 text-emerald-100/80 text-sm">
                    <i class="bi bi-pc-display text-emerald-400 text-lg"></i>
                    <span>Pemantauan Aset Real-time</span>
                </div>
            </div>
        </div>

        <div class="md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white relative">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Login ke Akun Anda</h2>
                <p class="text-gray-500 text-sm font-medium">Masukkan email dan kata sandi yang terdaftar.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg text-sm mb-6 flex items-start gap-3 shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
                    <span class="font-medium">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700">Email Pengguna</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400 group-focus-within:text-[#0f4c3a] transition-colors"></i>
                        </div>
                        <input type="email" name="email" required placeholder="admin@pnbb.go.id" value="{{ old('email') }}"
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] focus:bg-white transition-all outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        <a href="#" class="text-xs font-semibold text-[#0f4c3a] hover:text-emerald-600 transition-colors">Lupa Sandi?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-lock text-gray-400 group-focus-within:text-[#0f4c3a] transition-colors"></i>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] focus:bg-white transition-all outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>
                </div>

                <div class="flex items-center pt-1">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-[#0f4c3a] bg-gray-100 border-gray-300 rounded focus:ring-[#0f4c3a] focus:ring-2 cursor-pointer transition-all">
                    <label for="remember" class="ml-2.5 text-sm font-medium text-gray-600 cursor-pointer select-none">Ingat sesi saya di perangkat ini</label>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 mt-4 rounded-xl text-sm font-bold text-white bg-[#0f4c3a] hover:bg-[#0a3629] focus:outline-none focus:ring-4 focus:ring-[#0f4c3a]/30 transition-all shadow-[0_4px_12px_rgba(15,76,58,0.2)] hover:shadow-[0_6px_16px_rgba(15,76,58,0.3)] hover:-translate-y-[1px]">
                    Masuk ke Dasbor
                    <i class="bi bi-arrow-right-short text-xl leading-none"></i>
                </button>
            </form>
            
        </div>
    </div>

    <div class="absolute bottom-6 w-full text-center text-xs font-medium text-gray-400 z-0">
        &copy; 2026 Pengadilan Negeri Bale Bandung
    </div>

</body>
</html>