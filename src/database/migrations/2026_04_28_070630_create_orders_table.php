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

            $table->string('invoice_number')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('package_id')
                ->nullable()
                ->constrained('packages')
                ->nullOnDelete();

            $table->enum('order_type', ['package', 'custom'])->default('package');

            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            $table->date('event_date');
            $table->string('event_location_name')->nullable();
            $table->text('event_address')->nullable();

            $table->decimal('distance_km', 8, 2)->nullable();
            $table->unsignedBigInteger('shipping_fee')->default(0);

            $table->unsignedBigInteger('subtotal_package')->default(0);
            $table->unsignedBigInteger('subtotal_custom')->default(0);
            $table->unsignedBigInteger('subtotal_addons')->default(0);
            $table->unsignedBigInteger('total_price')->default(0);

            $table->string('status')->default('waiting_payment');
            $table->enum('payment_status', [
            'unpaid',
            'pending',
            'paid',
            'expired',
            'failed',
            'cancelled',
            'refunded',
             ])->default('unpaid');

            $table->timestamp('payment_deadline')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->text('cancelled_reason')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['event_date', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['payment_status']);
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
