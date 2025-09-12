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
        Schema::table('transactions', function (Blueprint $table) {
            // Add towing_id column
            $table->unsignedBigInteger('towing_id')->after('id')->nullable();

            // Add foreign key constraint
            $table->foreign('towing_id')->references('id')->on('towings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['towing_id']);
            $table->dropColumn('towing_id');
        });
    }
};
