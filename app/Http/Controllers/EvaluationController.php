<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Evaluation;
use App\Models\Maintenance;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    public function evaluate($id)
    {
        $asset = Asset::findOrFail($id);
        $evaluation = Evaluation::where('asset_id', $id)->first();
        
        // --- 1. OTOMATISASI C2 (Umur Ekonomis) ---
        $autoC2 = null;
        if ($asset->purchase_date) {
            $ageInYears = Carbon::parse($asset->purchase_date)->age;
            if ($ageInYears > 5) $autoC2 = 5;
            elseif ($ageInYears >= 4) $autoC2 = 4;
            elseif ($ageInYears >= 3) $autoC2 = 3;
            elseif ($ageInYears >= 1) $autoC2 = 2;
            else $autoC2 = 1;
        }

        // --- 2. OTOMATISASI C3 (Maintenance setahun terakhir) ---
        $maintenanceCount = Maintenance::where('asset_id', $id)
            ->where('maintenance_date', '>=', Carbon::now()->subYear())
            ->count();
            
        $autoC3 = 1; 
        if ($maintenanceCount > 5) $autoC3 = 5;
        elseif ($maintenanceCount >= 4) $autoC3 = 4;
        elseif ($maintenanceCount >= 2) $autoC3 = 3;
        elseif ($maintenanceCount == 1) $autoC3 = 2;

        // --- 3. OTOMATISASI C5 (Estimasi Harga) ---
        $autoC5 = null;
        if ($asset->purchase_price) {
            $price = $asset->purchase_price;
            if ($price < 1000000) $autoC5 = 5;
            elseif ($price <= 3000000) $autoC5 = 4;
            elseif ($price <= 5000000) $autoC5 = 3;
            elseif ($price <= 10000000) $autoC5 = 2;
            else $autoC5 = 1;
        }

        return view('asset.evaluate', compact('asset', 'evaluation', 'autoC2', 'autoC3', 'maintenanceCount', 'autoC5'));
    }

    public function storeEvaluation(Request $request, $id)
    {
        $request->validate([
            'c1' => 'required|integer|between:1,5',
            'c2' => 'required|integer|between:1,5',
            'c3' => 'required|integer|between:1,5',
            'c4' => 'required|integer|between:1,5',
            'c5' => 'required|integer|between:1,5',
        ]);

        Evaluation::updateOrCreate(
            ['asset_id' => $id],
            [
                'c1' => $request->c1,
                'c2' => $request->c2,
                'c3' => $request->c3,
                'c4' => $request->c4,
                'c5' => $request->c5,
            ]
        );

        // Langsung arahkan ke halaman ranking setelah simpan agar user bisa lihat hasilnya
        return redirect()->route('spk.index')->with('success', 'Analisis Kelayakan Aset Berhasil Diperbarui!');
    }
}