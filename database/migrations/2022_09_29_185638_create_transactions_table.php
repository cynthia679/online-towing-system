<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Towing service fields
            $table->string('phone')->nullable();
            $table->string('pickup')->nullable();
            $table->string('destination')->nullable();
            $table->double('amount')->nullable();
            $table->string('status')->nullable();

            // M-Pesa fields
            $table->string('MSISDN')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('mpesaReceiptNumber')->nullable();
            $table->double('balance')->nullable();
            $table->dateTime('transactionDate')->nullable();
            $table->string('merchantRequestID')->nullable();
            $table->string('checkoutRequestID')->nullable();
            $table->string('resultCode')->nullable();
            $table->string('resultDesc')->nullable();
            $table->string('firstName')->nullable();
            $table->string('middleName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('businessShortCode')->nullable();
            $table->string('transactionType')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
