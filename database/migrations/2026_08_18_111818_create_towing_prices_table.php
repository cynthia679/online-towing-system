<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('towing_prices', function (Blueprint $table) {
            $table->id();

            $table->string('vehicle_type');
            $table->decimal('min_distance', 8, 2);
            $table->decimal('max_distance', 8, 2)->nullable();

            $table->decimal('price', 10, 2);

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('towing_prices');
    }
};
