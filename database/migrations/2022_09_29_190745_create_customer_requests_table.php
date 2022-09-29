<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId');
            $table->bigInteger('productId');
            $table->string('fromAddress')->nullable();
            $table->string('fromLongitude')->nullable();
            $table->string('fromLatitude')->nullable();
            $table->string('toAddress')->nullable();
            $table->string('toLongitude')->nullable();
            $table->string('toLatitude')->nullable();
            $table->string('name')->nullable();
            $table->dateTime('requestedAt')->nullable();
            $table->double('distance')->nullable();
            $table->double('charge')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->dateTime('dateModified')->nullable();
            $table->timestamp('dateCreated')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_requests');
    }
}
