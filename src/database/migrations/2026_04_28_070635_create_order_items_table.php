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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->string('item_type')->default('package');
            $table->unsignedBigInteger('source_id')->nullable();

            $table->string('name');
            $table->string('unit')->nullable();

            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('total_price')->default(0);

            $table->json('snapshot')->nullable();

            $table->timestamps();

            $table->index(['order_id', 'item_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
