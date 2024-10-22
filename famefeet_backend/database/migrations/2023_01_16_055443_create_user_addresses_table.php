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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->boolean('selected_address')->default(false);
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
        Schema::dropIfExists('user_addresses');
    }
};
