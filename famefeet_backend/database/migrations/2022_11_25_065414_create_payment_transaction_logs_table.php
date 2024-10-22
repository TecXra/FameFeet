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
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount',8,2);
            $table->string('response_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('auth_id')->nullable();
            $table->string('message_code')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->integer('user_card_detail_id')->unsigned();
            $table->foreign('user_card_detail_id')
                    ->references('id')
                    ->on('user_card_details')
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
        Schema::dropIfExists('payment_transaction_logs');
    }
};
