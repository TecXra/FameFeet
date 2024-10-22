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
        //
        Schema::table('payment_gateway_customer_profiles', function (Blueprint $table) {
            $table->integer('bank_account_detail_id')->after('payment_gateway')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('payment_gateway_customer_profiles', function (Blueprint $table) {
            
            $table->dropColumn('bank_account_detail_id');

        });
    }
};
