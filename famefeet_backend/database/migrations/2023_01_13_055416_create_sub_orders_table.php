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
        Schema::create('sub_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->float('total_price')->nullable();
            $table->enum('status',['pending','in_progress','accept','deliver','complete','cancel','review'])->default('pending');
            $table->float('shipping_charges')->nullable();
            $table->string('tracking_number')->nullable();
            $table->float('service_charges_percentage')->nullable();
            $table->float('celebrity_charges_percentage')->nullable();
            $table->float('service_charges_price')->nullable();
            $table->float('celebrity_charges_price')->nullable();
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
                    ->cascadeOnDelete();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                            ->references('id')
                            ->on('users')
                            ->cascadeOnDelete();
            $table->integer('celebrity_id')->unsigned();
            $table->foreign('celebrity_id')
                  ->references('id')
                  ->on('celebrities')
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
        Schema::dropIfExists('sub_orders');
    }
};
