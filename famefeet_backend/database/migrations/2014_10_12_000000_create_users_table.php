<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->default('storage/static/profileLogo.png');
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('password')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('used_referral_code')->nullable();
            $table->string('user_type')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->boolean('is_online')->default(false);
            $table->enum('account_status',[config('famefeet.account_status.active'),config('famefeet.account_status.suspend'),config('famefeet.account_status.block'),config('famefeet.account_status.deleted')])->default(config('famefeet.account_status.active'));
            $table->rememberToken();
            $table->softDeletes();
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
};
