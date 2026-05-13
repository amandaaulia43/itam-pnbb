@extends('layouts.app')

@section('content')
<div class="pb-24 lg:pb-10">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Laporan Masuk (Pending)</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Daftar laporan kerusakan aset yang menunggu untuk diproses.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 mb-6 rounded-xl shadow-sm flex items-center">
            <i class="bi bi-check-circle-fill mr-3 text-xl text-emerald-500"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white">
            <h2 class="text-base font-bold text-gray-800 flex items-center">
                <i class="bi bi-inbox-fill mr-3 text-red-500 text-lg"></i> Daftar Laporan Pending
            </h2>
            
            <form action="{{ route('maintenances.laporan_masuk') }}" method="GET" class="flex w-full lg:w-auto">
                <div class="relative w-full lg:w-72">
                    <input type="text" name="search" class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0f4c3a] focus:border-[#0f4c3a] transition-all bg-gray-50/50 focus:bg-white placeholder-gray-400" placeholder="Cari aset / keluhan..." value="{{ request('search') }}">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#0f4c3a] transition-colors">
                        <i class="bi bi-search text-lg"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('maintenances.laporan_masuk') }}" class="ml-2 bg-red-50 hover:bg-red-100 text-red-500 px-3 py-2.5 rounded-xl transition-colors flex items-center justify-center border border-red-100" title="Reset Pencarian">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div>
            @if(count($laporanMasuk) > 0)
            
            <div class="block md:hidden p-4 bg-gray-50/50 space-y-4">
                @foreach ($laporanMasuk as $index => $item)
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative">
                    <div class="flex justify-between items-center mb-3">
                        <div class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md text-[10px] font-bold flex items-center">
                            <i class="bi bi-clock mr-1.5"></i>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y - H:i') }} WIB
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-red-50 text-red-600 border border-red-100 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 animate-pulse"></span> Baru
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="font-mono text-[10px] font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2 py-1 rounded-md border border-[#0f4c3a]/10 inline-block mb-1.5">
                            {{ $item->asset->asset_code }}
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm leading-tight">{{ $item->asset->asset_name }}</h4>
                    </div>

                    <div class="bg-red-50/50 p-3 rounded-lg border border-red-100 mb-4">
                        <span class="block text-[10px] font-bold text-red-500 uppercase tracking-wider mb-1">Keluhan / Laporan:</span>
                        <p class="text-xs text-gray-700 leading-relaxed italic line-clamp-3">"{{ $item->description }}"</p>
                    </div>

                    <a href="{{ route('maintenances.proses_laporan', $item->id) }}" class="block w-full text-center bg-[#0f4c3a] text-white py-2.5 rounded-lg text-xs font-bold hover:bg-[#0a3629] transition-colors shadow-sm">
                        <i class="bi bi-tools mr-1.5"></i> Proses Sekarang
                    </a>
                </div>
                @endforeach
            </div>

            <div class="hidden md:block overflow-x-auto w-full">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100 tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold w-16">No</th>
                            <th scope="col" class="px-6 py-4 font-bold">Waktu Lapor</th>
                            <th scope="col" class="px-6 py-4 font-bold">Aset / Perangkat</th>
                            <th scope="col" class="px-6 py-4 font-bold w-1/3">Detail Laporan</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach ($laporanMasuk as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-500">
                                {{ $laporanMasuk->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-800 font-bold">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500 font-medium mt-0.5 flex items-center">
                                    <i class="bi bi-clock mr-1"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-mono text-[11px] font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2.5 py-1 rounded-md w-fit border border-[#0f4c3a]/10 mb-1.5">
                                    {{ $item->asset->asset_code }}
                                </div>
                                <div class="font-bold text-gray-800 text-sm">{{ Str::limit($item->asset->asset_name, 40) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-700 bg-red-50/50 p-2.5 rounded-lg border border-red-100 whitespace-pre-wrap leading-relaxed max-w-sm">{{ Str::limit($item->description, 100) }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-red-50 text-red-600 border border-red-100 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 animate-pulse"></span> Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('maintenances.proses_laporan', $item->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-[#0f4c3a] rounded-lg hover:bg-[#0a3629] transition-all shadow-sm">
                                    <i class="bi bi-tools mr-1.5"></i> Proses
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="px-6 py-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 mb-4 shadow-sm">
                    <i class="bi bi-inbox text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">Tidak ada laporan masuk</h3>
                <p class="text-sm text-gray-500 font-medium">Semua laporan perangkat sudah tertangani dengan baik atau belum ada laporan baru.</p>
            </div>
            @endif
        </div>
        
        @if($laporanMasuk->hasPages())
        <div class="p-5 border-t border-gray-100 bg-gray-50/50">
            {{ $laporanMasuk->links() }}
        </div>
        @endif
    </div>
</div>
@endsection