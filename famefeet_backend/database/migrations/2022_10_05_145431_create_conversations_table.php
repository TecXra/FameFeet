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
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_one')->unsigned();
            $table->foreign('user_one')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('user_two')->unsigned();
            $table->foreign('user_two')->references('id')->on('users')->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->integer('unread')->default(0);
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
        Schema::dropIfExists('conversations');
    }
};
