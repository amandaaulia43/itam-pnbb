@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold text-gray-800 tracking-tight mb-2">Detail Aset IT</h2>
        <div class="text-base text-gray-500 font-medium flex items-center">
            <a href="{{ route('assets.index') }}" class="hover:text-[#0f4c3a] transition-colors"><i class="bi bi-display mr-1"></i> Manajemen Aset</a>
            <i class="bi bi-chevron-right mx-3 text-xs"></i>
            <span class="text-gray-800 font-bold">{{ $asset->asset_code }}</span>
        </div>
    </div>

    <div class="flex space-x-3 w-full md:w-auto">
        <a href="{{ route('assets.edit', $asset->id) }}" class="flex-1 md:flex-none justify-center bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl shadow-sm text-sm font-bold transition-all flex items-center">
            <i class="bi bi-pencil-square mr-2"></i> Edit Data
        </a>
        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="flex-1 md:flex-none flex" onsubmit="return confirm('Yakin ingin menghapus data aset ini secara permanen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full justify-center bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl shadow-sm text-sm font-bold transition-all flex items-center">
                <i class="bi bi-trash mr-2"></i> Hapus
            </button>
        </form>
    </div>
</div>

<div class="flex flex-col xl:flex-row gap-6">
    
    <div class="w-full xl:w-4/12 flex flex-col gap-6">
        
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-8">
            <div class="border-b border-gray-50 pb-4 mb-6 flex items-center">
                <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-lg w-8 h-8 flex items-center justify-center mr-3 border border-[#0f4c3a]/20">
                    <i class="bi bi-image"></i>
                </span>
                <h4 class="font-bold text-gray-800 text-lg">Foto Dokumentasi</h4>
            </div>
            
            <div class="space-y-6">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Foto Perangkat</span>
                    @if($asset->photo)
                        <div class="cursor-pointer group relative overflow-hidden rounded-xl border border-gray-100" onclick="openModal('{{ asset('storage/' . $asset->photo) }}', 'Foto Perangkat')">
                            <img src="{{ asset('storage/' . $asset->photo) }}" class="w-full h-48 object-cover transition duration-500 group-hover:scale-110 group-hover:brightness-75">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="bg-black/50 p-3 rounded-full text-white">
                                    <i class="bi bi-search text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-32 bg-gray-50 flex flex-col items-center justify-center text-gray-400 rounded-xl border-2 border-dashed">
                            <i class="bi bi-camera text-2xl mb-1"></i>
                            <p class="text-xs">Tidak ada foto</p>
                        </div>
                    @endif
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Foto Label Serial Number</span>
                    @if($asset->serial_number_photo)
                        <div class="cursor-pointer group relative overflow-hidden rounded-xl border border-gray-100" onclick="openModal('{{ asset('storage/' . $asset->serial_number_photo) }}', 'Foto Label Serial Number')">
                            <img src="{{ asset('storage/' . $asset->serial_number_photo) }}" class="w-full h-32 object-cover transition duration-500 group-hover:scale-110 group-hover:brightness-75">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="bg-black/50 p-3 rounded-full text-white">
                                    <i class="bi bi-search text-lg"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-24 bg-gray-50 flex flex-col items-center justify-center text-gray-400 rounded-xl border-2 border-dashed">
                            <i class="bi bi-upc-scan text-2xl mb-1"></i>
                            <p class="text-xs">Tidak ada foto label SN</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col items-center p-8">
            <div class="w-full border-b border-gray-50 pb-4 mb-6 flex justify-center items-center">
                <h4 class="font-bold text-gray-800 text-lg">QR Code Aset</h4>
            </div>
            
            <div class="bg-white p-5 border-2 border-dashed border-gray-200 rounded-2xl mb-4 shadow-sm flex items-center justify-center">
                {!! $qrCode !!}
            </div>
            
            <h3 class="text-2xl font-mono font-bold text-[#0f4c3a] mb-2 tracking-wider">{{ $asset->asset_code }}</h3>
            <p class="text-sm text-gray-500 mb-8 text-center">Scan untuk memantau status via mobile</p>
            
            <div class="w-full flex flex-col gap-3">
                <a href="{{ route('assets.download-pdf', $asset->id) }}" target="_blank" class="w-full bg-[#0f4c3a] hover:bg-[#0a3629] text-white py-3.5 rounded-xl shadow-md hover:shadow-lg text-base font-bold transition-all flex items-center justify-center">
                    <i class="bi bi-printer mr-2 text-lg"></i> Cetak / Unduh Label QR
                </a>
            </div>
        </div>
    </div>

    <div class="w-full xl:w-8/12 flex flex-col gap-6">
        
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
            <div class="border-b border-gray-50 px-8 py-5 flex items-center bg-gray-50/30">
                <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-lg w-8 h-8 flex items-center justify-center mr-3 border border-[#0f4c3a]/20">
                    <i class="bi bi-pc-display"></i>
                </span>
                <h3 class="font-bold text-lg text-gray-800 m-0">Spesifikasi Perangkat</h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-10">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Nama Perangkat</p>
                    <p class="text-gray-800 font-bold text-base">{{ $asset->asset_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kategori</p>
                    <p class="text-gray-800 font-medium text-base">{{ $asset->category->name ?? 'Tidak Ada Kategori' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Serial Number</p>
                    <p class="text-gray-800 font-medium text-base font-mono bg-gray-50 px-2 py-0.5 rounded border border-gray-100 inline-block">{{ $asset->serial_number ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Lokasi / Ruangan</p>
                    <p class="text-gray-800 font-medium text-base">{{ $asset->location }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tanggal Pembelian</p>
                    <p class="text-gray-800 font-medium text-base">{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->translatedFormat('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Harga Beli</p>
                    <p class="text-gray-800 font-bold text-base">{{ $asset->purchase_price ? 'Rp ' . number_format($asset->purchase_price, 0, ',', '.') : '-' }}</p>
                </div>
                
                <div class="md:col-span-2 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-3">Status Saat Ini</p>
                    @if($asset->status == 'active')
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center shadow-sm">
                            <i class="bi bi-check-circle-fill mr-2 text-emerald-500"></i> Aktif / Kondisi Baik
                        </span>
                    @elseif($asset->status == 'maintenance')
                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center shadow-sm">
                            <i class="bi bi-tools mr-2 text-amber-500"></i> Sedang Maintenance
                        </span>
                    @else
                        <span class="bg-red-50 text-red-700 border border-red-200 px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center shadow-sm">
                            <i class="bi bi-x-circle-fill mr-2 text-red-500"></i> Rusak Total
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
            <div class="border-b border-gray-50 px-8 py-5 flex flex-wrap items-center justify-between gap-4 bg-gray-50/30">
                <div class="flex items-center">
                    <span class="bg-[#0f4c3a]/10 text-[#0f4c3a] rounded-lg w-8 h-8 flex items-center justify-center mr-3 border border-[#0f4c3a]/20">
                        <i class="bi bi-wrench-adjustable"></i>
                    </span>
                    <h3 class="font-bold text-lg text-gray-800 m-0">Riwayat Maintenance</h3>
                </div>
                <a href="{{ route('assets.maintenance.create', $asset->id) }}" class="bg-[#0f4c3a] hover:bg-[#0a3629] text-white px-5 py-2 rounded-xl shadow-sm text-sm font-bold transition-all flex items-center">
                    <i class="bi bi-plus-circle mr-2"></i> Catat Perbaikan
                </a>
            </div>
            
            @if($asset->maintenances && $asset->maintenances->count() > 0)
                <div class="divide-y divide-gray-50">
                    @foreach($asset->maintenances->sortByDesc('maintenance_date') as $maintenance)
                    <div class="p-8 hover:bg-gray-50/50 transition-colors">
                        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
                            <div>
                                <span class="inline-flex items-center bg-[#0f4c3a]/5 text-[#0f4c3a] text-xs px-3 py-1.5 rounded-lg font-bold mb-2 border border-[#0f4c3a]/10">
                                    <i class="bi bi-calendar-event mr-1.5"></i> {{ \Carbon\Carbon::parse($maintenance->maintenance_date)->translatedFormat('d F Y') }}
                                </span>
                                <h4 class="font-bold text-gray-800 text-lg flex items-center">
                                    <i class="bi bi-person-badge text-gray-400 mr-2 text-base"></i> {{ $maintenance->technician_name }}
                                </h4>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-xl text-sm text-gray-700 border border-gray-100">
                            <p class="text-gray-600 leading-relaxed">{{ $maintenance->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4 border border-gray-100">
                        <i class="bi bi-clipboard-check text-3xl text-gray-300"></i>
                    </div>
                    <h5 class="text-gray-800 font-bold text-lg mb-1">Belum Ada Riwayat</h5>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="imageModal" class="fixed inset-0 z-[9999] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300 opacity-0" onclick="closeModal()">
    <button class="absolute top-5 right-5 text-white hover:text-red-400 transition-colors z-50" onclick="closeModal()">
        <i class="bi bi-x-lg text-4xl"></i>
    </button>
    
    <div class="relative max-w-5xl w-full flex flex-col items-center justify-center" onclick="event.stopPropagation()">
        <img id="modalImage" src="" class="max-h-[85vh] max-w-full rounded-lg shadow-2xl transition-transform duration-300 scale-90 border-4 border-white/10">
        <div id="modalCaption" class="mt-4 text-white font-bold text-lg bg-black/50 px-6 py-2 rounded-full border border-white/20"></div>
    </div>
</div>

<script>
    function openModal(imageSrc, caption) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCap = document.getElementById('modalCaption');
        
        modalImg.src = imageSrc;
        modalCap.innerText = caption;
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            modalImg.classList.remove('scale-90');
            modalImg.classList.add('scale-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        
        modal.classList.remove('opacity-100');
        modalImg.classList.add('scale-90');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
        
        document.body.style.overflow = 'auto';
    }

    // Tutup modal jika menekan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeModal();
    });
</script>
@endsection