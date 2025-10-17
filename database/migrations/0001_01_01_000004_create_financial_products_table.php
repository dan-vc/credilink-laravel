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
            Schema::create('financial_products', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->decimal('interest_rate', 5, 2);
                $table->integer('max_term_months');
                $table->decimal('min_amount', 15, 2);
                $table->decimal('max_amount', 15, 2);
                $table->enum('status', ['active', 'inactive'])->default( 'inactive');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_products');
    }
};
