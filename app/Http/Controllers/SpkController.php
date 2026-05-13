<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Criterion;
use Barryvdh\DomPDF\Facade\Pdf;

class SpkController extends Controller
{
    public function index()
    {
        $rankings = $this->getRankings();
        return view('spk.index', compact('rankings'));
    }

    public function downloadPdf(Request $request)
    {
        $rankings = $this->getRankings();

        if (empty($rankings)) {
            return redirect()->back()->with('error', 'Belum ada data evaluasi untuk dicetak.');
        }

        $pdf = Pdf::loadView('spk.pdf', compact('rankings'));
        $pdf->setPaper('A4', 'portrait');
        
        // Cek apakah user klik tombol download langsung atau cuma mau preview
        if ($request->has('download')) {
            return $pdf->download('Laporan_Hasil_SPK_Penggantian_Aset.pdf');
        }

        // Default: Stream (untuk preview di dalam pop-up iframe)
        return $pdf->stream('Laporan_Hasil_SPK_Penggantian_Aset.pdf');
    }

    // UBAH KE PUBLIC agar bisa dipanggil dari web.php
    public function getRankings()
    {
        // 1. Ambil evaluasi yang punya aset DAN aset tersebut belum diganti
        $evaluations = Evaluation::whereHas('asset', function($query) {
            $query->where('kondisi_penggantian', '!=', 'Sudah Diganti');
        })->with('asset')->get();
        
        // 2. Ambil kriteria, pastikan code sesuai C1-C5
        $criteria = Criterion::all()->keyBy('code');

        // Jika data evaluasi kosong atau kriteria belum diatur (kurang dari 5), balikkan array kosong
        if ($evaluations->isEmpty() || $criteria->count() < 5) {
            return [];
        }

        // 3. Cari nilai Max/Min untuk normalisasi
        $maxC1 = $evaluations->max('c1') ?: 1;
        $maxC2 = $evaluations->max('c2') ?: 1;
        $maxC3 = $evaluations->max('c3') ?: 1;
        $maxC4 = $evaluations->max('c4') ?: 1;
        
        // Penting: Untuk Cost (C5), cari nilai minimal yang di atas 0
        $minC5 = $evaluations->where('c5', '>', 0)->min('c5') ?: 1;

        $rankings = [];

        foreach ($evaluations as $eval) {
            // A. Proses Normalisasi SAW
            $normC1 = $eval->c1 / $maxC1;
            $normC2 = $eval->c2 / $maxC2;
            $normC3 = $eval->c3 / $maxC3;
            $normC4 = $eval->c4 / $maxC4;
            
            // Rumus Cost: Min / Nilai
            $normC5 = $eval->c5 > 0 ? $minC5 / $eval->c5 : 0;

            // B. Hitung Nilai Preferensi (V)
            $score = ($normC1 * ($criteria['C1']->weight ?? 0)) +
                     ($normC2 * ($criteria['C2']->weight ?? 0)) +
                     ($normC3 * ($criteria['C3']->weight ?? 0)) +
                     ($normC4 * ($criteria['C4']->weight ?? 0)) +
                     ($normC5 * ($criteria['C5']->weight ?? 0));

            $rankings[] = (object)[
                'asset' => $eval->asset,
                'c1' => $eval->c1,
                'c2' => $eval->c2,
                'c3' => $eval->c3,
                'c4' => $eval->c4,
                'c5' => $eval->c5,
                'score' => (float) $score
            ];
        }

        // 4. Urutkan dari skor tertinggi
        usort($rankings, function($a, $b) {
            return $b->score <=> $a->score;
        });

        return $rankings;
    }
}