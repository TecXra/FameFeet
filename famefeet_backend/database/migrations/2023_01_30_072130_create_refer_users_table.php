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
        Schema::create('refer_users', function (Blueprint $table) {
            $table->increments('id');
            $table->float('referral_bonus_percentage')->nullable();
            // $table->float('referral_bonus_price')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->boolean('is_expired')->default(false);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
            $table->integer('referred_user_id')->unsigned();
            $table->foreign('referred_user_id')
                   ->references('id')
                   ->on('users')
                   ->onDelete('cascade');
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
        Schema::dropIfExists('refer_users');
    }
};
