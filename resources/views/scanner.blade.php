@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    .poppins-font { font-family: 'Poppins', sans-serif; }
    
    /* Mengubah sedikit tampilan bawaan library scanner biar lebih rapi */
    #reader {
        border-radius: 1rem;
        overflow: hidden;
        border: 2px solid #f3f4f6 !important;
    }
    #reader__dashboard_section_csr span {
        font-family: 'Poppins', sans-serif;
        color: #ef4444;
        font-weight: 600;
    }
    #reader button {
        background-color: #0f4c3a;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }
    #reader button:hover {
        background-color: #0b382a;
    }
</style>

<div class="poppins-font">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Scanner QR Code</h2>
        <p class="text-gray-500 text-sm mt-1 font-medium">Arahkan kamera ke stiker QR Code yang ada di perangkat</p>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6 flex flex-col items-center">
            
            <div id="reader" class="w-full"></div>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 mb-2">Pastikan pencahayaan cukup agar QR Code mudah terbaca.</p>
                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    // Fungsi ini akan dipanggil jika QR code berhasil terbaca
    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner agar tidak scan berkali-kali secara bersamaan
        html5QrcodeScanner.clear();
        
        // Cek apakah hasil scan berupa URL (mengandung http/https)
        if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
            // Arahkan browser ke URL hasil scan (halaman detail aset)
            window.location.href = decodedText;
        } else {
            alert("QR Code tidak valid! Pastikan ini adalah QR Code Aset dari sistem.");
            // Restart scanner (opsional, jika ingin otomatis scan ulang)
            window.location.reload();
        }
    }

    // Fungsi ini jika gagal membaca (diabaikan saja agar tidak muncul pesan error terus-menerus saat mencari QR)
    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
    }

    // Konfigurasi Scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false
    );
    
    // Jalankan scanner
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection