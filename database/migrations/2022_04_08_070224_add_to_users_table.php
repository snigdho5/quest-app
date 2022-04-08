<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique();
            $table->integer('otp')->default(0);
            $table->string('lastlogin')->nullable();
            $table->string('token')->nullable();
            $table->integer('otp_verified')->default(0);
            $table->string('file_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('otp');
            $table->dropColumn('lastlogin');
            $table->dropColumn('token');
            $table->dropColumn('otp_verified');
            $table->dropColumn('file_path');
        });
    }
}
