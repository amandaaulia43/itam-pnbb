@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Proses Laporan Kerusakan</h1>
        <a href="{{ route('maintenances.laporan_masuk') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500"></div>
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <i class="bi bi-pc-display text-emerald-600"></i>
                    <h6 class="font-bold text-gray-800 text-sm">Informasi Aset</h6>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-black text-[#0f4c3a]">{{ $laporan->asset->asset_name }}</h3>
                            <span class="inline-block mt-1 px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded">{{ $laporan->asset->asset_code }}</span>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-semibold text-gray-800">{{ $laporan->asset->category->category_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-500">Waktu Laporan</span>
                            <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($laporan->maintenance_date)->format('d M Y - H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-50 bg-red-50/30 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                    <h6 class="font-bold text-red-800 text-sm">Detail Aduan Pengguna</h6>
                </div>
                <div class="p-6 text-sm text-gray-700 bg-red-50/10 leading-relaxed italic border-l-4 border-red-400 mx-6 my-4 rounded-r-lg">
                    "{{ $laporan->description }}"
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h6 class="font-bold text-[#0f4c3a]">Form Tindakan Lanjutan</h6>
                    <p class="text-xs text-gray-500 mt-1">Isi form ini untuk memindahkan tiket ke Riwayat Maintenance</p>
                </div>
                
                <div class="p-6 md:p-8">
                    <form action="{{ route('maintenances.simpan_proses_laporan', $laporan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="technician_name" class="block mb-2 text-sm font-semibold text-gray-800">Teknisi Penanggung Jawab <span class="text-red-500">*</span></label>
                            <input type="text" name="technician_name" id="technician_name" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 transition-all @error('technician_name') border-red-500 focus:ring-red-200 @enderror" value="{{ old('technician_name') }}" required placeholder="Contoh: Tim IT / Budi">
                            @error('technician_name')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="action_taken" class="block mb-2 text-sm font-semibold text-gray-800">Tindakan / Analisa Awal <span class="text-red-500">*</span></label>
                            <textarea name="action_taken" id="action_taken" rows="4" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 transition-all @error('action_taken') border-red-500 focus:ring-red-200 @enderror" required placeholder="Contoh: Sedang dilakukan pengecekan mendalam terkait hardware...">{{ old('action_taken') }}</textarea>
                            @error('action_taken')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="repair_cost" class="block mb-2 text-sm font-semibold text-gray-800">Estimasi Biaya <span class="text-gray-400 font-normal text-xs ml-1">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 text-sm font-medium">Rp</span>
                                </div>
                                <input type="number" name="repair_cost" id="repair_cost" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-3 transition-all @error('repair_cost') border-red-500 @enderror" value="{{ old('repair_cost') }}" placeholder="0">
                            </div>
                            @error('repair_cost')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <label for="asset_status" class="block mb-2 text-sm font-semibold text-gray-800">Update Status Perangkat <span class="text-red-500">*</span></label>
                            <select name="asset_status" id="asset_status" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 shadow-sm transition-all @error('asset_status') border-red-500 @enderror" required>
                                <option value="" disabled selected>-- Pilih Status Selanjutnya --</option>
                                <option value="maintenance" {{ old('asset_status') == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance (Sedang Diperbaiki)</option>
                                <option value="broken" {{ old('asset_status') == 'broken' ? 'selected' : '' }}>⚠️ Broken (Rusak Berat / Butuh Part)</option>
                                <option value="active" {{ old('asset_status') == 'active' ? 'selected' : '' }}>✅ Active (Ternyata Normal / False Alarm)</option>
                            </select>
                            @error('asset_status')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 mt-6 border-t border-gray-100">
                            <button type="submit" class="w-full text-white bg-gradient-to-r from-[#0f4c3a] to-emerald-600 hover:from-[#0a382a] hover:to-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all shadow-md transform hover:-translate-y-0.5">
                                <i class="bi bi-check2-circle text-lg mr-1 align-middle"></i> Eksekusi & Simpan ke Riwayat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection