<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_posisi');
            $table->string('deskripsi_posisi')->nullable();
            $table->longtext('tugas_posisi')->nullable();
            $table->biginteger('gaji_pokok')->nullable();
            $table->biginteger('tunjangan_makan')->nullable();
            $table->biginteger('tunjangan_transport')->nullable();
            $table->biginteger('tunjangan_kesehatan')->nullable();
            $table->biginteger('tunjangan_ketenagakerjaan')->nullable();
            $table->biginteger('total_gaji')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
