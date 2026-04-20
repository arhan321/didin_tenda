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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nama_client')->nullable();
            $table->string('alamat_client')->nullable();
            $table->string('branch_client')->nullable();
            $table->string('nomor_telfon1_client')->nullable();
            $table->string('nomor_telfon2_client')->nullable();
            $table->string('faximile_client')->nullable();
            $table->string('email_client')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
