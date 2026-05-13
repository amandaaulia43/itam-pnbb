<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('asset_code')->unique();
            $table->string('asset_name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('serial_number')->nullable();
            $table->string('location');
            // Status Barang / Kepemilikan (Sesuai masukan pembimbing)
            $table->enum('item_status', ['BMN', 'Pihak Ketiga', 'Barang Lainnya'])->default('BMN');
            // Kondisi Awal (Dulu namanya status)
            $table->enum('status', ['active', 'broken', 'maintenance'])->default('active');
            
            // Kolom Tambahan Baru
            $table->string('photo')->nullable(); // Foto opsional
            $table->date('purchase_date')->nullable(); // Opsional untuk SPK
            $table->decimal('purchase_price', 15, 2)->nullable(); // Opsional untuk SPK
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};