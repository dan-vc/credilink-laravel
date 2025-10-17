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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->decimal('total_paid', 15, 2)->default(0);
            $table->decimal('pending_balance', 15, 2)->default(0);
            $table->integer('months_paid')->default(0);
            $table->integer('months_pending')->default(0);
            $table->decimal('interest_accrued', 15, 2)->default(0);
            $table->foreignId('credit_id')->constrained('credits')->restrictOnDelete();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
