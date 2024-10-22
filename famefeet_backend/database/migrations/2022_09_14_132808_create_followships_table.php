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
        Schema::create('followships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_id')->unsigned();
            $table->foreign('follower_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->integer('following_id')->unsigned();
            $table->foreign('following_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            // $table->softDeletes();
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
        Schema::dropIfExists('followships');
    }
};
