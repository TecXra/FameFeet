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
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->float('price')->nullable();
            $table->enum('condition',['new','old'])->nullable();
            // $table->string('size');
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->float('weight')->nullable();
            $table->float('ounce')->nullable();
            $table->boolean('lock_media')->default(true);
            $table->integer('celebrity_id')->unsigned();
            $table->foreign('celebrity_id')
                            ->references('id')
                            ->on('celebrities')
                            ->onDelete('cascade');
            $table->integer('socks_size_id')->unsigned();
            $table->foreign('socks_size_id')
                  ->references('id')
                  ->on('socks_sizes')
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
        Schema::dropIfExists('shops');
    }
};
