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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['fixed', 'custom'])->default('fixed');

            $table->string('short_description')->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('price')->default(0);
            $table->string('price_unit')->default('paket');

            $table->string('main_image')->nullable();
            $table->json('images')->nullable();

            $table->string('color')->nullable();
            $table->string('badge')->nullable();

            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
