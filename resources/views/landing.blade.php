@extends('layouts.public')

@section('title', 'Informasi Publik')
@section('header_title', 'IT ASSET MANAGEMENT')
@section('badge_text', 'Public Access')

@section('header_button')
    @auth
        <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl border border-emerald-100 transition-all hover:bg-emerald-100 uppercase shadow-sm" title="Dashboard">
            <i class="bi bi-speedometer2 text-sm sm:text-xs"></i> 
            <span class="hidden sm:inline">Dashboard</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-[11px] font-bold text-gray-600 bg-gray-50 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl border border-gray-200 transition-all hover:bg-gray-100 uppercase shadow-sm" title="Login Admin">
            <i class="bi bi-box-arrow-in-right text-sm sm:text-xs"></i> 
            <span class="hidden sm:inline">Login Admin</span>
        </a>
    @endauth
@endsection

@section('content')
<main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
    
    <div class="mb-6 sm:mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight">Daftar Inventaris</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">Transparansi status dan kondisi perangkat IT di lingkungan kantor.</p>
        </div>
        <div class="inline-flex self-start md:self-auto items-center gap-2 text-[10px] sm:text-[11px] font-bold text-emerald-800 bg-emerald-100/50 px-4 py-2 sm:px-5 sm:py-2.5 rounded-full border border-emerald-100 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Terhubung: {{ $totalAssets }} Perangkat
        </div>
    </div>

    <div class="bg-transparent md:bg-white md:rounded-[2rem] md:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] md:border border-gray-100 overflow-hidden">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-0 bg-transparent md:bg-white border-b border-transparent md:border-gray-100 px-0 md:px-5 pt-0 md:pt-5 pb-0 md:pb-4">
            
            <div class="flex gap-2 sm:gap-3 overflow-x-auto hide-scrollbar pb-2 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0">
                <a href="{{ route('landing', ['tab' => 'operasional', 'search' => request('search')]) }}" 
                   class="flex shrink-0 items-center gap-2 px-5 py-3 rounded-xl md:rounded-lg text-[11px] sm:text-xs font-bold transition-all whitespace-nowrap shadow-sm md:shadow-none border {{ $tab == 'operasional' ? 'bg-[#0f4c3a] text-white border-[#0f4c3a]' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <i class="bi bi-check-circle-fill {{ $tab == 'operasional' ? 'text-emerald-400' : 'text-gray-400' }}"></i> 
                    Operasional
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $tab == 'operasional' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $countOperasional }}</span>
                </a>
                
                <a href="{{ route('landing', ['tab' => 'perbaikan', 'search' => request('search')]) }}" 
                   class="flex shrink-0 items-center gap-2 px-5 py-3 rounded-xl md:rounded-lg text-[11px] sm:text-xs font-bold transition-all whitespace-nowrap shadow-sm md:shadow-none border {{ $tab == 'perbaikan' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                    <i class="bi bi-tools {{ $tab == 'perbaikan' ? 'text-amber-100' : 'text-gray-400' }}"></i> 
                    Perbaikan
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $tab == 'perbaikan' ? 'bg-black/10 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $countPerbaikan }}</span>
                </a>
            </div>

            <div class="w-full lg:max-w-xs">
                <form action="{{ route('landing') }}" method="GET" class="relative group w-full shadow-sm md:shadow-none rounded-xl">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#0f4c3a] transition-colors">
                        <i class="bi bi-search"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Ruangan..." 
                           class="w-full pl-11 pr-4 py-3 bg-white md:bg-gray-50 border border-gray-200 md:border-transparent rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all focus:bg-white placeholder-gray-400">
                </form>
            </div>
        </div>

        <div class="w-full">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="hidden md:table-header-group bg-gray-50/50 text-gray-400 font-black uppercase tracking-widest text-[10px] border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5">Perangkat IT</th>
                        <th class="px-6 py-5">Lokasi</th>
                        <th class="px-6 py-5">Status Kondisi</th>
                        <th class="px-6 py-5 text-center w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="flex flex-col md:table-row-group gap-4 md:gap-0 divide-none md:divide-y md:divide-gray-50 mt-2 md:mt-0">
                    @forelse($assets as $asset)
                        <tr class="flex flex-col md:table-row bg-white border border-gray-200 md:border-none rounded-[1.5rem] md:rounded-none shadow-sm md:shadow-none hover:bg-gray-50/80 transition-all group overflow-hidden">
                            
                            <td class="block md:table-cell px-5 py-5 md:px-6 md:py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 sm:w-12 sm:h-12 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden shadow-sm shrink-0">
                                        @if($asset->photo)
                                            <img src="{{ asset('storage/' . $asset->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="bi bi-pc-display text-gray-300 text-2xl sm:text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="font-black text-gray-800 text-sm sm:text-base leading-tight mb-1 truncate uppercase">{{ $asset->asset_name }}</p>
                                        <p class="text-[10px] sm:text-[11px] font-bold text-[#0f4c3a] tracking-widest uppercase truncate">{{ $asset->asset_code }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="block md:table-cell px-5 py-3 md:px-6 md:py-4 border-t border-dashed border-gray-100 md:border-none bg-gray-50/30 md:bg-transparent">
                                <div class="flex items-center justify-between md:justify-start">
                                    <span class="text-[9px] font-black text-gray-400 uppercase md:hidden tracking-widest">Lokasi</span>
                                    <span class="text-gray-600 font-bold text-xs">
                                        <i class="bi bi-geo-alt-fill text-[#0f4c3a] mr-1"></i> {{ $asset->location }}
                                    </span>
                                </div>
                            </td>

                            <td class="block md:table-cell px-5 py-3 md:px-6 md:py-4 border-t border-dashed border-gray-100 md:border-none">
                                <div class="flex flex-col md:block gap-3 md:gap-0">
                                    <div class="flex items-center justify-between md:justify-start">
                                        <span class="text-[9px] font-black text-gray-400 uppercase md:hidden tracking-widest">Status</span>
                                        @if($asset->status == 'active')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[9px] sm:text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                                <i class="bi bi-check-circle-fill"></i> Operasional
                                            </div>
                                        @elseif($asset->status == 'maintenance')
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[9px] sm:text-[10px] font-black bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wider">
                                                <i class="bi bi-tools"></i> Perbaikan
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[9px] sm:text-[10px] font-black bg-red-50 text-red-700 border border-red-100 uppercase tracking-wider">
                                                <i class="bi bi-x-circle-fill"></i> Rusak
                                            </div>
                                        @endif
                                    </div>

                                    @if($asset->status != 'active')
                                        @php
                                            $latestMaintenance = $asset->maintenances->sortByDesc('created_at')->first();
                                        @endphp
                                        
                                        @if($latestMaintenance)
                                            @php
                                                $lamaHari = (int) round(\Carbon\Carbon::parse($latestMaintenance->created_at)->diffInDays(now()));
                                                $teksWaktu = $lamaHari <= 0 ? 'Hari ini' : $lamaHari . ' Hari';
                                            @endphp
                                            
                                            <div class="mt-0 md:mt-2.5 flex flex-col gap-1.5 p-3 md:p-0 bg-gray-50 md:bg-transparent rounded-xl md:rounded-none border border-gray-100 md:border-none">
                                                <div class="flex items-center justify-between md:justify-start gap-1.5 text-[10px] text-gray-500">
                                                    <span class="font-medium"><i class="bi bi-person-fill text-gray-400 mr-1"></i> Teknisi:</span> 
                                                    <span class="text-gray-700 font-bold uppercase">{{ $latestMaintenance->technician_name ?? 'Belum Ditentukan' }}</span>
                                                </div>
                                                <div class="flex items-center justify-between md:justify-start gap-1.5 text-[10px] text-gray-500">
                                                    <span class="font-medium"><i class="bi bi-clock-fill text-amber-500 mr-1"></i> Durasi:</span> 
                                                    <span class="text-amber-600 font-bold uppercase">{{ $teksWaktu }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            <td class="block md:table-cell px-5 py-4 md:px-6 md:py-4 border-t border-gray-100 md:border-none bg-gray-50/50 md:bg-transparent text-center">
                                <a href="{{ route('assets.public_show', $asset->id) }}" class="flex md:inline-flex justify-center items-center gap-2 text-[10px] sm:text-[11px] font-black text-[#0f4c3a] bg-emerald-50 hover:bg-[#0f4c3a] hover:text-white px-5 py-3 md:py-2.5 rounded-xl transition-all border border-emerald-100 hover:border-transparent uppercase tracking-widest w-full md:w-auto">
                                    Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="block md:table-cell px-6 py-16 md:py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                        <i class="bi bi-inbox text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">Belum Ada Data</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Tidak ada perangkat yang ditemukan di kategori ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
/* Utility untuk menyembunyikan scrollbar tapi tetap bisa di-scroll horizontal */
.hide-scrollbar {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
.hide-scrollbar::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}
</style>
@endsection