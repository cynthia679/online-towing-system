<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInUsersTable extends Migration
{
    public function up()
    {
        // Drop the old column first
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        // Add the enum column
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
        });
    }

    public function down()
    {
        // Rollback: drop enum and add string again
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('approved');
        });
    }
}
