@extends('layouts.app')

@section('content')
<div class="mb-6 pb-24 lg:pb-10">
    <h2 class="text-3xl font-serif text-gray-800 mb-1">Halaman Edit Aset</h2>
    <div class="text-sm text-gray-600 flex items-center flex-wrap gap-y-2">
        <a href="{{ route('assets.index') }}" class="hover:text-[#0f4c3a] transition-colors whitespace-nowrap">Manajemen Aset</a>
        <i class="bi bi-chevron-right mx-2 text-[10px]"></i>
        <a href="{{ route('assets.show', $asset->id) }}" class="hover:text-[#0f4c3a] transition-colors whitespace-nowrap">Detail Aset</a>
        <i class="bi bi-chevron-right mx-2 text-[10px]"></i>
        <span class="text-gray-800 font-medium whitespace-nowrap">Edit Data</span>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-500 p-4 rounded-xl mt-6 border border-red-200 shadow-sm">
            <div class="flex items-center mb-2 font-bold">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i> Mohon periksa kembali inputan Anda:
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="flex flex-col lg:flex-row gap-6">
            
            <div class="w-full lg:w-1/2 flex flex-col gap-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <span class="bg-[#0f4c3a] text-white w-7 h-7 min-w-[1.75rem] rounded-full inline-flex items-center justify-center font-bold mr-3 shadow-sm">1</span>
                        <h3 class="font-serif text-lg sm:text-xl text-gray-800 m-0">Foto Perangkat</h3>
                    </div>

                    <div class="flex justify-center mb-5">
                        @if($asset->photo)
                            <div class="relative group w-full sm:w-auto">
                                <img src="{{ asset('storage/' . $asset->photo) }}" alt="Foto Aset" class="w-full sm:max-w-xs max-h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center text-white text-xs">
                                    Preview Saat Ini
                                </div>
                            </div>
                        @else
                            <div class="w-full h-32 bg-gray-50 flex flex-col items-center justify-center text-gray-400 rounded-lg border-2 border-dashed border-gray-200">
                                <i class="bi bi-camera text-3xl mb-1"></i>
                                <p class="text-sm">Belum ada foto</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 font-medium mb-2">Ubah Foto Perangkat (Opsional)</label>
                        <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg" class="w-full border border-gray-300 bg-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#0f4c3a]/10 file:text-[#0f4c3a] hover:file:bg-[#0f4c3a]/20 cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-2 leading-relaxed"><i class="bi bi-info-circle"></i> Biarkan kosong jika tidak ingin mengubah foto perangkat.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <span class="bg-[#0f4c3a] text-white w-7 h-7 min-w-[1.75rem] rounded-full inline-flex items-center justify-center font-bold mr-3 shadow-sm">2</span>
                        <h3 class="font-serif text-lg sm:text-xl text-gray-800 m-0">Informasi Perangkat</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm text-gray-700 font-medium mb-1">Kode Aset</label>
                            <input type="text" value="{{ $asset->asset_code }}" class="w-full border border-gray-300 bg-gray-100 text-gray-500 rounded-lg px-4 py-2.5 outline-none cursor-not-allowed text-sm sm:text-base" readonly>
                            <p class="text-[11px] text-gray-500 mt-1"><i class="bi bi-info-circle"></i> Kode aset digenerate otomatis dan tidak dapat diubah.</p>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 font-medium mb-1">Nama Perangkat <span class="text-red-500">*</span></label>
                            <input type="text" name="asset_name" value="{{ old('asset_name', $asset->asset_name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all text-sm sm:text-base" required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Tanggal Pembelian</label>
                                <input type="date" name="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all text-sm sm:text-base">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Harga Beli (Rp)</label>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price', $asset->purchase_price) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all text-sm sm:text-base" placeholder="Contoh: 5000000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col gap-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <span class="bg-[#0f4c3a] text-white w-7 h-7 min-w-[1.75rem] rounded-full inline-flex items-center justify-center font-bold mr-3 shadow-sm">3</span>
                        <h3 class="font-serif text-lg sm:text-xl text-gray-800 m-0">Detail Teknis & Lokasi</h3>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all bg-white text-sm sm:text-base" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $asset->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Lokasi / Ruangan <span class="text-red-500">*</span></label>
                                <input type="text" name="location" value="{{ old('location', $asset->location) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all text-sm sm:text-base" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Serial Number</label>
                                <input type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all font-mono text-sm" placeholder="SN-XXXXXXX">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 font-medium mb-1">Status Kepemilikan <span class="text-red-500">*</span></label>
                                <select name="item_status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all bg-white text-sm sm:text-base" required>
                                    <option value="BMN" {{ (old('item_status', $asset->item_status) == 'BMN') ? 'selected' : '' }}>BMN (Barang Milik Negara)</option>
                                    <option value="Pihak Ketiga" {{ (old('item_status', $asset->item_status) == 'Pihak Ketiga') ? 'selected' : '' }}>Pihak Ketiga</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 font-medium mb-1">Kondisi Perangkat</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all bg-white text-sm sm:text-base">
                                <option value="active" {{ (old('status', $asset->status) == 'active') ? 'selected' : '' }}>Active (Digunakan / Siap Pakai)</option>
                                <option value="maintenance" {{ (old('status', $asset->status) == 'maintenance') ? 'selected' : '' }}>Maintenance (Dalam Perbaikan)</option>
                                <option value="broken" {{ (old('status', $asset->status) == 'broken') ? 'selected' : '' }}>Broken (Rusak / Tidak Bisa Dipakai)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <span class="bg-[#0f4c3a] text-white w-7 h-7 min-w-[1.75rem] rounded-full inline-flex items-center justify-center font-bold mr-3 shadow-sm">4</span>
                        <h3 class="font-serif text-lg sm:text-xl text-gray-800 m-0">Foto Label Serial Number</h3>
                    </div>

                    <div class="flex justify-center mb-5">
                        @if($asset->serial_number_photo)
                            <div class="relative group w-full sm:w-auto">
                                <img src="{{ asset('storage/' . $asset->serial_number_photo) }}" alt="Foto SN" class="w-full sm:max-w-xs h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center text-white text-xs">
                                    Label SN Saat Ini
                                </div>
                            </div>
                        @else
                            <div class="w-full h-32 bg-gray-50 flex flex-col items-center justify-center text-gray-400 rounded-lg border-2 border-dashed border-gray-200">
                                <i class="bi bi-upc-scan text-3xl mb-1"></i>
                                <p class="text-sm">Belum ada foto label SN</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 font-medium mb-2">Ubah Foto Label SN (Opsional)</label>
                        <input type="file" name="serial_number_photo" id="serial_number_photo" accept="image/png, image/jpeg, image/jpg" class="w-full border border-gray-300 bg-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#0f4c3a]/10 file:text-[#0f4c3a] hover:file:bg-[#0f4c3a]/20 cursor-pointer">
                        <p class="text-[11px] text-gray-500 mt-2"><i class="bi bi-info-circle"></i> Pastikan barcode/angka SN terlihat jelas.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('assets.show', $asset->id) }}" class="w-full sm:w-auto text-center text-gray-500 hover:text-gray-800 font-medium border border-gray-200 px-5 py-2.5 rounded-lg transition-colors bg-gray-50 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto flex justify-center bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-md font-medium transition-colors items-center">
                        <i class="bi bi-save mr-2"></i> Update Data Aset
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection