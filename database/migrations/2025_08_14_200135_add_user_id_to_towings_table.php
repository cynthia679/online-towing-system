<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('towings', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->string('pickup_location')->after('user_id');
            $table->string('destination')->after('pickup_location');
            $table->string('vehicle_type')->after('destination');
            $table->text('description')->nullable()->after('vehicle_type');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending')->after('description');
        });
    }

    public function down()
    {
        Schema::table('towings', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'pickup_location', 'destination', 'vehicle_type', 'description', 'status']);
        });
    }
};
