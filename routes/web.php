<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SpkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. ROUTE PUBLIK (Bisa diakses tanpa Login)
// ==========================================

Route::get('/', function (Request $request) {
    $search = $request->input('search');
    $tab = $request->input('tab', 'operasional'); 
    
    $totalAssets = Asset::count();
    $countOperasional = Asset::where('status', 'active')->count();
    $countPerbaikan = Asset::whereIn('status', ['maintenance', 'broken'])->count();

    $query = Asset::with('category')->latest();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('asset_name', 'like', '%' . $search . '%')
              ->orWhere('asset_code', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%');
        });
    }

    if ($tab == 'operasional') {
        $query->where('status', 'active');
    } elseif ($tab == 'perbaikan') {
        $query->whereIn('status', ['maintenance', 'broken']);
    }

    $assets = $query->paginate(10)->appends(['search' => $search, 'tab' => $tab]);

    return view('landing', compact('assets', 'search', 'tab', 'totalAssets', 'countOperasional', 'countPerbaikan'));
})->name('landing');

Route::get('/asset-info/{id}', [AssetController::class, 'publicShow'])->name('assets.public_show');
Route::post('/asset-report/{id}', [AssetController::class, 'reportIssue'])->name('assets.report_issue');
Route::get('/asset/{id}/pdf', [AssetController::class, 'downloadPdf'])->name('asset.pdf');


// ==========================================
// 2. ROUTE AUTENTIKASI (Login & Logout)
// ==========================================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. ROUTE ADMIN (Digembok, Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        $totalAssets = Asset::count();
        $activeAssets = Asset::where('status', 'active')->count();
        $maintenanceAssets = Asset::where('status', 'maintenance')->count();
        $brokenAssets = Asset::where('status', 'broken')->count();
        
        $recentAssets = Asset::with('category')->latest()->take(5)->get();

        $spkController = app(\App\Http\Controllers\SpkController::class);
        $rankings = $spkController->getRankings();
        $mendesakCount = count($rankings); 

        $newReports = Asset::where('status', 'broken')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalAssets', 'activeAssets', 'maintenanceAssets', 'brokenAssets', 'recentAssets', 'mendesakCount', 'newReports'
        ));
    })->name('dashboard');

    Route::resource('assets', AssetController::class)->except(['show']);
    Route::get('/assets/{id}', [AssetController::class, 'show'])->name('assets.show'); 
    
    Route::post('/assets/{id}/mark-as-replaced', [AssetController::class, 'markAsReplaced'])->name('assets.markAsReplaced');
    Route::get('/assets-mass-qr', [AssetController::class, 'printMassQr'])->name('assets.mass-qr');

    // ========================================================
    // FITUR CETAK LAPORAN PIMPINAN (PDF)
    // ========================================================
    Route::get('/laporan-pimpinan-pdf', [AssetController::class, 'downloadLaporanPimpinan'])->name('laporan.pimpinan_pdf');

    // ========================================================
    // MENU LAPORAN MASUK & TICKETING
    // ========================================================
    Route::get('/laporan-masuk', [MaintenanceController::class, 'laporanMasuk'])->name('maintenances.laporan_masuk');
    Route::get('/laporan-masuk/{id}/proses', [MaintenanceController::class, 'prosesLaporan'])->name('maintenances.proses_laporan');
    Route::post('/laporan-masuk/{id}/proses', [MaintenanceController::class, 'simpanProsesLaporan'])->name('maintenances.simpan_proses_laporan');

    // ========================================================
    // Pencatatan & Riwayat Maintenance
    // ========================================================
    Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/export-pdf', [MaintenanceController::class, 'exportPdf'])->name('maintenances.export-pdf');
    Route::get('/asset/{id}/maintenance/create', [MaintenanceController::class, 'create'])->name('assets.maintenance.create');
    Route::post('/asset/{id}/maintenance', [MaintenanceController::class, 'store'])->name('assets.maintenance.store');
    
    Route::get('/maintenances/{id}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::put('/maintenances/{id}', [MaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('/maintenances/{id}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');

    Route::get('/assets/{id}/download-pdf', [AssetController::class, 'downloadPdf'])->name('assets.download-pdf');
    
    Route::get('/asset/{id}/evaluate', [EvaluationController::class, 'evaluate'])->name('assets.evaluate');
    Route::post('/asset/{id}/evaluate', [EvaluationController::class, 'storeEvaluation'])->name('assets.store_evaluate');

    Route::get('/spk-ranking', [SpkController::class, 'index'])->name('spk.index');
    Route::get('/spk-ranking/download-pdf', [SpkController::class, 'downloadPdf'])->name('spk.download-pdf');

    Route::get('/scan-qr', function () {
        return view('scanner');
    })->name('scan.index');
});