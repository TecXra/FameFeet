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
        Schema::create('subscribe_user_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->float('coins');
            $table->boolean('active');
            $table->timestamp('subscription_start_date')->nullable();
            $table->timestamp('subscription_end_date')->nullable();
            $table->integer('subscription_id')->unsigned();
            $table->foreign('subscription_id')
                  ->references('id')
                  ->on('subscriptions')
                  ->cascadeOnDelete();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
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
        Schema::dropIfExists('subscribe_user_histories');
    }
};
