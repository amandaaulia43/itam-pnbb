<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Tambahkan baris ini

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'PC Desktop'],
            ['name' => 'Laptop'],
            ['name' => 'Printer'],
            ['name' => 'Router/Switch'],
        ]);
    }
}