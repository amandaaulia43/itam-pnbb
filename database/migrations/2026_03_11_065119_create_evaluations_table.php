<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Hapus tabel anak yang nyangkut terlebih dahulu
        Schema::dropIfExists('evaluation_details'); 
        
        // 2. Baru hapus tabel utamanya
        Schema::dropIfExists('evaluations'); 

        // 3. Buat tabel evaluations yang baru sesuai struktur kita
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            // Menyambungkan penilaian dengan data aset
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            // Kolom nilai untuk masing-masing kriteria (Skala 1-5)
            $table->integer('c1'); 
            $table->integer('c2'); 
            $table->integer('c3'); 
            $table->integer('c4'); 
            $table->integer('c5'); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};