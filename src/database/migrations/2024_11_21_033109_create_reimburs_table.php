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
        Schema::create('reimburs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('alamat_id')->nullable();
            $table->foreign('alamat_id')->references('id')->on('clients');
            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->foreign('cabang_id')->references('id')->on('clients');
            $table->json('product');
            $table->string('jarak_antar')->nullable();
            $table->string('bukti_struk')->nullable();
            $table->string('tanggal')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimburs');
    }
};
