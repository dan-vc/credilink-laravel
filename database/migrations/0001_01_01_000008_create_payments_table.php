<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_type', ['efectivo', 'transferencia', 'tarjeta']);
            $table->text('payment_note')->nullable();
            $table->enum('status', ['pago realizado', 'no pagado', 'atrasado'])->default( 'no pagado');
            $table->decimal('extra_payment', 15, 2);
            $table->decimal('total', 15,2);
            $table->date('start_date');
            $table->date('due_date');
            $table->date('paid_date');
            $table->foreignId('credit_id')->constrained('credits')->restrictOnDelete();
            $table->foreignId('processed_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
