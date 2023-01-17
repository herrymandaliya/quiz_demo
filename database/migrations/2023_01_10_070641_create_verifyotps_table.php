<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyotpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifyotps', function (Blueprint $table) {
            $table->increments('verifyotp_id');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: User');
            $table->string('otp');
            $table->timestamp('expire_at')->nullable();
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
        Schema::dropIfExists('verifyotps');
    }
}
