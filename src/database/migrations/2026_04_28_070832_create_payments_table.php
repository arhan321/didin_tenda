<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke pesanan
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Gateway pembayaran
            $table->string('payment_gateway')->default('midtrans');

            // Data utama Midtrans
            $table->string('midtrans_order_id')->unique()->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('snap_token')->nullable();
            $table->text('redirect_url')->nullable();

            // Nominal pembayaran
            $table->unsignedBigInteger('gross_amount')->default(0);
            $table->string('currency')->default('IDR');

            // Metode pembayaran
            $table->string('payment_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();

            // Khusus beberapa metode pembayaran Midtrans
            $table->string('permata_va_number')->nullable();
            $table->string('bill_key')->nullable();
            $table->string('biller_code')->nullable();
            $table->text('pdf_url')->nullable();

            // Status dari Midtrans
            $table->string('transaction_status')->default('pending');
            $table->string('fraud_status')->nullable();
            $table->string('status_code')->nullable();
            $table->string('status_message')->nullable();

            // Status internal sistem
            $table->string('payment_status')->default('pending');

            // Waktu penting
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Simpan response asli dari Midtrans
            $table->json('raw_response')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('midtrans_order_id');
            $table->index('transaction_id');
            $table->index('transaction_status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};