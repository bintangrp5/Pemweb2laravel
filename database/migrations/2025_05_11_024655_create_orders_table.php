<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id'); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->unsignedBigInteger('customer_id'); // FOREIGN KEY
            $table->date('order_date'); // DATE NOT NULL
            $table->decimal('total_amount', 10, 2)->default(0.00); // DECIMAL NOT NULL DEFAULT 0.00
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                  ->default('pending'); // ENUM with default
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
