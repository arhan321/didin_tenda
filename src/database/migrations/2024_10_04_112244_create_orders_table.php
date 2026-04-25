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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->string('nama_pemesan');
            // $table->unsignedBigInteger('client_id')->nullable();
            // $table->foreign('client_id')->references('id')->on('clients');
            // $table->unsignedBigInteger('alamat_id')->nullable();
            // $table->foreign('alamat_id')->references('id')->on('clients');
            // $table->unsignedBigInteger('cabang_id')->nullable();
            // $table->foreign('cabang_id')->references('id')->on('clients');
            $table->json('product');
            $table->biginteger('price');
            // $table->time('jam_pesan')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            // $table->unsignedBigInteger('table_id')->nullable();
            // $table->foreign('table_id')->references('id')->on('tables');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status_bayar')->nullable();
            $table->decimal('tax', 5, 2)->nullable();
            $table->enum('status_sewa', ['Sudah Selesai', 'Belum Selesai'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
