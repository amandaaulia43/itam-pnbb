<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil SPK Penggantian Aset</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .header-container {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px double #2d3748;
            padding-bottom: 15px;
        }
        .judul-laporan {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a202c;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .sub-judul {
            font-size: 12px;
            color: #4a5568;
            margin-bottom: 5px;
        }
        .tanggal-cetak {
            font-size: 10px;
            color: #718096;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        /* Mencegah baris tabel terpotong di tengah halaman */
        tr {
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #a0aec0;
            padding: 8px 6px;
            vertical-align: middle;
        }
        th {
            background-color: #edf2f7;
            font-weight: bold;
            text-align: center;
            color: #2d3748;
            text-transform: uppercase;
            font-size: 10px;
        }
        td.tengah {
            text-align: center;
        }
        /* Warna untuk baris ganjil/genap agar mudah dibaca */
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .status-mendesak { color: #c53030; font-weight: bold; }
        .status-waspada { color: #b7791f; font-weight: bold; }
        .status-aman { color: #2f855a; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="judul-laporan">Laporan Prioritas Penggantian Aset IT</div>
        <div class="sub-judul">Sistem Pendukung Keputusan Metode Simple Additive Weighting (SAW)</div>
        <div class="tanggal-cetak">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }} WIB
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">Rnk</th>
                <th width="12%">Kode Aset</th>
                <th width="18%">Nama Perangkat</th>
                <th width="15%">Ruangan / Lokasi</th>
                <th width="10%">Skor (Vi)</th>
                <th width="15%">Rekomendasi</th>
                <th width="25%">Riwayat Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankings as $index => $rank)
            <tr>
                <td class="tengah"><strong>{{ $index + 1 }}</strong></td>
                <td class="tengah"><strong>{{ $rank->asset->asset_code }}</strong></td>
                <td>{{ $rank->asset->asset_name }}</td>
                
                <td class="tengah">{{ $rank->asset->location ?? '-' }}</td>
                
                <td class="tengah"><strong>{{ number_format((float)$rank->score, 3, '.', '') }}</strong></td>
                
                <td class="tengah">
                    @if($rank->score >= 0.8)
                        <span class="status-mendesak">Sangat Mendesak</span>
                    @elseif($rank->score >= 0.6)
                        <span class="status-waspada">Perlu Diganti</span>
                    @else
                        <span class="status-aman">Masih Layak</span>
                    @endif
                </td>

                <td>
                    @php
                        // Menangani relasi maintenance dengan aman
                        $lastMaintenance = null;
                        if($rank->asset->relationLoaded('maintenances') || method_exists($rank->asset, 'maintenances')) {
                            $lastMaintenance = $rank->asset->maintenances->sortByDesc('created_at')->first();
                        }
                        
                        $catatan = '-';
                        if ($lastMaintenance) {
                            $catatan = $lastMaintenance->description ?? $lastMaintenance->notes ?? $lastMaintenance->problem ?? 'Ada riwayat perbaikan.';
                        }
                    @endphp
                    
                    <i style="font-size: 10px; color: #4a5568;">{{ $catatan }}</i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>