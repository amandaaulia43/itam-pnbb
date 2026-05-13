@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    /* Membungkus seluruh konten dengan font Poppins */
    .poppins-font {
        font-family: 'Poppins', sans-serif;
    }
</style>

<div class="poppins-font">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Dashboard Overview</h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Ringkasan inventaris perangkat IT Pengadilan Negeri Bale Bandung</p>
        </div>
        <div>
            <a href="{{ route('laporan.pimpinan_pdf') }}" class="bg-[#0f4c3a] hover:bg-[#0c3e2f] text-white font-bold py-2.5 px-5 rounded-xl shadow-sm inline-flex items-center transition-all hover:shadow-md text-sm">
                <i class="bi bi-file-earmark-pdf-fill mr-2 text-lg text-red-400"></i>
                Cetak Laporan Pimpinan
            </a>
        </div>
    </div>

    @if(isset($mendesakCount) && $mendesakCount > 0)
    <div onclick="window.location.href='{{ route('spk.index') }}'" class="mb-8 bg-gradient-to-r from-red-50 to-white border border-red-100 rounded-2xl p-5 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between shadow-[0_4px_15px_rgba(239,68,68,0.05)] cursor-pointer group hover:border-red-200 hover:shadow-[0_4px_20px_rgba(239,68,68,0.1)] transition-all duration-300">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center text-red-500 group-hover:scale-110 group-hover:bg-red-500 group-hover:text-white transition-all duration-300 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill text-2xl"></i>
            </div>
            <div>
                <h4 class="text-red-600 font-bold text-lg md:text-xl mb-1 tracking-tight">Perhatian: {{ $mendesakCount }} Aset Sangat Mendesak!</h4>
                <p class="text-gray-500 text-sm font-medium m-0">Sistem SPK mendeteksi ada perangkat yang kondisinya sangat kritis dan butuh penggantian segera.</p>
            </div>
        </div>
        <div class="w-full md:w-auto flex items-center justify-center text-red-600 font-bold text-sm bg-white border border-red-100 px-5 py-2.5 rounded-xl shadow-sm group-hover:bg-red-50 group-hover:pr-4 transition-all duration-300">
            Lihat Rekomendasi <i class="bi bi-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </div>
    </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Total Perangkat</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $totalAssets }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100/50">
                <i class="bi bi-pc-display text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Kondisi Baik</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $activeAssets }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100/50">
                <i class="bi bi-check-circle-fill text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Perbaikan</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $maintenanceAssets }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100/50">
                <i class="bi bi-tools text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between transition-all duration-300 hover:shadow-[0_8px_20px_rgba(0,0,0,0.06)] hover:-translate-y-1">
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1.5">Rusak</p>
                <h3 class="text-3xl font-bold text-gray-800 leading-none">{{ $brokenAssets }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 border border-red-100/50">
                <i class="bi bi-x-circle-fill text-xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6 md:p-8">
            <h3 class="text-base font-bold text-gray-800 mb-6">Komposisi Kondisi Aset</h3>
            <div class="relative h-64 w-full">
                <canvas id="assetChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6 md:p-8 flex flex-col">
            <h3 class="text-base font-bold text-gray-800 mb-6">Baru Ditambahkan</h3>
            
            <ul class="flex-1 space-y-4">
                @forelse($recentAssets as $recent)
                <li class="flex items-center justify-between bg-gray-50/50 p-3 rounded-xl border border-gray-50 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="bg-white rounded-lg p-2.5 shadow-sm border border-gray-100 text-gray-500">
                            <i class="bi bi-pc-display"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800 mb-0.5">{{ $recent->asset_name }}</p>
                            <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">{{ $recent->asset_code }}</p>
                        </div>
                    </div>
                    
                    @if($recent->status == 'active')
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                    @elseif($recent->status == 'maintenance')
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-amber-50 text-amber-600 border border-amber-100">Maintenance</span>
                    @else
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-red-50 text-red-600 border border-red-100">Rusak</span>
                    @endif
                </li>
                @empty
                <li class="py-8 text-center flex flex-col items-center justify-center text-gray-400">
                    <i class="bi bi-inbox text-3xl mb-2 text-gray-300"></i>
                    <span class="text-sm font-medium">Belum ada aset baru.</span>
                </li>
                @endforelse
            </ul>

            <a href="{{ route('assets.index') }}" class="block w-full text-center mt-6 py-2.5 rounded-xl text-sm text-[#0f4c3a] font-bold hover:bg-[#0f4c3a]/5 transition-colors">
                Lihat Semua Aset &rarr;
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Memaksa Chart.js menggunakan font Poppins
    Chart.defaults.font.family = "'Poppins', sans-serif";

    const ctx = document.getElementById('assetChart').getContext('2d');
    const assetChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Kondisi Baik', 'Dalam Perbaikan', 'Rusak Total'],
            datasets: [{
                label: 'Jumlah Perangkat',
                data: [{{ $activeAssets }}, {{ $maintenanceAssets }}, {{ $brokenAssets }}],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // Emerald
                    'rgba(245, 158, 11, 0.8)', // Amber
                    'rgba(239, 68, 68, 0.8)'   // Red
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 0, 
                borderRadius: 6, 
                barThickness: 45 // Lebar bar
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    ticks: { precision: 0, color: '#9ca3af', font: { weight: '500' } },
                    grid: { color: '#f3f4f6', drawBorder: false }
                },
                x: {
                    ticks: { color: '#6b7280', font: { weight: '500' } },
                    grid: { display: false, drawBorder: false }
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: 'bold' }
                }
            }
        }
    });
</script>
@endsection