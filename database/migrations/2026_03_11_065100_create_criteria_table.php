<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Menyimpan C1, C2, dst
            $table->string('name'); // Nama kriteria
            $table->enum('type', ['benefit', 'cost']); // Jenis kriteria
            $table->decimal('weight', 5, 2); // Menyimpan bobot (contoh: 0.30 untuk 30%)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('criteria');
    }
};