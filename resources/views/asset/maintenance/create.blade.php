@extends('layouts.app')

@section('content')
<div class="mb-8 font-sans">
    <h2 class="text-3xl font-bold text-gray-800 mb-2 tracking-tight">Catat Perbaikan Aset</h2>
    <div class="text-sm text-gray-500 flex items-center font-medium">
        <a href="{{ route('assets.index') }}" class="hover:text-[#0f4c3a] transition-colors flex items-center">
            <i class="bi bi-display mr-1"></i> Manajemen Aset
        </a>
        <i class="bi bi-chevron-right mx-3 text-[10px] text-gray-400"></i>
        <a href="{{ route('assets.show', $asset->id) }}" class="hover:text-[#0f4c3a] transition-colors">
            Detail Aset
        </a>
        <i class="bi bi-chevron-right mx-3 text-[10px] text-gray-400"></i>
        <span class="text-gray-800">Catat Maintenance</span>
    </div>
</div>

<div class="bg-white rounded-2xl p-6 mb-8 shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 font-sans">
    <div class="flex items-center">
        <div class="w-14 h-14 bg-[#0f4c3a]/10 rounded-2xl flex items-center justify-center text-[#0f4c3a] mr-4">
            <i class="bi bi-tools text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Aset yang diperbaiki</p>
            <h3 class="text-xl font-bold text-gray-800">{{ $asset->asset_name }} <span class="text-[#0f4c3a] font-mono ml-2 text-lg">[{{ $asset->asset_code }}]</span></h3>
        </div>
    </div>
    <div class="flex gap-6">
        <div class="text-right">
            <p class="text-[10px] uppercase font-bold text-gray-400">Lokasi</p>
            <p class="font-semibold text-gray-700">{{ $asset->location }}</p>
        </div>
        <div class="text-right">
            <p class="text-[10px] uppercase font-bold text-gray-400">Status Saat Ini</p>
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold uppercase">{{ $asset->status }}</span>
        </div>
    </div>
</div>

<form action="{{ url('asset/' . $asset->id . '/maintenance') }}" method="POST" class="font-sans">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7 flex flex-col gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-50 px-8 py-5 flex items-center bg-gray-50/50">
                    <span class="bg-[#0f4c3a] text-white rounded-lg w-8 h-8 flex items-center justify-center font-bold mr-3 shadow-sm text-sm">1</span>
                    <h3 class="font-bold text-lg text-gray-800">Informasi & Tindakan Perbaikan</h3>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Tanggal Perbaikan <span class="text-red-500">*</span></label>
                            <input type="date" name="maintenance_date" required value="{{ date('Y-m-d') }}" 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] outline-none transition-all text-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Teknisi / Vendor <span class="text-red-500">*</span></label>
                            <input type="text" name="technician_name" required placeholder="Contoh: IT Internal / PT. Maju Jaya" 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] outline-none transition-all text-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Tindakan yang Dilakukan <span class="text-red-500">*</span></label>
                        <textarea name="action_taken" rows="4" required placeholder="Suku cadang apa yang diganti? Apa yang sudah diperbaiki?" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] outline-none transition-all resize-none text-sm"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Total Biaya (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="repair_cost" placeholder="0" 
                                class="w-full border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] outline-none transition-all font-bold text-[#0f4c3a] text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex-1">
                <div class="border-b border-gray-50 px-8 py-5 flex items-center bg-gray-50/50">
                    <span class="bg-[#0f4c3a] text-white rounded-lg w-8 h-8 flex items-center justify-center font-bold mr-3 shadow-sm text-sm">2</span>
                    <h3 class="font-bold text-lg text-gray-800">Diagnosa Masalah</h3>
                </div>
                <div class="p-8">
                    <label class="text-sm font-semibold text-gray-700 ml-1 mb-2 block">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                    <textarea name="description" required rows="6" placeholder="Ceritakan detail kerusakan atau keluhan user di sini..." 
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-[#0f4c3a]/10 focus:border-[#0f4c3a] outline-none transition-all resize-none min-h-[180px] text-sm"></textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-50 px-8 py-5 flex items-center bg-gray-50/50">
                    <span class="bg-[#0f4c3a] text-white rounded-lg w-8 h-8 flex items-center justify-center font-bold mr-3 shadow-sm text-sm">4</span>
                    <h3 class="font-bold text-lg text-gray-800">Status Akhir Aset</h3>
                </div>
                <div class="p-8 space-y-4">
                    <div class="grid grid-cols-1 gap-3">
                        <label class="flex items-center p-3 border border-gray-100 rounded-xl hover:bg-green-50 transition-colors cursor-pointer group">
                            <input type="radio" name="asset_status" value="active" {{ $asset->status == 'active' ? 'checked' : '' }} class="w-4 h-4 text-[#0f4c3a] focus:ring-[#0f4c3a]">
                            <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-green-700">Active (Siap Pakai)</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-100 rounded-xl hover:bg-yellow-50 transition-colors cursor-pointer group">
                            <input type="radio" name="asset_status" value="maintenance" {{ $asset->status == 'maintenance' ? 'checked' : '' }} class="w-4 h-4 text-yellow-500 focus:ring-yellow-500">
                            <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-yellow-700">Masih Perbaikan</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-100 rounded-xl hover:bg-red-50 transition-colors cursor-pointer group">
                            <input type="radio" name="asset_status" value="broken" {{ $asset->status == 'broken' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                            <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-red-700">Rusak Total</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 bg-[#0f4c3a] hover:bg-[#0a3629] text-white py-4 rounded-xl font-bold shadow-lg shadow-[#0f4c3a]/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center text-sm">
                            <i class="bi bi-save2-fill mr-2"></i> Simpan
                        </button>
                        <a href="{{ route('assets.show', $asset->id) }}" class="px-6 py-4 bg-gray-100 text-gray-500 rounded-xl font-bold hover:bg-gray-200 transition-all text-center text-sm">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    /* Mengimpor Poppins jika belum ada di app.blade.php */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    .font-sans {
        font-family: 'Poppins', sans-serif !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(21%) sepia(35%) saturate(1054%) hue-rotate(115deg) brightness(92%) contrast(92%);
    }
</style>
@endsection