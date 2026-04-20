<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->decimal('harga_beli', 15, 2)->nullable();
            $table->decimal('harga_sewa', 15, 2)->nullable();
            // $table->date('start')->nullable();
            // $table->date('end')->nullable();
            $table->string('jangka_waktu')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
