@extends('layouts.app')

@section('content')
<div class="pb-24 lg:pb-10 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('maintenances.index') }}" class="w-11 h-11 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-[#0f4c3a] hover:bg-emerald-50 hover:border-[#0f4c3a]/30 transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Riwayat Maintenance</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Perbarui detail data perbaikan perangkat IT</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-center">
            <h3 class="text-lg font-bold text-gray-800 m-0 flex items-center">
                <i class="bi bi-pencil-square mr-3 text-[#0f4c3a] text-xl"></i> Form Edit Data Perbaikan
            </h3>
        </div>

        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-8 flex items-start gap-3">
                <div class="mt-0.5"><i class="bi bi-info-circle-fill text-blue-500 text-lg"></i></div>
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1.5">Aset yang sedang diedit</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-mono text-xs font-bold text-[#0f4c3a] bg-[#0f4c3a]/5 px-2.5 py-1 rounded-md border border-[#0f4c3a]/10">
                            {{ $maintenance->asset->asset_code }}
                        </span>
                        <span class="text-sm font-bold text-gray-800">{{ $maintenance->asset->asset_name }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Perbaikan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="date" name="maintenance_date" value="{{ $maintenance->maintenance_date }}" class="w-full pl-4 pr-10 py-2.5 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Teknisi / Nama Vendor <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="technician_name" value="{{ $maintenance->technician_name }}" class="w-full pl-4 pr-10 py-2.5 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white placeholder-gray-400" placeholder="Masukkan nama teknisi..." required>
                        <i class="bi bi-person text-gray-400 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Biaya Perbaikan</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>
                        <input type="number" name="repair_cost" value="{{ $maintenance->repair_cost }}" class="w-full pl-12 pr-4 py-2.5 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white placeholder-gray-400" placeholder="Contoh: 500000 (Kosongkan jika gratis)">
                    </div>
                    <p class="text-xs text-gray-500 mt-1.5 font-medium">*Isi angka saja tanpa titik (Contoh: 500000). Kosongkan jika perbaikan gratis.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Kerusakan / Keluhan <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="3" class="w-full p-4 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white placeholder-gray-400 leading-relaxed" placeholder="Jelaskan detail kerusakan atau keluhan yang dilaporkan..." required>{{ $maintenance->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tindakan / Solusi yang Dilakukan <span class="text-red-500">*</span></label>
                    <textarea name="action_taken" rows="3" class="w-full p-4 rounded-xl text-sm border border-gray-200 focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a] transition-all outline-none bg-gray-50/50 focus:bg-white placeholder-gray-400 leading-relaxed" placeholder="Jelaskan tindakan perbaikan atau pergantian sparepart yang telah dilakukan..." required>{{ $maintenance->action_taken }}</textarea>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('maintenances.index') }}" class="w-full sm:w-auto px-6 py-2.5 border border-gray-200 bg-white rounded-xl text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all font-bold text-sm text-center shadow-sm">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-[#0f4c3a] text-white rounded-xl hover:bg-[#0a3629] transition-all font-bold text-sm flex items-center justify-center shadow-sm">
                    <i class="bi bi-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection