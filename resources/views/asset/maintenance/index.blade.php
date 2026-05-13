@extends('layouts.app')

@section('content')
<div class="pb-24 lg:pb-10">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight mb-2">Data Riwayat Maintenance</h2>
        <p class="text-base text-gray-500 font-medium">Daftar rekapitulasi seluruh perbaikan perangkat IT Pengadilan Negeri Bale Bandung</p>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-5 py-4 mb-8 rounded-xl shadow-sm flex items-center">
        <i class="bi bi-check-circle-fill mr-3 text-xl text-emerald-500"></i>
        <p class="font-bold text-base">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <div class="bg-white px-5 sm:px-6 py-5 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <h3 class="text-lg font-bold text-gray-800 m-0 flex items-center whitespace-nowrap">
                <i class="bi bi-tools mr-3 text-[#0f4c3a] text-xl"></i> Seluruh Riwayat
            </h3>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <form action="{{ route('maintenances.index') }}" method="GET" class="w-full sm:w-auto flex">
                    <div class="relative w-full sm:w-72">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari aset, teknisi, keluhan..." class="w-full pl-4 pr-10 py-2.5 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white placeholder-gray-400">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#0f4c3a] transition-colors">
                            <i class="bi bi-search text-lg"></i>
                        </button>
                    </div>
                    @if($search)
                        <a href="{{ route('maintenances.index') }}" class="ml-2 bg-red-50 hover:bg-red-100 text-red-500 px-3 py-2.5 rounded-xl transition-colors flex items-center justify-center border border-red-100" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </form>
                
                <button onclick="openModal('modal-pdf-preview')" class="w-full sm:w-auto bg-white border border-red-200 hover:bg-red-50 text-red-600 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center justify-center whitespace-nowrap">
                    <i class="bi bi-file-earmark-pdf mr-2 text-lg"></i> Export PDF
                </button>
            </div>
        </div>

        <div>
            @if(count($maintenances) > 0)
            
            <div class="block md:hidden p-4 bg-gray-50/50 space-y-4">
                @foreach($maintenances as $history)
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md">
                            {{ \Carbon\Carbon::parse($history->maintenance_date)->translatedFormat('d M Y') }}
                        </span>
                        @if($history->repair_cost > 0)
                            <span class="font-bold text-gray-800 text-sm">Rp {{ number_format($history->repair_cost, 0, ',', '.') }}</span>
                        @else
                            <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-[11px] font-bold border border-emerald-100">Gratis</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <span class="font-mono text-[10px] font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2 py-1 rounded-md border border-[#0f4c3a]/10">{{ $history->asset->asset_code }}</span>
                        <h4 class="font-bold text-gray-800 text-sm mt-2 leading-tight">{{ $history->asset->asset_name }}</h4>
                    </div>

                    <div class="mb-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                            <i class="bi bi-person-fill mr-1.5"></i> {{ $history->technician_name }}
                        </span>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-4 space-y-3">
                        <div>
                            <span class="block text-[10px] font-bold text-red-500 uppercase tracking-wider mb-1">Masalah:</span>
                            <p class="text-xs text-gray-700 leading-relaxed">{{ Str::limit($history->description, 50) }}</p>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            <span class="block text-[10px] font-bold text-[#0f4c3a] uppercase tracking-wider mb-1">Tindakan:</span>
                            <p class="text-xs text-gray-800 font-medium leading-relaxed">{{ Str::limit($history->action_taken, 50) }}</p>
                        </div>
                        
                        @if(strlen($history->description) > 50 || strlen($history->action_taken) > 50)
                            <button onclick="openModal('modal-detail-{{ $history->id }}')" class="w-full text-center text-xs font-bold text-blue-600 hover:text-blue-800 pt-2 border-t border-gray-200 mt-2 transition-colors">
                                Baca Selengkapnya <i class="bi bi-chevron-right ml-1"></i>
                            </button>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('maintenances.edit', $history->id) }}" class="flex-1 text-center bg-white border border-gray-200 text-blue-600 py-2 rounded-lg text-xs font-bold hover:bg-blue-50 transition-colors shadow-sm">
                            <i class="bi bi-pencil-square mr-1"></i> Edit
                        </a>
                        <form action="{{ route('maintenances.destroy', $history->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat perbaikan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center bg-red-50 border border-red-100 text-red-600 py-2 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors shadow-sm">
                                <i class="bi bi-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="hidden md:block overflow-x-auto w-full p-0">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold">Tanggal</th>
                            <th class="py-4 px-6 font-bold">Perangkat IT</th>
                            <th class="py-4 px-6 font-bold">Teknisi/Vendor</th>
                            <th class="py-4 px-6 font-bold w-1/3">Keluhan & Tindakan</th>
                            <th class="py-4 px-6 font-bold whitespace-nowrap">Biaya</th>
                            <th class="py-4 px-6 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($maintenances as $history)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-5 px-6 whitespace-nowrap font-bold text-gray-700">
                                {{ \Carbon\Carbon::parse($history->maintenance_date)->translatedFormat('d M Y') }}
                            </td>
                            
                            <td class="py-5 px-6">
                                <a href="{{ route('assets.show', $history->asset->id) }}" class="block hover:opacity-80 transition-opacity">
                                    <div class="font-mono text-xs font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2.5 py-1 rounded-md w-fit border border-[#0f4c3a]/10 mb-1.5">
                                        {{ $history->asset->asset_code }}
                                    </div>
                                    <div class="text-sm font-bold text-gray-800">{{ Str::limit($history->asset->asset_name, 35) }}</div>
                                </a>
                            </td>
                            
                            <td class="py-5 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                    <i class="bi bi-person-fill mr-1.5"></i> {{ $history->technician_name }}
                                </span>
                            </td>
                            
                            <td class="py-5 px-6">
                                <div class="mb-2">
                                    <span class="font-bold text-red-500 text-[10px] uppercase tracking-wider bg-red-50 px-2 py-0.5 rounded border border-red-100">Masalah</span>
                                    <p class="text-gray-700 mt-1 text-xs leading-relaxed">{{ Str::limit($history->description, 60) }}</p>
                                </div>
                                <div class="pl-2 border-l-2 border-[#0f4c3a]/30 mb-2">
                                    <span class="font-bold text-[#0f4c3a] text-[10px] uppercase tracking-wider bg-[#0f4c3a]/5 px-2 py-0.5 rounded border border-[#0f4c3a]/10">Tindakan</span>
                                    <p class="text-gray-800 mt-1 text-xs font-medium leading-relaxed">{{ Str::limit($history->action_taken, 60) }}</p>
                                </div>
                                
                                @if(strlen($history->description) > 60 || strlen($history->action_taken) > 60)
                                    <button onclick="openModal('modal-detail-{{ $history->id }}')" class="text-[11px] font-bold text-blue-600 hover:text-blue-800 hover:underline flex items-center transition-colors mt-2">
                                        <i class="bi bi-arrows-angle-expand mr-1.5"></i> Baca Selengkapnya
                                    </button>
                                @endif
                            </td>
                            
                            <td class="py-5 px-6 whitespace-nowrap">
                                @if($history->repair_cost > 0)
                                    <span class="font-bold text-gray-800">Rp {{ number_format($history->repair_cost, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-[11px] font-bold border border-emerald-100">Gratis</span>
                                @endif
                            </td>
                            
                            <td class="py-5 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('maintenances.edit', $history->id) }}" class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all shadow-sm" title="Edit Data">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('maintenances.destroy', $history->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat perbaikan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-red-600 hover:bg-red-50 hover:border-red-200 transition-all shadow-sm" title="Hapus Data">
                                            <i class="bi bi-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="py-20 text-center px-4">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center mb-4 shadow-sm">
                        <i class="bi bi-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">
                        @if($search)
                            Pencarian "<b class="text-gray-700">{{ $search }}</b>" tidak ditemukan.
                        @else
                            Belum ada data riwayat maintenance.
                        @endif
                    </p>
                </div>
            </div>
            @endif
        </div>
        
        @if($maintenances->hasPages())
        <div class="bg-gray-50/50 px-5 sm:px-6 py-4 border-t border-gray-100">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>
</div>

@foreach($maintenances as $history)
    @if(strlen($history->description) > 50 || strlen($history->action_taken) > 50)
    <div id="modal-detail-{{ $history->id }}" class="fixed inset-0 z-[999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 modal-backdrop" onclick="closeModal('modal-detail-{{ $history->id }}')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 w-full sm:max-w-xl modal-panel border border-gray-100">
                    
                    <div class="bg-gray-50/80 px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-base sm:text-lg font-bold text-gray-800 flex items-center m-0" id="modal-title">
                            <i class="bi bi-file-text mr-3 text-[#0f4c3a]"></i> Detail Perbaikan
                        </h3>
                        <button type="button" onclick="closeModal('modal-detail-{{ $history->id }}')" class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg w-8 h-8 flex items-center justify-center transition-all">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="bg-white px-5 py-5 sm:px-6 sm:py-6">
                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-2 flex items-center">
                                <i class="bi bi-exclamation-triangle mr-2"></i> Masalah / Keluhan
                            </h4>
                            <div class="bg-red-50/50 p-4 sm:p-5 rounded-xl border border-red-100 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $history->description }}</div>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-[#0f4c3a] uppercase tracking-wider mb-2 flex items-center">
                                <i class="bi bi-wrench-adjustable mr-2"></i> Tindakan yang Dilakukan
                            </h4>
                            <div class="bg-[#0f4c3a]/5 p-4 sm:p-5 rounded-xl border border-[#0f4c3a]/10 text-sm text-gray-800 font-medium leading-relaxed whitespace-pre-wrap">{{ $history->action_taken }}</div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-5 py-4 sm:px-6 border-t border-gray-100 flex justify-end">
                        <button type="button" onclick="closeModal('modal-detail-{{ $history->id }}')" class="w-full sm:w-auto bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<div id="modal-pdf-preview" class="fixed inset-0 z-[999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 modal-backdrop" onclick="closeModal('modal-pdf-preview')"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 w-full sm:max-w-5xl h-[85vh] flex flex-col modal-panel border border-gray-100">
                
                <div class="bg-white px-5 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center shrink-0">
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 flex items-center m-0">
                        <i class="bi bi-file-earmark-pdf mr-3 text-red-500"></i> Preview PDF Data Maintenance
                    </h3>
                    <button type="button" onclick="closeModal('modal-pdf-preview')" class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg w-8 h-8 flex items-center justify-center transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="bg-gray-100 flex-1 w-full p-0 overflow-hidden relative">
                    <iframe src="{{ route('maintenances.export-pdf', ['search' => request('search')]) }}" class="w-full h-full border-0" title="PDF Preview"></iframe>
                </div>
                
                <div class="bg-gray-50 px-5 py-4 sm:px-6 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                    <button type="button" onclick="closeModal('modal-pdf-preview')" class="w-full sm:w-auto bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all">
                        Tutup
                    </button>
                    <a href="{{ route('maintenances.export-pdf', ['search' => request('search')]) }}" download="Data_Maintenance.pdf" target="_blank" class="w-full sm:w-auto bg-red-600 border border-transparent text-white hover:bg-red-700 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center justify-center">
                        <i class="bi bi-download mr-2"></i> Download File
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if(!modal) return;
        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Timeout untuk trigger animasi Tailwind
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if(!modal) return;
        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');
        
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        
        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
</script>
@endsection