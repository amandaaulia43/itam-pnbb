@extends('layouts.public')

@section('title', 'Detail ' . $asset->asset_name)
@section('header_title', 'INFORMASI ASET')
@section('badge_text', 'Detail Info')

@section('header_button')
    <a href="{{ route('landing') }}" class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-[11px] font-bold text-gray-600 bg-gray-50 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl border border-gray-200 transition-all hover:bg-gray-100 uppercase shadow-sm whitespace-nowrap">
        <i class="bi bi-arrow-left"></i> <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
<div class="p-4 sm:p-6 lg:p-12 max-w-6xl mx-auto w-full">
    
    @if(session('success'))
        <div class="mb-6 sm:mb-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 sm:px-6 sm:py-4 rounded-2xl flex items-center gap-3 sm:gap-4 shadow-sm animate-bounce-short">
            <div class="bg-emerald-500 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center shrink-0">
                <i class="bi bi-check-lg text-sm sm:text-lg"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs sm:text-sm uppercase tracking-wide">Berhasil!</h4>
                <p class="text-[10px] sm:text-xs mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] overflow-hidden border border-gray-100 mb-8 sm:mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-4 bg-gray-50/50 p-5 sm:p-8 flex flex-col items-center border-b lg:border-b-0 lg:border-r border-gray-100 text-center">
                <div class="w-3/4 sm:w-full max-w-xs lg:max-w-full aspect-square bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-gray-200 flex items-center justify-center overflow-hidden mb-5 sm:mb-6">
                    @if($asset->photo)
                        <img src="{{ asset('storage/' . $asset->photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="bi bi-pc-display text-gray-200 text-5xl sm:text-7xl"></i>
                    @endif
                </div>
                
                <div class="w-full max-w-xs lg:max-w-full bg-white p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm mb-4">
                    <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Kondisi</p>
                    <span class="font-black text-xs sm:text-sm uppercase italic {{ $asset->status == 'active' ? 'text-emerald-600' : ($asset->status == 'maintenance' ? 'text-amber-500' : 'text-red-500') }}">
                        {{ ucfirst($asset->status == 'active' ? 'Operasional' : ($asset->status == 'maintenance' ? 'Perbaikan' : 'Rusak')) }}
                    </span>
                </div>

                <div class="w-full max-w-xs lg:max-w-full">
                    @if($asset->status == 'active')
                        <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="w-full bg-red-50 text-red-600 border border-red-200 hover:bg-red-500 hover:text-white font-bold py-2.5 sm:py-3 px-4 rounded-xl sm:rounded-2xl transition-all shadow-sm flex items-center justify-center gap-2 text-xs sm:text-sm uppercase tracking-wider">
                            <i class="bi bi-exclamation-triangle-fill"></i> Lapor Kendala
                        </button>
                    @else
                        <div class="w-full bg-amber-50 border border-amber-200 text-amber-700 font-bold py-2.5 sm:py-3 px-4 rounded-xl sm:rounded-2xl flex items-center justify-center gap-2 text-[10px] sm:text-xs uppercase tracking-wider cursor-not-allowed">
                            <i class="bi bi-tools"></i> Sedang Penanganan
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-8 p-6 sm:p-8 md:p-12 uppercase">
                <div class="mb-6 sm:mb-10 text-center lg:text-left">
                    <span class="inline-block px-2.5 py-1 sm:px-3 sm:py-1 bg-emerald-50 text-emerald-700 text-[9px] sm:text-[10px] font-black rounded-lg mb-2 sm:mb-3 tracking-widest border border-emerald-100">
                        {{ $asset->asset_code }}
                    </span>
                    <h2 class="text-lg sm:text-xl md:text-2xl font-black text-gray-800 tracking-tight leading-tight uppercase">{{ $asset->asset_name }}</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-8 mb-8 sm:mb-10">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-[#0f4c3a] text-sm sm:text-base"><i class="bi bi-bookmark-fill"></i></div>
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 tracking-widest">Kategori</p>
                            <p class="text-gray-700 font-bold leading-tight text-xs sm:text-sm">{{ $asset->category->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-[#0f4c3a] text-sm sm:text-base"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 tracking-widest">Lokasi</p>
                            <p class="text-gray-700 font-bold leading-tight text-xs sm:text-sm">{{ $asset->location }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-[#0f4c3a] text-sm sm:text-base"><i class="bi bi-cpu-fill"></i></div>
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 tracking-widest">Nomor Seri</p>
                            <p class="text-gray-700 font-bold leading-tight text-xs sm:text-sm lowercase">{{ $asset->serial_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-[#0f4c3a] text-sm sm:text-base"><i class="bi bi-calendar-date-fill"></i></div>
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-black text-gray-400 tracking-widest">Tgl Pengadaan</p>
                            <p class="text-gray-700 font-bold leading-tight text-xs sm:text-sm">{{ \Carbon\Carbon::parse($asset->purchase_date)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-5 sm:p-6 rounded-[1.5rem] sm:rounded-[2rem] border border-gray-100 relative mt-4">
                    <div class="absolute -top-3 left-4 sm:left-6 px-3 py-1 bg-white border border-gray-100 rounded-full text-[9px] sm:text-[10px] font-black text-[#0f4c3a] tracking-widest shadow-sm uppercase">
                        Spesifikasi Perangkat
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600 leading-relaxed font-medium pt-2 normal-case">
                        {!! nl2br(e($asset->item_status ?? $asset->specification ?? 'Data tidak tersedia.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] shadow-lg sm:shadow-xl border border-gray-100 overflow-hidden mx-auto max-w-6xl">
        <div class="px-5 sm:px-10 py-4 sm:py-6 border-b border-gray-50 flex items-center gap-3 bg-gray-50/30">
            <div class="w-1.5 sm:w-2 h-5 sm:h-6 bg-[#0f4c3a] rounded-full"></div>
            <h3 class="font-black text-sm sm:text-base text-gray-800 uppercase tracking-tight">Riwayat Perbaikan</h3>
        </div>
        
        <div class="p-4 sm:p-6 md:p-8 flex flex-col gap-4">
            @forelse($asset->maintenances as $maint)
                <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:gap-6 hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gray-200 group-hover:bg-[#0f4c3a] transition-colors"></div>
                    
                    <div class="flex items-center gap-3 sm:w-40 shrink-0">
                        <div class="bg-white p-2.5 rounded-xl text-[#0f4c3a] shadow-sm border border-gray-100">
                            <i class="bi bi-calendar-check text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Tanggal</p>
                            <p class="font-bold text-gray-800 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($maint->maintenance_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="flex-grow flex flex-col justify-center border-t sm:border-t-0 sm:border-l border-gray-200 pt-3 sm:pt-0 sm:pl-6">
                        <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Keterangan Perbaikan</p>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">{{ $maint->description }}</p>
                    </div>

                    <div class="flex flex-col justify-center items-start sm:items-end sm:w-28 shrink-0 border-t sm:border-t-0 border-gray-200 pt-3 sm:pt-0">
                        <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 sm:text-right w-full">Biaya</p>
                        <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-black text-[#0f4c3a] shadow-sm">-</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 px-4 bg-gray-50/50 border border-gray-200 rounded-2xl border-dashed">
                    <div class="bg-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-gray-100">
                        <i class="bi bi-clipboard-x text-xl text-gray-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Belum ada riwayat perbaikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div id="reportModal" class="fixed inset-0 bg-black/60 hidden z-[60] flex items-center justify-center backdrop-blur-sm transition-all p-4">
    <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 max-w-md w-full shadow-2xl transform transition-all relative overflow-hidden max-h-[90vh] overflow-y-auto">
        
        <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-red-50 rounded-bl-[4rem] sm:rounded-bl-[5rem] -z-10 opacity-50"></div>
        <div class="absolute top-3 right-5 sm:top-4 sm:right-6 text-red-100 opacity-30"><i class="bi bi-exclamation-triangle-fill text-5xl sm:text-6xl"></i></div>

        <div class="flex justify-between items-center mb-5 sm:mb-6 relative z-10">
            <div>
                <h3 class="text-lg sm:text-xl font-black text-gray-800 tracking-tight">Lapor Kendala</h3>
                <p class="text-[10px] sm:text-xs text-gray-400 font-medium mt-0.5 sm:mt-1">Sistem Layanan IT PTIP</p>
            </div>
            <button onclick="document.getElementById('reportModal').classList.add('hidden')" class="w-7 h-7 sm:w-8 sm:h-8 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all outline-none">
                <i class="bi bi-x-lg text-xs sm:text-sm"></i>
            </button>
        </div>

        <form action="{{ route('assets.report_issue', $asset->id) }}" method="POST" class="relative z-10">
            @csrf
            
            <div class="mb-4">
                <label class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 sm:mb-2">Nama Pelapor</label>
                <input type="text" name="reporter_name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm focus:ring-2 focus:ring-[#0f4c3a] focus:border-transparent outline-none transition-all placeholder-gray-300" placeholder="Cth: Budi">
            </div>

            <div class="mb-4">
                <label class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 sm:mb-2">Ruangan / Lokasi</label>
                <select name="location" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm focus:ring-2 focus:ring-[#0f4c3a] focus:border-transparent outline-none transition-all text-gray-700">
                    <option value="" disabled selected>-- Pilih Ruangan --</option>
                    <option value="Ruang Rapat PTIP">Ruang Rapat PTIP</option>
                    <option value="Ruang Server">Ruang Server</option>
                    <option value="Ruang Staff Admin">Ruang Staff Admin</option>
                    <option value="Lobby">Lobby</option>
                </select>
            </div>
            
            <div class="mb-6 sm:mb-8">
                <label class="block text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 sm:mb-2">Jelaskan Kerusakan</label>
                <textarea name="description" required rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm focus:ring-2 focus:ring-[#0f4c3a] focus:border-transparent outline-none transition-all placeholder-gray-300 resize-none" placeholder="Cth: Layar blank hitam atau kursor tidak bergerak..."></textarea>
            </div>
            
            <button type="submit" class="w-full bg-[#0f4c3a] hover:bg-[#0a3629] text-white font-bold py-3 sm:py-4 rounded-xl transition-all shadow-lg hover:shadow-xl uppercase tracking-wider text-xs sm:text-sm flex items-center justify-center gap-2 shadow-emerald-900/10">
                <i class="bi bi-send-fill"></i> Kirim Laporan
            </button>
        </form>
    </div>
</div>
@endsection