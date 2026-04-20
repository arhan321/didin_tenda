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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('stock_awal')->nullable();
            $table->bigInteger('stock_outstanding')->nullable();
            // $table->unsignedBigInteger('nama_client')->nullable();
            // $table->foreign('nama_client')->references('id')->on('clients');
            // $table->unsignedBigInteger('branch_client')->nullable();
            // $table->foreign('branch_client')->references('id')->on('clients');
            // $table->unsignedBigInteger('alamat_client')->nullable();
            // $table->foreign('alamat_client')->references('id')->on('clients');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('category_products');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->biginteger('stock_sisa')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
