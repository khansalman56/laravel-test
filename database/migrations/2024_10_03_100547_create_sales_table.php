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
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for sales record
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to the products table
            $table->integer('quantity'); // Quantity of the product sold
            $table->decimal('unit_cost', 10, 2); // Cost of one unit of the product
            $table->decimal('selling_price', 10, 2); // Selling price for one unit
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
