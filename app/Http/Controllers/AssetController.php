<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImport;
use App\Exports\AssetExport;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Category; 
use App\Models\Maintenance; // <-- Tambahan Model Maintenance
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf; 

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asset_name', 'like', '%' . $search . '%')
                  ->orWhere('asset_code', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        $assets = $query->paginate(10);
        return view('asset.index', compact('assets'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('asset.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_name'  => 'required',
            'category_id' => 'required',
            'location'    => 'required',
            'item_status' => 'required',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'serial_number_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('assets_photos', 'public');
        }

        $serialPhotoPath = null;
        if ($request->hasFile('serial_number_photo')) {
            $serialPhotoPath = $request->file('serial_number_photo')->store('assets_photos/serial_numbers', 'public');
        }

        $assetCode = 'ITAM-' . strtoupper(Str::random(5));

        Asset::create([
            'uuid'                => Str::uuid(), 
            'asset_code'          => $assetCode, 
            'asset_name'          => $request->asset_name,
            'category_id'         => $request->category_id,
            'serial_number'       => $request->serial_number,
            'location'            => $request->location,
            'item_status'         => $request->item_status,
            'status'              => $request->status ?? 'active',
            'purchase_date'       => $request->purchase_date,
            'purchase_price'      => $request->purchase_price,
            'photo'               => $photoPath,
            'serial_number_photo' => $serialPhotoPath
        ]);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan!');
    }

    public function show($id)
    {
        $asset = Asset::with(['category', 'maintenances'])->findOrFail($id);
        $qrCode = QrCode::size(150)->generate(route('assets.public_show', $asset->id));
        
        return view('asset.show', compact('asset', 'qrCode'));
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $categories = Category::all();
        return view('asset.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_name'  => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location'    => 'required|string|max:255',
            'item_status' => 'required',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'serial_number_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $asset = Asset::findOrFail($id);
        
        $photoPath = $asset->photo; 
        if ($request->hasFile('photo')) {
            if ($asset->photo) Storage::disk('public')->delete($asset->photo);
            $photoPath = $request->file('photo')->store('assets_photos', 'public');
        }

        $serialPhotoPath = $asset->serial_number_photo;
        if ($request->hasFile('serial_number_photo')) {
            if ($asset->serial_number_photo) Storage::disk('public')->delete($asset->serial_number_photo);
            $serialPhotoPath = $request->file('serial_number_photo')->store('assets_photos/serial_numbers', 'public');
        }
        
        $asset->update([
            'asset_name'          => $request->asset_name,
            'category_id'         => $request->category_id,
            'serial_number'       => $request->serial_number,
            'location'            => $request->location,
            'item_status'         => $request->item_status,
            'status'              => $request->status,
            'purchase_date'       => $request->purchase_date,
            'purchase_price'      => $request->purchase_price,
            'photo'               => $photoPath,
            'serial_number_photo' => $serialPhotoPath
        ]);

        return redirect()->route('assets.show', $asset->id)->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->photo) Storage::disk('public')->delete($asset->photo);
        if ($asset->serial_number_photo) Storage::disk('public')->delete($asset->serial_number_photo);
        
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus!');
    }

    public function downloadPdf($id)
    {
        $asset = Asset::findOrFail($id);
        $qrCode = base64_encode(QrCode::format('svg')->size(150)->errorCorrection('H')->generate(route('assets.public_show', $asset->id)));
        
        $pdf = Pdf::loadView('asset.pdf', compact('asset', 'qrCode'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Label-QR-'.$asset->asset_code.'.pdf');
    }

    public function markAsReplaced($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->kondisi_penggantian = 'Sudah Diganti'; 
        $asset->save();

        return redirect()->route('spk.index')->with('success', 'Aset ' . $asset->asset_name . ' telah berhasil diperbarui dan dikeluarkan dari daftar prioritas.');
    }

    public function publicShow($id)
    {
        $asset = Asset::with(['category', 'maintenances' => function($q) {
            $q->latest();
        }])->findOrFail($id);
        
        return view('public_show', compact('asset'));
    }

    public function printMassQr()
    {
        $assets = Asset::all();
        $pdf = Pdf::loadView('assets.mass_qr', compact('assets'));
        return $pdf->stream('Mass-QR-Codes.pdf');
    }

    // ====================================================================
    // --- FITUR BARU: MENERIMA LAPORAN KERUSAKAN DARI STAFF (PUBLIK) ---
    // ====================================================================
    public function reportIssue(Request $request, $id)
    {
        $request->validate([
            'reporter_name' => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        $asset = Asset::findOrFail($id);
        
        // Masukkan laporan ke tabel Riwayat Perbaikan (Maintenances)
        $laporan = new \App\Models\Maintenance();
        $laporan->asset_id = $asset->id;
        $laporan->maintenance_date = now(); 
        $laporan->description = "TICKETING LAPORAN MASUK | Dari: " . strtoupper($request->reporter_name) . " | Ruangan: " . strtoupper($request->location) . " | Keluhan: " . $request->description;
        
        // Beri flag 'PENDING' agar mudah difilter di halaman Laporan Masuk
        $laporan->action_taken = 'PENDING - Menunggu Pengecekan Admin'; 
        $laporan->technician_name = '-';
        $laporan->save();

        // KIRIM NOTIFIKASI WA VIA FONNTE
        $token = env('FONNTE_TOKEN');
        $target = env('ADMIN_WHATSAPP');
        
        if ($token && $target) {
            $message = "*🚨 TICKETING LAPORAN BARU 🚨*\n\n";
            $message .= "Sistem mendeteksi ada laporan kerusakan baru dari pengguna:\n\n";
            $message .= "👤 *Pelapor:* " . strtoupper($request->reporter_name) . "\n";
            $message .= "💻 *Perangkat:* " . $asset->asset_name . " (" . $asset->asset_code . ")\n";
            $message .= "📍 *Ruangan:* " . strtoupper($request->location) . "\n";
            $message .= "📝 *Keluhan:* " . $request->description . "\n\n";
            $message .= "Mohon segera cek dashboard admin (Menu Laporan Masuk) untuk tindak lanjut.";

            try {
                Http::withoutVerifying()->withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62', 
                ]);
            } catch (\Exception $e) {
                Log::error('Fonnte WA Error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Laporan berhasil terkirim! Teknisi kami akan segera mengecek laporan Anda.');
    }

    // ====================================================================
    // --- FITUR BARU: CETAK LAPORAN PDF UNTUK PIMPINAN ---
    // ====================================================================
    public function downloadLaporanPimpinan()
    {
        // 1. Statistik Dasar
        $data['totalAset'] = Asset::count();
        $data['asetAktif'] = Asset::where('status', 'active')->count();
        $data['asetRusak'] = Asset::where('status', 'broken')->count();
        $data['asetMaintenance'] = Asset::where('status', 'maintenance')->count();

        // 2. Aset yang Paling Sering Rusak (Top 5)
        $data['asetSeringRusak'] = Asset::withCount('maintenances')
            ->having('maintenances_count', '>', 0)
            ->orderBy('maintenances_count', 'desc')
            ->take(5)
            ->get();

        // 3. Alasan Kerusakan/Tindakan yang Sering Terjadi (Tren 10 Terakhir)
        $data['trenKerusakan'] = Maintenance::with('asset')
            ->whereNotNull('action_taken')
            ->orderBy('maintenance_date', 'desc')
            ->take(10)
            ->get();

        // Load View dan Jadikan PDF
        $pdf = Pdf::loadView('asset.laporan.pimpinan_pdf', $data)
                  ->setPaper('a4', 'portrait');

        // Download otomatis
        return $pdf->download('Laporan_Eksekutif_Aset_IT_'.date('Y-m-d').'.pdf');
    }
    // Fungsi untuk Download Excel
    public function exportExcel()
    {
        return Excel::download(new AssetExport, 'template_data_aset.xlsx');
    }

    // Fungsi untuk Upload & Proses Import Excel
    public function importExcel(Request $request)
    {
        // Pastikan user mengupload file dengan format yang benar
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048' // Maksimal ukuran 2MB
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu!',
            'file_excel.mimes' => 'Format file harus .xlsx, .xls, atau .csv!'
        ]);

        try {
            // Jalankan proses import
            Excel::import(new AssetImport, $request->file('file_excel'));
            
            return redirect()->back()->with('success', 'Hore! Data Aset berhasil di-import.');

        } catch (ValidationException $e) {
            // Tangkap pesan error kalau ada data Excel yang salah/kosong
            $failures = $e->failures();
            $errorRow = $failures[0]->row(); // Baris ke berapa yang salah
            $errorMessage = $failures[0]->errors()[0]; // Pesan errornya apa
            
            return redirect()->back()->with('error', "Gagal di Baris Excel ke-{$errorRow}: {$errorMessage}");
            
        } catch (\Exception $e) {
            // Tangkap error sistem lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}