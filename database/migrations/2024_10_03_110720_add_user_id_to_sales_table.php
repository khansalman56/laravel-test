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
        Schema::table('sales', function (Blueprint $table) {
            // Adding user_id as a foreign key to the users table
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            
            // Setting up the foreign key constraint (assuming users table exists)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Dropping the foreign key and user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
