<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criterion;

class CriterionSeeder extends Seeder
{
    public function run()
    {
        $criteria = [
            ['code' => 'C1', 'name' => 'Kondisi Fisik & Fungsi', 'type' => 'benefit', 'weight' => 0.30],
            ['code' => 'C2', 'name' => 'Umur Ekonomis Aset', 'type' => 'benefit', 'weight' => 0.25],
            ['code' => 'C3', 'name' => 'Frekuensi Kerusakan', 'type' => 'benefit', 'weight' => 0.20],
            ['code' => 'C4', 'name' => 'Tingkat Kepentingan (Urgensi)', 'type' => 'benefit', 'weight' => 0.15],
            ['code' => 'C5', 'name' => 'Estimasi Harga Penggantian', 'type' => 'cost', 'weight' => 0.10],
        ];

        foreach ($criteria as $item) {
            Criterion::create($item);
        }
    }
}