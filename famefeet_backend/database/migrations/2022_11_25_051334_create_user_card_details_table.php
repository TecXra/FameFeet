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
        Schema::create('user_card_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('customer_payment_profile_id');
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_type')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('customer_profile_id')->unsigned();
            $table->foreign('customer_profile_id')
                   ->references('id')
                   ->on('customer_profiles')
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
        Schema::dropIfExists('user_card_details');
    }
};
