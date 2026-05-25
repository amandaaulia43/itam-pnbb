<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangan = [
            ['name' => 'Ruang PTSP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Sidang Utama', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Mediasi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Posbakum', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kerja Ketua PN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kerja Wakil Ketua PN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Hakim', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kerja Panitera', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kepaniteraan Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kepaniteraan Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kepaniteraan Hukum', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Jurusita / Jurusita Pengganti', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Kerja Sekretaris', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Sub Bagian Umum dan Keuangan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Sub Bagian Kepegawaian & ORTALA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Sub Bagian PTIP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Arsip', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gudang', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Memasukkan seluruh data ruangan ke tabel locations
        DB::table('locations')->insert($ruangan);
    }
}