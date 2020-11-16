<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneSmsVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_sms_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email_address')->unique();
            $table->string('verification_code');
            $table->smallInteger('verification_status');
            $table->integer('expiration_time_in_seconds');
            $table->smallInteger('expired');
            $table->rememberToken();
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
        Schema::dropIfExists('phone_sms_verifications');
    }
}
