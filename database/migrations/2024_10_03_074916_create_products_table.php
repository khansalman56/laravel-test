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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing ID column
            $table->string('name'); // Creates a 'name' column of type string
            $table->decimal('profit_margin', 10, 2); // Creates a 'profit_margin' column (10 digits, 2 decimal places)
            $table->decimal('shipping_cost', 10, 2); // Creates a 'shipping_cost' column (10 digits, 2 decimal places)
            $table->boolean('enabled')->default(true); // Creates an 'enabled' column with a default value of true
            $table->timestamps(); // Creates 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
