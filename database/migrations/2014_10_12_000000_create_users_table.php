<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->tinyInteger('isAdmin')->default(0)->comment('0:teacher ,1: student');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->rememberToken();
            $table->tinyInteger('status')->default(0)->comment('0: inactive, 1: active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
