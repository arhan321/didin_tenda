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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user')->nullable();
            $table->string('type_laptop')->nullable();
            $table->string('sn_laptop')->nullable();
            $table->string('tahun_laptop')->nullable();
            $table->string('garansi')->nullable();
            $table->string('charger')->nullable();
            $table->string('tas')->nullable();
            $table->string('cabang')->nullable();
            $table->string('bisnis_unit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
