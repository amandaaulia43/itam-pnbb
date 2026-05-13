<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            // Kita pakai default 'Belum Diganti'
            $table->string('kondisi_penggantian')->default('Belum Diganti')->after('location');
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('kondisi_penggantian');
        });
    }
};
