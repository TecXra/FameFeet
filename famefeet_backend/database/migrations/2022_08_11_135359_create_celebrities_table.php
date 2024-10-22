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
        Schema::create('celebrities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gender')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->boolean('show_age')->default(true)->nullable();
            $table->boolean('show_location')->default(false )->nullable();
            $table->string('messages')->nullable();
            $table->string('experience')->nullable();
            $table->string('notification_type')->nullable()->default(0);
            $table->string('send_offer')->nullable();
            $table->string('front_id_pic')->nullable();
            $table->string('back_id_pic')->nullable();
            $table->text('fun_fact')->nullable();
            $table->text('like')->nullable();
            $table->text('dislike')->nullable();
            $table->float('message_charges')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->integer('feet_id')->unsigned()->nullable();
            $table->foreign('feet_id')->references('id')->on('feets')->nullOnDelete();
            $table->integer('profession_id')->unsigned()->nullable();
            $table->foreign('profession_id')
                   ->references('id')
                   ->on('professions')
                   ->nullOnDelete();
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
        Schema::dropIfExists('celebrities');
    }
};
