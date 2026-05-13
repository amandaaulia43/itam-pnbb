<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Label Aset - {{ $asset->asset_code }}</title>
    <style>
        body { 
            font-family: Helvetica, Arial, sans-serif; 
        }
        .label-card {
            width: 300px;
            border: 2px solid #0f4c3a;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 0 auto;
        }
        .header {
            background-color: #0f4c3a;
            color: white;
            font-weight: bold;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .qr-container {
            margin-bottom: 15px;
        }
        .asset-code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #0f4c3a;
            margin-bottom: 5px;
        }
        .asset-name {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .asset-sn {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="label-card">
        <div class="header">ASET IT - PN BALE BANDUNG</div>
        
        <div class="qr-container">
            <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" width="150" height="150" alt="QR Code">
        </div>
        
        <div class="asset-code">{{ $asset->asset_code }}</div>
        <div class="asset-name">{{ $asset->asset_name }}</div>
        <div class="asset-sn">SN: {{ $asset->serial_number ?? '-' }}</div>
    </div>

</body>
</html>