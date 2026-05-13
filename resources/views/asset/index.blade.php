@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-10">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-poppins font-bold text-gray-800">Manajemen Aset IT</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data inventaris perangkat IT Pengadilan Negeri Bale Bandung</p>
        </div>
        <div>
            <a href="{{ route('assets.create') }}" class="inline-flex items-center justify-center w-full md:w-auto gap-2 px-5 py-2.5 bg-gradient-to-r from-[#0f4c3a] to-emerald-600 hover:from-[#0a3629] hover:to-emerald-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-lg leading-none"></i>
                Tambah Aset
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3 animate-[fade-in_0.5s_ease-out]">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex shrink-0 items-center justify-center text-emerald-600">
            <i class="bi bi-check-circle-fill text-lg"></i>
        </div>
        <p class="font-semibold text-sm m-0">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-blue-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -z-10 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Aset</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $assets->count() ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl border border-blue-100 shadow-sm shrink-0">
                    <i class="bi bi-pc-display"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-emerald-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-emerald-50 to-transparent rounded-bl-full -z-10 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kondisi Baik</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $assets->where('status', 'active')->count() ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl border border-emerald-100 shadow-sm shrink-0">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-amber-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-transparent rounded-bl-full -z-10 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Maintenance</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $assets->where('status', 'maintenance')->count() ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl border border-amber-100 shadow-sm shrink-0">
                    <i class="bi bi-tools"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-red-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-transparent rounded-bl-full -z-10 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Rusak / Ganti</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $assets->where('status', 'broken')->count() ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl border border-red-100 shadow-sm shrink-0">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)] overflow-hidden">
        
        <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white gap-4">
            <h3 class="text-sm font-bold text-gray-700">Daftar Perangkat IT</h3>
            
            <form action="{{ route('assets.index') }}" method="GET" class="relative block w-full sm:w-auto m-0">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama atau kode..." 
                       class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 w-full sm:w-64 transition-all">
                <button type="submit" class="hidden"></button>
            </form>
        </div>

        <div class="hidden md:block overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-max">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Kode Aset</th>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Nama Perangkat</th>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Kategori</th>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Lokasi</th>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">Status</th>
                        <th class="px-5 sm:px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($assets as $asset)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-800 bg-gray-100 px-2.5 py-1 rounded-md border border-gray-200">{{ $asset->asset_code }}</span>
                        </td>
                        <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-semibold text-gray-800">{{ $asset->asset_name }}</p>
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $asset->category->name ?? '-' }}
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $asset->location }}
                        </td>
                        <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                            @if($asset->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Aktif
                                </span>
                            @elseif($asset->status == 'maintenance')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Perbaikan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                    Rusak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1 sm:opacity-80 sm:group-hover:opacity-100 transition-opacity">
                                
                                <a href="{{ route('assets.evaluate', $asset->id) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-50 hover:text-purple-700 transition-colors tooltip" title="Nilai Kelayakan (SPK)">
                                    <i class="bi bi-star-fill text-[15px]"></i>
                                </a>

                                <a href="{{ route('assets.show', $asset->id) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition-colors tooltip" title="Detail">
                                    <i class="bi bi-eye text-[15px]"></i>
                                </a>
                                
                                <a href="{{ route('assets.edit', $asset->id) }}" class="w-8 h-8 rounded-full flex items-center justify-center text-amber-600 hover:bg-amber-50 hover:text-amber-700 transition-colors tooltip" title="Edit">
                                    <i class="bi bi-pencil-square text-[15px]"></i>
                                </a>
                                
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus aset ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors tooltip" title="Hapus Data">
                                        <i class="bi bi-trash text-[15px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                                    <i class="bi bi-inbox text-2xl text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Belum ada data aset yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>

        <div class="block md:hidden divide-y divide-gray-100 w-full">
            @forelse($assets as $asset)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start mb-2 gap-2">
                    <span class="text-xs font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded-md border border-gray-200">{{ $asset->asset_code }}</span>
                    <div>
                        @if($asset->status == 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span>Aktif
                            </span>
                        @elseif($asset->status == 'maintenance')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1 animate-pulse"></span>Perbaikan
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-600 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1"></span>Rusak
                            </span>
                        @endif
                    </div>
                </div>
                
                <h4 class="text-sm font-bold text-gray-800 mb-2">{{ $asset->asset_name }}</h4>
                
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Kategori</span>
                        <span class="text-xs text-gray-600"><i class="bi bi-tag mr-1 text-gray-400"></i>{{ $asset->category->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</span>
                        <span class="text-xs text-gray-600"><i class="bi bi-geo-alt mr-1 text-gray-400"></i>{{ $asset->location }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-50">
                    <a href="{{ route('assets.evaluate', $asset->id) }}" class="flex-1 text-center py-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors text-xs font-medium">
                        <i class="bi bi-star-fill mr-1"></i> Nilai
                    </a>
                    <a href="{{ route('assets.show', $asset->id) }}" class="w-9 h-9 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                        <i class="bi bi-eye text-[15px]"></i>
                    </a>
                    <a href="{{ route('assets.edit', $asset->id) }}" class="w-9 h-9 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors">
                        <i class="bi bi-pencil-square text-[15px]"></i>
                    </a>
                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus aset ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                            <i class="bi bi-trash text-[15px]"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center">
                <div class="flex flex-col items-center justify-center text-gray-400">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2 border border-gray-100">
                        <i class="bi bi-inbox text-xl text-gray-300"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Belum ada data aset yang ditambahkan.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="px-5 sm:px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            @if(method_exists($assets, 'links'))
                <div class="overflow-x-auto">
                    {{ $assets->withQueryString()->links() }}
                </div>
            @else
                <span class="text-xs text-gray-500">Menampilkan seluruh data aset.</span>
            @endif
        </div>

    </div>
</div>
@endsection