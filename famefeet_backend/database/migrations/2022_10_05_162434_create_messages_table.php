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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->boolean('seen')->default(false);
            $table->integer('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('conversation_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('conversations')->cascadeOnDelete();
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
        Schema::dropIfExists('messages');
    }
};
