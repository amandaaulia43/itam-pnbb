<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Maintenance ITAM</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11px; 
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #0f4c3a;
            padding-bottom: 10px;
        }
        .header h2 { margin: 0 0 5px 0; color: #0f4c3a; font-size: 18px; }
        .header h3 { margin: 0 0 10px 0; font-size: 14px; font-weight: normal; }
        .filter-info { font-style: italic; color: #666; margin-top: 5px; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px 10px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #0f4c3a; 
            color: white; 
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .w-5 { width: 5%; }
        .w-15 { width: 15%; }
        .w-20 { width: 20%; }
        .w-30 { width: 30%; }
        .w-10 { width: 10%; }
        
        .label { font-weight: bold; font-size: 10px; color: #555; }
        .code { font-weight: bold; color: #0f4c3a; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN RIWAYAT MAINTENANCE ASET IT</h2>
        <h3>PENGADILAN NEGERI BALE BANDUNG</h3>
        @if($search)
            <div class="filter-info">Menampilkan hasil pencarian untuk: <b>"{{ $search }}"</b></div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="w-5">No</th>
                <th class="w-15">Tanggal</th>
                <th class="w-20">Aset IT</th>
                <th class="w-15">Teknisi/Vendor</th>
                <th class="w-30">Rincian Perbaikan</th>
                <th class="w-15">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $index => $history)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($history->maintenance_date)->translatedFormat('d M Y') }}</td>
                <td>
                    <div class="code">{{ $history->asset->asset_code }}</div>
                    <div>{{ $history->asset->asset_name }}</div>
                </td>
                <td>{{ $history->technician_name }}</td>
                <td>
                    <div class="label">KELUHAN:</div>
                    <div style="margin-bottom: 5px;">{{ $history->description }}</div>
                    <div class="label">TINDAKAN:</div>
                    <div>{{ $history->action_taken }}</div>
                </td>
                <td class="text-right">
                    @if($history->repair_cost > 0)
                        Rp {{ number_format($history->repair_cost, 0, ',', '.') }}
                    @else
                        Gratis / Garansi
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px;">Belum ada data riwayat perbaikan yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>