<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // user making request
            $table->string('pickup_location');
            $table->string('destination');
            $table->string('vehicle_type');
            $table->string('phone');
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, paid, completed
            $table->decimal('price', 10, 2); // charge for towing
            $table->timestamps();

            // optional: foreign key to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('towings');
    }
}
