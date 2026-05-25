@extends('layouts.app')

@section('content')
<div class="pb-12">
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight mb-2">Tambah Aset Baru</h2>
        <div class="text-sm sm:text-base text-gray-500 font-medium flex items-center flex-wrap">
            <a href="{{ route('assets.index') }}" class="hover:text-[#0f4c3a] transition-colors"><i class="bi bi-display mr-1"></i> Manajemen Aset</a>
            <i class="bi bi-chevron-right mx-2 sm:mx-3 text-xs"></i>
            <span class="text-gray-800 font-bold">Tambah Baru</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 p-4 sm:p-5 rounded-2xl mb-8 shadow-sm flex flex-col sm:flex-row gap-3 sm:gap-4 items-start">
            <i class="bi bi-exclamation-triangle-fill text-xl sm:text-2xl text-red-500 sm:mt-1"></i>
            <div>
                <span class="font-bold text-base sm:text-lg block mb-1">Gagal menyimpan data!</span>
                <ul class="list-disc list-inside text-sm sm:text-base">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex flex-col xl:flex-row gap-6">
            <div class="w-full xl:w-7/12 flex flex-col gap-6">
                
                <div class="bg-white p-5 sm:p-8 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
                    <div class="flex items-center mb-6 sm:mb-8 border-b border-gray-50 pb-4">
                        <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-xl w-8 h-8 sm:w-10 sm:h-10 flex shrink-0 items-center justify-center font-bold text-base sm:text-lg mr-3 sm:mr-4 border border-[#0f4c3a]/20">1</span>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Informasi Perangkat</h3>
                    </div>

                    <div class="space-y-5 sm:space-y-6">
                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Nama Perangkat <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-pc-display text-gray-400"></i>
                                </div>
                                <input type="text" name="asset_name" value="{{ old('asset_name') }}" required class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white" placeholder="Contoh: PC Dell Optiplex">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Status Barang (Kepemilikan) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-tag text-gray-400"></i>
                                </div>
                                <select name="item_status" required class="w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white appearance-none">
                                    <option value="BMN">Barang Milik Negara (BMN)</option>
                                    <option value="Pihak Ketiga">Pihak Ketiga (Sewa/Pinjam)</option>
                                    <option value="Barang Lainnya">Barang Lainnya</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="bi bi-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Upload Foto Utama Aset <span class="text-gray-400 font-medium text-xs sm:text-sm">(Opsional)</span></label>
                            <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all bg-gray-50/50 text-sm sm:text-base file:mr-4 file:py-2 sm:file:py-2.5 file:px-4 sm:file:px-5 file:rounded-lg file:border-0 file:text-xs sm:file:text-sm file:font-bold file:bg-[#0f4c3a] file:text-white hover:file:bg-[#0a3629] file:transition-colors file:cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 sm:p-8 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
                    <div class="flex items-center mb-6 sm:mb-8 border-b border-gray-50 pb-4">
                        <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-xl w-8 h-8 sm:w-10 sm:h-10 flex shrink-0 items-center justify-center font-bold text-base sm:text-lg mr-3 sm:mr-4 border border-[#0f4c3a]/20">2</span>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 flex flex-wrap items-center">Data Pembelian <span class="text-xs sm:text-sm font-medium text-gray-400 ml-2">(Opsional)</span></h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Tanggal Pembelian</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-calendar-date text-gray-400"></i>
                                </div>
                                <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Harga Beli (Rp)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-bold text-sm sm:text-base">Rp</span>
                                </div>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hidden xl:block mt-2">
                    <a href="{{ route('assets.index') }}" class="inline-flex justify-center items-center w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-8 py-3.5 rounded-xl text-base font-bold transition-all shadow-sm">
                        <i class="bi bi-arrow-left mr-2"></i> Kembali ke Manajemen Aset
                    </a>
                </div>
            </div>

            <div class="w-full xl:w-5/12 flex flex-col gap-6">
                
                <div class="bg-white p-5 sm:p-8 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex-1">
                    <div class="flex items-center mb-6 sm:mb-8 border-b border-gray-50 pb-4">
                        <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-xl w-8 h-8 sm:w-10 sm:h-10 flex shrink-0 items-center justify-center font-bold text-base sm:text-lg mr-3 sm:mr-4 border border-[#0f4c3a]/20">3</span>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Detail Teknis & Lokasi</h3>
                    </div>

                    <div class="space-y-5 sm:space-y-6">
                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category_id" required class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white appearance-none">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="bi bi-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Lokasi / Ruangan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-geo-alt text-gray-400"></i>
                                </div>
                                <select name="location" required class="w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white appearance-none">
                                    <option value="" disabled selected>-- Pilih Ruangan --</option>
                                    @foreach($locations as $room)
                                        <option value="{{ $room->name }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="bi bi-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Serial Number <span class="text-gray-400 font-medium text-xs sm:text-sm">(Opsional)</span></label>
                            <div class="relative mb-3">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-upc-scan text-gray-400"></i>
                                </div>
                                <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-gray-50/50 focus:bg-white" placeholder="Masukkan SN Teks...">
                            </div>
                            
                            <div class="mt-4 p-4 border-2 border-dashed border-gray-100 rounded-xl bg-gray-50/30">
                                <label class="block text-xs sm:text-sm text-gray-600 mb-2 font-bold">Upload Foto Label SN</label>
                                <input type="file" name="serial_number_photo" accept="image/*" class="w-full text-xs sm:text-sm text-gray-500 file:mr-2 sm:file:mr-4 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4 file:rounded-full file:border-0 file:font-bold file:bg-[#0f4c3a]/10 file:text-[#0f4c3a] hover:file:bg-[#0f4c3a]/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm sm:text-base text-gray-700 mb-2 font-bold">Kondisi Awal</label>
                            <div class="relative">
                                <select name="status" class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm sm:text-base bg-emerald-50 text-emerald-700 font-bold appearance-none">
                                    <option value="active">✔ AKTIF (KONDISI BAIK)</option>
                                    <option value="maintenance">🛠 MAINTENANCE (PERBAIKAN)</option>
                                    <option value="broken">✖ RUSAK TOTAL</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="bi bi-chevron-down text-emerald-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full bg-[#0f4c3a] hover:bg-[#0a3629] text-white py-3.5 sm:py-4 rounded-xl font-bold transition-all shadow-md hover:shadow-lg flex justify-center items-center text-base sm:text-lg">
                        <i class="bi bi-save mr-2"></i> Simpan Aset & Generate QR
                    </button>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 sm:p-6 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center justify-center mb-3">
                            <i class="bi bi-qr-code text-3xl sm:text-4xl text-[#0f4c3a]"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-700">QR Code Otomatis</p>
                        <p class="text-xs text-gray-500 mt-1">Sistem akan membuatkan QR Code setelah data berhasil disimpan.</p>
                    </div>

                    <div class="block xl:hidden">
                        <a href="{{ route('assets.index') }}" class="flex justify-center items-center w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 py-3.5 rounded-xl text-base font-bold transition-all shadow-sm">
                            Batal
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>
@endsection