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
        Schema::create('temporary_coin_logs', function (Blueprint $table) {
            $table->increments('id');
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
            $table->integer('to_wallet_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->integer('from_wallet_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->integer('offer_id')->nullable();
            $table->integer('sub_order_id')->nullable();
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
        Schema::dropIfExists('temporary_coin_logs');
    }
};
