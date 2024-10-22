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
        Schema::create('payment_gateway_funding_source_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_account_detail_id');
            $table->string("source_id")->nullable();
            $table->string("is_primary")->nullable();
            $table->string("status")->nullable();
            $table->string("routing")->nullable();
            $table->string("bank")->nullable();
            $table->string("lbacc")->nullable();
            $table->enum("type",getBankAccountTypes())->default(getDefaultBankAccountType());
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
        Schema::dropIfExists('payment_gateway_funding_source_profiles');
    }
};
