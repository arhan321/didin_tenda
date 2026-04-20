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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('alamat_id')->nullable();
            $table->foreign('alamat_id')->references('id')->on('clients');
            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->foreign('cabang_id')->references('id')->on('clients');
            $table->json('product');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->biginteger('price');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status_bayar')->nullable();
            $table->decimal('tax', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
