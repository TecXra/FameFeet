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
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name')->nullable();
            $table->string('item_description')->nullable();
            $table->float('per_item_price')->nullable();
            $table->integer('item_quantity')->nullable();
            $table->boolean('status')->default(true);
            $table->float('total_price')->nullable();
            $table->string('tracking_number')->nullable();
            $table->float('service_charges_percentage')->nullable();
            $table->float('celebrity_charges_percentage')->nullable();
            $table->float('service_charges_price')->nullable();
            $table->float('celebrity_charges_price')->nullable();
            $table->integer('sub_order_id')->unsigned();
            $table->foreign('sub_order_id')
                    ->references('id')
                    ->on('sub_orders')
                    ->cascadeOnDelete();
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')
                    ->references('id')
                    ->on('shops')
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
        Schema::dropIfExists('order_items');
    }
};
