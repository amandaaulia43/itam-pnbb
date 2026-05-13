<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menghapus tabel criterias jika ada
        Schema::dropIfExists('criterias');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opsional: Jika di-rollback, tabel dibuat kembali (kosongan)
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};