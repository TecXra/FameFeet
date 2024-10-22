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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_type')->nullable();
            $table->boolean('all_notification')->default(true);
            $table->boolean('custom_offer_notification')->default(true);
            $table->boolean('messages_notification')->default(true);
            $table->boolean('content_sold_notification')->default(true);
            $table->boolean('new_subscription_notification')->default(true);
            $table->boolean('cancel_subscription_notification')->default(true);
            $table->boolean('receive_tip_notification')->default(true);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
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
        Schema::dropIfExists('notification_preferences');
    }
};
