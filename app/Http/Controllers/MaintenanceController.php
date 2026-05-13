<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceController extends Controller
{
    // ====================================================================
    // --- FITUR BARU: MANAJEMEN LAPORAN MASUK DARI PUBLIK ---
    // ====================================================================
    
    // A. Menampilkan Daftar Laporan Masuk (Status PENDING)
    public function laporanMasuk(Request $request)
    {
        $search = $request->input('search');

        $laporanMasuk = Maintenance::with('asset')
            ->where('action_taken', 'PENDING - Menunggu Pengecekan Admin')
            ->when($search, function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%")
                      ->orWhereHas('asset', function ($q) use ($search) {
                          $q->where('asset_name', 'like', "%{$search}%")
                            ->orWhere('asset_code', 'like', "%{$search}%");
                      });
            })
            ->orderBy('maintenance_date', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        // Nanti kamu perlu buat view ini: resources/views/asset/maintenance/laporan_masuk.blade.php
        return view('asset.maintenance.laporan_masuk', compact('laporanMasuk', 'search'));
    }

    // B. Menampilkan Form untuk Admin Memproses Laporan Masuk
    public function prosesLaporan($id)
    {
        $laporan = Maintenance::with('asset')->findOrFail($id);
        
        // Nanti kamu perlu buat view ini: resources/views/asset/maintenance/proses_laporan.blade.php
        return view('asset.maintenance.proses_laporan', compact('laporan'));
    }

    // C. Menyimpan Keputusan Admin (Tentukan Teknisi & Update Status Aset)
    public function simpanProsesLaporan(Request $request, $id)
    {
        $laporan = Maintenance::findOrFail($id);
        $asset = Asset::findOrFail($laporan->asset_id);

        $request->validate([
            'technician_name'  => 'required|string|max:255',
            'action_taken'     => 'required|string', // Admin mengisi apa tindakannya (Misal: Sedang dicek)
            'repair_cost'      => 'nullable|numeric',
            'asset_status'     => 'required|in:active,maintenance,broken', // Admin menentukan status aset
        ]);

        // Update laporan agar tidak PENDING lagi
        $laporan->update([
            'technician_name'  => $request->technician_name,
            'action_taken'     => $request->action_taken,
            'repair_cost'      => $request->repair_cost,
        ]);

        // Update status aset sesuai keputusan admin
        $asset->update([
            'status' => $request->asset_status
        ]);

        return redirect()->route('maintenances.laporan_masuk')
                         ->with('success', 'Laporan berhasil diproses! Data otomatis masuk ke Riwayat Maintenance.');
    }


    // ====================================================================
    // --- RIWAYAT MAINTENANCE REGULER ---
    // ====================================================================

    public function index(Request $request)
    {
        $search = $request->input('search');

        $maintenances = Maintenance::with('asset')
            ->where('action_taken', '!=', 'PENDING - Menunggu Pengecekan Admin') // Sembunyikan yg masih PENDING
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('technician_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('asset', function ($sq) use ($search) {
                          $sq->where('asset_name', 'like', "%{$search}%")
                             ->orWhere('asset_code', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('maintenance_date', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]); 
        
        return view('asset.maintenance.index', compact('maintenances', 'search'));
    }

    public function exportPdf(Request $request)
    {
        $search = $request->input('search');

        $maintenances = Maintenance::with('asset')
            ->where('action_taken', '!=', 'PENDING - Menunggu Pengecekan Admin') // Sembunyikan yg masih PENDING
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('technician_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('asset', function ($sq) use ($search) {
                          $sq->where('asset_name', 'like', "%{$search}%")
                             ->orWhere('asset_code', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('maintenance_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('asset.maintenance.pdf', compact('maintenances', 'search'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Riwayat_Maintenance_PNBB.pdf');
    }

    public function create($id)
    {
        $asset = Asset::findOrFail($id);
        return view('asset.maintenance.create', compact('asset'));
    }

    public function store(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'maintenance_date' => 'required|date',
            'technician_name'  => 'required|string|max:255',
            'action_taken'     => 'required|string',
            'repair_cost'      => 'nullable|numeric',
            'description'      => 'required|string',
            'asset_status'     => 'required|in:active,maintenance,broken',
        ]);

        Maintenance::create([
            'asset_id'         => $asset->id,
            'maintenance_date' => $request->maintenance_date,
            'technician_name'  => $request->technician_name,
            'action_taken'     => $request->action_taken,
            'repair_cost'      => $request->repair_cost,
            'description'      => $request->description,
        ]);

        $asset->update([
            'status' => $request->asset_status
        ]);

        return redirect()->route('assets.show', $asset->id)
                         ->with('success', 'Riwayat perbaikan berhasil dicatat dan status aset diperbarui!');
    }

    public function edit($id)
    {
        $maintenance = Maintenance::with('asset')->findOrFail($id);
        return view('asset.maintenance.edit_maintenance', compact('maintenance'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $request->validate([
            'maintenance_date' => 'required|date',
            'technician_name'  => 'required|string|max:255',
            'action_taken'     => 'required|string',
            'repair_cost'      => 'nullable|numeric',
            'description'      => 'required|string',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('maintenances.index')
                         ->with('success', 'Data riwayat perbaikan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('maintenances.index')
                         ->with('success', 'Data riwayat perbaikan telah dihapus!');
    }
}