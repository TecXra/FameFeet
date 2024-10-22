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
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->float('coins');
            $table->string('description');
            $table->string('content_type');
            $table->integer('quantity');
            $table->enum('status',['pending','accept','upload','reject','review'])->default('pending');
            $table->integer('fan_id')->unsigned();
            $table->foreign('fan_id')
                ->references('id')
                ->on('fans')
                ->onDelete('cascade');
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
        Schema::dropIfExists('offers');
    }
};
