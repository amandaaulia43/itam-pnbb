@extends('layouts.app')

@section('content')
<div class="pb-24 lg:pb-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Hasil Rekomendasi Penggantian Aset</h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Sistem Pendukung Keputusan menggunakan metode Simple Additive Weighting (SAW)</p>
        </div>
        
        <div class="print-hidden w-full md:w-auto">
            <button onclick="openPdfModal()" class="w-full md:w-auto bg-[#0f4c3a] hover:bg-[#0a3629] text-white px-5 py-2.5 rounded-xl shadow-sm text-sm font-bold transition-all hover:shadow-md flex items-center justify-center">
                <i class="bi bi-file-earmark-pdf mr-2 text-lg"></i> Preview Laporan PDF
            </button>
        </div>
    </div>

    @if(count($rankings) > 0)
    @php
        $koleksiRanking = collect($rankings);
        $sangatMendesak = $koleksiRanking->filter(function($r) { return $r->score >= 0.8; })->count();
        $perluDiganti = $koleksiRanking->filter(function($r) { return $r->score >= 0.6 && $r->score < 0.8; })->count();
        $masihLayak = $koleksiRanking->filter(function($r) { return $r->score < 0.6; })->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Sangat Mendesak</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $sangatMendesak }} <span class="text-sm font-medium text-gray-400 ml-1">Aset</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 border border-red-100/50">
                <i class="bi bi-exclamation-triangle-fill text-xl"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Perlu Diganti</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $perluDiganti }} <span class="text-sm font-medium text-gray-400 ml-1">Aset</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100/50">
                <i class="bi bi-exclamation-circle-fill text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Masih Layak</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $masihLayak }} <span class="text-sm font-medium text-gray-400 ml-1">Aset</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100/50">
                <i class="bi bi-check-circle-fill text-xl"></i>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden print-container">
        <div class="bg-white px-5 md:px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h3 class="text-base font-bold text-gray-800 m-0 flex items-center">
                <i class="bi bi-trophy-fill mr-3 text-amber-400 text-lg"></i> Peringkat Prioritas Penggantian
            </h3>
            <span class="bg-[#0f4c3a]/5 text-[#0f4c3a] border border-[#0f4c3a]/10 text-[10px] px-3 py-1 rounded-md font-bold uppercase tracking-wider self-start sm:self-auto">Berdasarkan Nilai Tertinggi</span>
        </div>

        <div>
            @if(count($rankings) > 0)
            
            <div class="block md:hidden p-4 bg-gray-50/50">
                <div class="space-y-4">
                    @foreach($rankings as $index => $rank)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative">
                        <div class="absolute top-0 right-0 bg-gray-50 px-3 py-1.5 rounded-bl-xl rounded-tr-xl border-b border-l border-gray-200 flex items-center justify-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mr-1.5">Rank</span>
                            @if($index == 0)
                                <span class="text-amber-600 font-black text-sm">#1</span>
                            @elseif($index == 1)
                                <span class="text-slate-500 font-black text-sm">#2</span>
                            @elseif($index == 2)
                                <span class="text-orange-700 font-black text-sm">#3</span>
                            @else
                                <span class="text-gray-700 font-black text-sm">#{{ $index + 1 }}</span>
                            @endif
                        </div>

                        <div class="pr-16 mb-4">
                            <span class="font-mono text-[10px] font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2 py-1 rounded md border border-[#0f4c3a]/10">{{ $rank->asset->asset_code }}</span>
                            <h4 class="font-bold text-gray-800 mt-2 text-sm leading-tight">{{ $rank->asset->asset_name }}</h4>
                        </div>

                        <div class="flex items-end justify-between bg-gray-50/80 p-3 rounded-lg border border-gray-100 mb-4">
                            <div>
                                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Skor Akhir (Vi)</span>
                                <span class="font-black text-lg text-gray-800 leading-none">{{ number_format((float)$rank->score, 3, '.', '') }}</span>
                            </div>
                            <div class="text-right">
                                @if($rank->score >= 0.8)
                                    <span class="bg-red-50 text-red-600 border border-red-100 px-2 py-1 rounded text-[10px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-exclamation-triangle-fill mr-1 text-red-500"></i> Sangat Mendesak
                                    </span>
                                @elseif($rank->score >= 0.6)
                                    <span class="bg-amber-50 text-amber-600 border border-amber-100 px-2 py-1 rounded text-[10px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-exclamation-circle-fill mr-1 text-amber-500"></i> Perlu Diganti
                                    </span>
                                @else
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-2 py-1 rounded text-[10px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-check-circle-fill mr-1 text-emerald-500"></i> Masih Layak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-2 print-hidden">
                            <a href="{{ route('assets.show', $rank->asset->id) }}" class="flex-1 inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-[#0f4c3a] hover:border-[#0f4c3a]/30 px-3 py-2 rounded-lg shadow-sm text-xs font-bold transition-all">
                                <i class="bi bi-eye mr-1.5"></i> Detail Aset
                            </a>

                            @if($rank->score >= 0.6)
                            <form id="form-replace-mobile-{{ $rank->asset->id }}" action="{{ route('assets.markAsReplaced', $rank->asset->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="button" onclick="konfirmasiPenggantian('form-replace-mobile-{{ $rank->asset->id }}', '{{ $rank->asset->asset_name }}')" class="w-full inline-flex items-center justify-center bg-emerald-600 text-white hover:bg-emerald-700 px-3 py-2 rounded-lg shadow-sm text-xs font-bold transition-all">
                                    <i class="bi bi-check-lg mr-1.5"></i> Tandai Diganti
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:block overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100 text-[11px] uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold text-center w-24">Peringkat</th>
                            <th class="py-4 px-6 font-bold whitespace-nowrap">Kode Aset</th>
                            <th class="py-4 px-6 font-bold">Nama Perangkat</th>
                            <th class="py-4 px-6 font-bold text-center whitespace-nowrap">Skor Akhir (Vi)</th>
                            <th class="py-4 px-6 font-bold whitespace-nowrap">Rekomendasi</th>
                            <th class="py-4 px-6 font-bold text-center print-hidden">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($rankings as $index => $rank)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 px-6 text-center">
                                @if($index == 0)
                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-amber-100 text-amber-600 font-bold text-base shadow-sm border border-amber-200">1</span>
                                @elseif($index == 1)
                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 text-slate-500 font-bold text-base shadow-sm border border-slate-200">2</span>
                                @elseif($index == 2)
                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-orange-100 text-orange-700 font-bold text-base shadow-sm border border-orange-200">3</span>
                                @else
                                    <span class="font-bold text-gray-400 text-sm">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="font-mono text-xs font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2.5 py-1 rounded-md border border-[#0f4c3a]/10">{{ $rank->asset->asset_code }}</span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-800 font-bold">{{ $rank->asset->asset_name }}</td>
                            
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <span class="font-bold text-base text-gray-800">{{ number_format((float)$rank->score, 3, '.', '') }}</span>
                            </td>
                            
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($rank->score >= 0.8)
                                    <span class="bg-red-50 text-red-600 border border-red-100 px-3 py-1 rounded-md text-[11px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-exclamation-triangle-fill mr-1.5 text-red-500"></i> Sangat Mendesak
                                    </span>
                                @elseif($rank->score >= 0.6)
                                    <span class="bg-amber-50 text-amber-600 border border-amber-100 px-3 py-1 rounded-md text-[11px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-exclamation-circle-fill mr-1.5 text-amber-500"></i> Perlu Diganti
                                    </span>
                                @else
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 px-3 py-1 rounded-md text-[11px] font-bold shadow-sm inline-flex items-center">
                                        <i class="bi bi-check-circle-fill mr-1.5 text-emerald-500"></i> Masih Layak
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center print-hidden">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('assets.show', $rank->asset->id) }}" class="inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-[#0f4c3a] hover:border-[#0f4c3a]/30 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold transition-all">
                                        <i class="bi bi-eye mr-1.5"></i> Detail
                                    </a>

                                    @if($rank->score >= 0.6)
                                    <form id="form-replace-desktop-{{ $rank->asset->id }}" action="{{ route('assets.markAsReplaced', $rank->asset->id) }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="konfirmasiPenggantian('form-replace-desktop-{{ $rank->asset->id }}', '{{ $rank->asset->asset_name }}')" class="inline-flex items-center justify-center bg-emerald-600 text-white hover:bg-emerald-700 px-3 py-1.5 rounded-lg shadow-sm text-xs font-bold transition-all">
                                            <i class="bi bi-check-lg mr-1.5"></i> Tandai Diganti
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="text-center py-20 px-4">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-50 mb-4 border border-gray-100 shadow-sm">
                    <i class="bi bi-bar-chart-steps text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Hasil Penilaian</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8 text-sm">Sistem belum memiliki data nilai aset untuk dikalkulasi. Silakan lakukan evaluasi terlebih dahulu di menu Manajemen Aset.</p>
                <a href="{{ route('assets.index') }}" class="print-hidden inline-flex items-center justify-center bg-[#0f4c3a] hover:bg-[#0a3629] text-white px-6 py-2.5 rounded-xl font-bold transition-colors shadow-sm text-sm">
                    <i class="bi bi-box-seam mr-2"></i> Menuju Manajemen Aset
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="pdfModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="pdfModalContent">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center bg-gray-50 gap-3">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 flex items-center m-0">
                <i class="bi bi-file-pdf-fill text-red-500 mr-2.5 text-xl"></i> Preview Laporan
            </h3>
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('spk.download-pdf') }}?download=1" class="bg-[#0f4c3a] text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold hover:bg-[#0a3629] transition-colors flex items-center shadow-sm">
                    <i class="bi bi-download mr-1 sm:mr-2"></i> Simpan
                </a>
                <button onclick="closePdfModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 w-8 h-8 rounded-lg flex items-center justify-center transition-colors focus:outline-none">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>
            </div>
        </div>
        <div class="flex-grow relative bg-gray-100">
            <div id="pdfLoading" class="absolute inset-0 flex flex-col items-center justify-center z-0">
                <div class="w-10 h-10 border-4 border-gray-200 border-t-[#0f4c3a] rounded-full animate-spin mb-3"></div>
                <p class="text-gray-500 font-medium text-sm">Menyiapkan Laporan PDF...</p>
            </div>
            <iframe id="pdfIframe" src="" class="w-full h-full border-none relative z-10 hidden" onload="document.getElementById('pdfLoading').style.display='none'; this.classList.remove('hidden');"></iframe>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openPdfModal() {
        const modal = document.getElementById('pdfModal');
        const iframe = document.getElementById('pdfIframe');
        const modalContent = document.getElementById('pdfModalContent');
        const loading = document.getElementById('pdfLoading');
        
        loading.style.display = 'flex';
        iframe.classList.add('hidden');
        iframe.src = "{{ route('spk.download-pdf') }}";
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }

    function closePdfModal() {
        const modal = document.getElementById('pdfModal');
        const iframe = document.getElementById('pdfIframe');
        const modalContent = document.getElementById('pdfModalContent');
        
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            iframe.src = ""; 
        }, 300);
    }

    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePdfModal();
        }
    });

    // Pop-up Konfirmasi Sebelum Aksi (Diperbarui biar cocok dengan ID form dinamis)
    function konfirmasiPenggantian(formId, namaAset) {
        Swal.fire({
            title: 'Tandai Aset Diganti?',
            text: `Aset "${namaAset}" akan ditandai sebagai sudah diganti dan disembunyikan dari daftar SPK.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#059669', // emerald-600
            cancelButtonColor: '#ef4444', // red-500
            confirmButtonText: '<i class="bi bi-check-lg mr-1"></i> Ya, Tandai!',
            cancelButtonText: 'Batal',
            reverseButtons: true, 
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl shadow-sm px-5 py-2.5 text-sm font-bold',
                cancelButton: 'rounded-xl shadow-sm px-5 py-2.5 text-sm font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#0f4c3a',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl shadow-sm px-6 py-2.5 text-sm font-bold'
            }
        });
    @endif
</script>
@endsection