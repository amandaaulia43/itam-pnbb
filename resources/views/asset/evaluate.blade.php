@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto w-full font-sans pb-24 lg:pb-10">
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2 tracking-tight">Penilaian Strategis Aset</h2>
            <div class="text-sm text-gray-500 flex items-center font-medium">
                <a href="{{ route('assets.index') }}" class="hover:text-[#0f4c3a] transition-colors flex items-center">
                    <i class="bi bi-display mr-1"></i> Inventaris
                </a>
                <i class="bi bi-chevron-right mx-3 text-[10px] text-gray-400"></i>
                <span class="text-gray-800">Form SPK SAW</span>
            </div>
        </div>
        <a href="{{ route('assets.index') }}" class="group flex items-center text-sm font-bold text-gray-500 hover:text-[#0f4c3a] transition-all bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 w-fit">
            <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali
        </a>
    </div>

    <div class="bg-[#0f4c3a] rounded-3xl p-6 md:p-8 mb-8 shadow-xl shadow-[#0f4c3a]/20 relative overflow-hidden text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center w-full">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mr-4 md:mr-5 shadow-inner shrink-0">
                    <i class="bi bi-cpu text-2xl md:text-3xl"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-white/60 text-[10px] uppercase font-bold tracking-[0.2em] mb-1">Target Penilaian</p>
                    <h3 class="text-xl md:text-2xl font-bold tracking-tight truncate">{{ $asset->asset_name }}</h3>
                    <p class="text-white/80 font-mono text-xs md:text-sm">{{ $asset->asset_code }}</p>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 px-5 py-3 rounded-2xl text-left md:text-right w-full md:w-auto">
                <p class="text-[10px] uppercase font-bold text-white/50 mb-1">Metode Analisis</p>
                <p class="font-bold text-base md:text-lg leading-none">Simple Additive Weighting</p>
            </div>
        </div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <form action="{{ route('assets.store_evaluate', $asset->id) }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden group">
                <div class="p-5 md:p-8 flex flex-col md:flex-row gap-4 md:gap-6">
                    <div class="md:w-1/3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-[#0f4c3a] text-white text-[10px] font-bold px-2 py-0.5 rounded">C1</span>
                            <h4 class="font-bold text-gray-800">Kondisi Fisik</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Menilai integritas fisik dan stabilitas operasional perangkat saat ini.</p>
                    </div>
                    <div class="md:w-2/3">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">Pilih Parameter Kondisi</label>
                        <select name="c1" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#0f4c3a]/5 focus:border-[#0f4c3a] outline-none transition-all font-semibold text-gray-700 appearance-none cursor-pointer text-sm">
                            <option value="" disabled {{ empty($evaluation) ? 'selected' : '' }}>-- Tentukan Kondisi --</option>
                            <option value="5" {{ old('c1', $evaluation->c1 ?? '') == 5 ? 'selected' : '' }}>[5] Mati Total / Rusak Berat</option>
                            <option value="4" {{ old('c1', $evaluation->c1 ?? '') == 4 ? 'selected' : '' }}>[4] Buruk / Sering Terjadi Kendala</option>
                            <option value="3" {{ old('c1', $evaluation->c1 ?? '') == 3 ? 'selected' : '' }}>[3] Cukup / Kadang Melambat</option>
                            <option value="2" {{ old('c1', $evaluation->c1 ?? '') == 2 ? 'selected' : '' }}>[2] Baik / Performa Normal</option>
                            <option value="1" {{ old('c1', $evaluation->c1 ?? '') == 1 ? 'selected' : '' }}>[1] Sangat Baik / Kondisi Prima</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden relative">
                <div class="p-5 md:p-8 flex flex-col md:flex-row gap-4 md:gap-6">
                    <div class="md:w-1/3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-[#0f4c3a] text-white text-[10px] font-bold px-2 py-0.5 rounded">C2</span>
                            <h4 class="font-bold text-gray-800">Umur Ekonomis</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Masa pakai sejak tanggal perolehan: <span class="font-bold text-gray-700">{{ $asset->purchase_date ?? 'N/A' }}</span></p>
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Parameter Usia</label>
                            @if(isset($autoC2) && empty($evaluation))
                                <span class="text-[9px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center">
                                    <i class="bi bi-magic mr-1"></i> Auto-Calculated
                                </span>
                            @endif
                        </div>
                        <select name="c2" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#0f4c3a]/5 focus:border-[#0f4c3a] outline-none transition-all font-semibold text-gray-700 appearance-none text-sm">
                            <option value="5" {{ old('c2', $evaluation->c2 ?? $autoC2 ?? '') == 5 ? 'selected' : '' }}>[5] > 5 Tahun (Sangat Tua)</option>
                            <option value="4" {{ old('c2', $evaluation->c2 ?? $autoC2 ?? '') == 4 ? 'selected' : '' }}>[4] 4 - 5 Tahun</option>
                            <option value="3" {{ old('c2', $evaluation->c2 ?? $autoC2 ?? '') == 3 ? 'selected' : '' }}>[3] 3 - 4 Tahun</option>
                            <option value="2" {{ old('c2', $evaluation->c2 ?? $autoC2 ?? '') == 2 ? 'selected' : '' }}>[2] 1 - 2 Tahun</option>
                            <option value="1" {{ old('c2', $evaluation->c2 ?? $autoC2 ?? '') == 1 ? 'selected' : '' }}>[1] < 1 Tahun (Baru)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden">
                <div class="p-5 md:p-8 flex flex-col md:flex-row gap-4 md:gap-6">
                    <div class="md:w-1/3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-[#0f4c3a] text-white text-[10px] font-bold px-2 py-0.5 rounded">C3</span>
                            <h4 class="font-bold text-gray-800">Frekuensi Maintenance</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Terdeteksi <span class="font-bold {{ $maintenanceCount > 0 ? 'text-red-500' : 'text-green-500' }}">{{ $maintenanceCount }} insiden</span> perbaikan setahun terakhir.</p>
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Parameter Kerusakan</label>
                            @if(isset($autoC3) && empty($evaluation))
                                <span class="text-[9px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center">
                                    <i class="bi bi-magic mr-1"></i> Sync with History
                                </span>
                            @endif
                        </div>
                        <select name="c3" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#0f4c3a]/5 focus:border-[#0f4c3a] outline-none transition-all font-semibold text-gray-700 text-sm">
                            <option value="5" {{ old('c3', $evaluation->c3 ?? $autoC3 ?? '') == 5 ? 'selected' : '' }}>[5] Sangat Sering (> 5 kali)</option>
                            <option value="4" {{ old('c3', $evaluation->c3 ?? $autoC3 ?? '') == 4 ? 'selected' : '' }}>[4] Sering (4 - 5 kali)</option>
                            <option value="3" {{ old('c3', $evaluation->c3 ?? $autoC3 ?? '') == 3 ? 'selected' : '' }}>[3] Jarang (2 - 3 kali)</option>
                            <option value="2" {{ old('c3', $evaluation->c3 ?? $autoC3 ?? '') == 2 ? 'selected' : '' }}>[2] Pernah (1 kali)</option>
                            <option value="1" {{ old('c3', $evaluation->c3 ?? $autoC3 ?? '') == 1 ? 'selected' : '' }}>[1] Tidak Pernah Rusak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden">
                <div class="p-5 md:p-8 flex flex-col md:flex-row gap-4 md:gap-6">
                    <div class="md:w-1/3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-[#0f4c3a] text-white text-[10px] font-bold px-2 py-0.5 rounded">C4</span>
                            <h4 class="font-bold text-gray-800">Tingkat Urgensi</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Berdasarkan lokasi penempatan: <span class="font-bold text-gray-700">{{ $asset->location }}</span></p>
                    </div>
                    <div class="md:w-2/3">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">Skala Prioritas</label>
                        <select name="c4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#0f4c3a]/5 focus:border-[#0f4c3a] outline-none transition-all font-semibold text-gray-700 text-sm">
                            <option value="" disabled {{ empty($evaluation) ? 'selected' : '' }}>-- Pilih Urgensi --</option>
                            <option value="5" {{ old('c4', $evaluation->c4 ?? '') == 5 ? 'selected' : '' }}>[5] Vital (Server / PTSP / Ruang Sidang)</option>
                            <option value="4" {{ old('c4', $evaluation->c4 ?? '') == 4 ? 'selected' : '' }}>[4] Strategis (Ruang Pimpinan / Hakim)</option>
                            <option value="3" {{ old('c4', $evaluation->c4 ?? '') == 3 ? 'selected' : '' }}>[3] Operasional (Kepaniteraan)</option>
                            <option value="2" {{ old('c4', $evaluation->c4 ?? '') == 2 ? 'selected' : '' }}>[2] Penunjang (Umum / Arsip)</option>
                            <option value="1" {{ old('c4', $evaluation->c4 ?? '') == 1 ? 'selected' : '' }}>[1] Sekunder (Gudang)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden">
                <div class="p-5 md:p-8 flex flex-col md:flex-row gap-4 md:gap-6">
                    <div class="md:w-1/3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">C5</span>
                            <h4 class="font-bold text-gray-800">Biaya Reinvestasi</h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Estimasi harga pasar untuk penggantian unit baru sejenis.</p>
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Rentang Harga Penggantian</label>
                            @if(isset($autoC5) && empty($evaluation))
                                <span class="text-[9px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center">
                                    <i class="bi bi-tag mr-1"></i> Based on Purchase Price
                                </span>
                            @endif
                        </div>
                        <select name="c5" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-[#0f4c3a]/5 focus:border-[#0f4c3a] outline-none transition-all font-semibold text-gray-700 text-sm">
                            <option value="5" {{ old('c5', $evaluation->c5 ?? $autoC5 ?? '') == 5 ? 'selected' : '' }}>[5] Murah (< Rp 1 Juta)</option>
                            <option value="4" {{ old('c5', $evaluation->c5 ?? $autoC5 ?? '') == 4 ? 'selected' : '' }}>[4] Terjangkau (Rp 1 - 3 Juta)</option>
                            <option value="3" {{ old('c5', $evaluation->c5 ?? $autoC5 ?? '') == 3 ? 'selected' : '' }}>[3] Sedang (Rp 3 - 5 Juta)</option>
                            <option value="2" {{ old('c5', $evaluation->c5 ?? $autoC5 ?? '') == 2 ? 'selected' : '' }}>[2] Mahal (Rp 5 - 10 Juta)</option>
                            <option value="1" {{ old('c5', $evaluation->c5 ?? $autoC5 ?? '') == 1 ? 'selected' : '' }}>[1] Sangat Mahal (> Rp 10 Juta)</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 mb-6 flex flex-col sm:flex-row items-center justify-between bg-white p-5 md:p-6 rounded-3xl border border-gray-100 shadow-lg gap-4">
            <div class="flex items-start md:items-center text-gray-400 text-xs italic">
                <i class="bi bi-info-circle-fill mt-0.5 md:mt-0 mr-2 text-[#0f4c3a]"></i>
                <p>Pastikan data yang diinput objektif untuk hasil perangkingan yang akurat.</p>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full bg-[#0f4c3a] hover:bg-[#0a3629] text-white px-8 py-3.5 rounded-2xl font-bold transition-all shadow-lg shadow-[#0f4c3a]/20 transform hover:-translate-y-1 active:scale-95 flex items-center justify-center">
                    <i class="bi bi-check2-circle mr-2 text-xl"></i> Finalisasi & Simpan
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    .font-sans {
        font-family: 'Poppins', sans-serif !important;
    }

    /* Custom Select Icon */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1.25rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
</style>
@endsection