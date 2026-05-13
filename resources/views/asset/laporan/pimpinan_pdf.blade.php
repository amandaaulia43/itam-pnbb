<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset IT - Pimpinan</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #333; }
        .header { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; float: left; }
        .kop-surat { text-align: center; margin-left: 90px; }
        .kop-surat h1 { font-size: 16pt; margin: 0; uppercase; }
        .kop-surat h2 { font-size: 14pt; margin: 0; }
        .kop-surat p { font-size: 10pt; margin: 5px 0 0 0; }
        .clearfix { clear: both; }
        
        .judul-laporan { text-align: center; margin: 20px 0; }
        .judul-laporan h3 { text-decoration: underline; margin: 0; }
        
        .section-title { background: #f2f2f2; padding: 5px 10px; font-weight: bold; margin-top: 20px; border: 1px solid #ddd; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th { background-color: #f2f2f2; padding: 8px; font-size: 11pt; }
        td { padding: 8px; font-size: 11pt; vertical-align: top; }
        .text-center { text-align: center; }
        
        .badge { padding: 2px 5px; font-size: 9pt; font-weight: bold; text-transform: uppercase; }
        
        .footer { margin-top: 50px; }
        .ttd { float: right; width: 250px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Logo_Mahkamah_Agung_RI.png/150px-Logo_Mahkamah_Agung_RI.png" class="logo">
        <div class="kop-surat">
            <h1>PENGADILAN NEGERI BALE BANDUNG</h1>
            <h2>KELAS 1A KHUSUS</h2>
            <p>Jl. Jaksa Naranata No. 11, Baleendah, Bandung, Jawa Barat</p>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="judul-laporan">
        <h3>LAPORAN EKSEKUTIF KONDISI ASET IT</h3>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <div class="section-title">I. RINGKASAN STATUS PERANGKAT</div>
    <table>
        <thead>
            <tr>
                <th>Total Aset</th>
                <th>Aktif / Normal</th>
                <th>Maintenance</th>
                <th>Rusak Berat</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td style="font-size: 18pt; font-weight: bold;">{{ $totalAset }}</td>
                <td style="color: green; font-size: 18pt; font-weight: bold;">{{ $asetAktif }}</td>
                <td style="color: orange; font-size: 18pt; font-weight: bold;">{{ $asetMaintenance }}</td>
                <td style="color: red; font-size: 18pt; font-weight: bold;">{{ $asetRusak }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">II. ASET DENGAN FREKUENSI KERUSAKAN TERTINGGI</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Perangkat</th>
                <th>Kode Aset</th>
                <th>Jumlah Perbaikan</th>
                <th>Status Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asetSeringRusak as $index => $aset)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $aset->asset_name }}</td>
                <td class="text-center">{{ $aset->asset_code }}</td>
                <td class="text-center">{{ $aset->maintenances_count }} Kali</td>
                <td class="text-center">{{ strtoupper($aset->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">III. ANALISA KERUSAKAN TERKINI (TRENDING ISSUES)</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Tanggal</th>
                <th>Nama Aset</th>
                <th>Keluhan / Masalah</th>
                <th>Tindakan Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trenKerusakan as $index => $m)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($m->maintenance_date)->format('d/m/y') }}</td>
                <td>{{ $m->asset->asset_name }}</td>
                <td>{{ $m->description }}</td>
                <td>{{ $m->action_taken }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Baleendah, {{ date('d F Y') }}</p>
            <p>Mengetahui,<br>Kepala Sub Bagian PTIP</p>
            <br><br><br>
            <p><strong>( ........................................ )</strong><br>NIP. ...................................</p>
        </div>
        <div class="clearfix"></div>
    </div>

</body>
</html>