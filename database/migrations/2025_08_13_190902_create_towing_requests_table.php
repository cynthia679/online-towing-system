<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTowingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towing_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // user who made the request
            $table->string('pickup_location');
            $table->string('dropoff_location')->nullable();
            $table->string('vehicle_details')->nullable();
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'])
                  ->default('pending');
            $table->timestamps();

            // Foreign key linking to users table
            $table->foreign('client_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('towing_requests');
    }
}
