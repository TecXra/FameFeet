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
        Schema::create('coin_logs', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('log_name')->nullable();
            $table->integer('log_type')->default(0);
            $table->float('to_amount')->nullable();
            $table->string('to_currency')->nullable();
            $table->float('from_amount')->nullable();
            $table->string('from_currency')->nullable();
            $table->float('service_charges_percentage')->nullable();
            $table->float('celebrity_charges_percentage')->nullable();
            $table->float('service_charges_price')->nullable();
            $table->float('celebrity_charges_price')->nullable();
            $table->float('exchange_rate')->default(1);
            $table->integer('sender_wallet_id')->nullable();
            $table->integer('sender_user_id')->nullable();
            $table->integer('receiver_wallet_id')->nullable();
            $table->integer('receiver_user_id')->nullable();
            $table->string('referral_table_name')->nullable();
            $table->integer('referral_table_id')->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('coin_logs');
    }
};
