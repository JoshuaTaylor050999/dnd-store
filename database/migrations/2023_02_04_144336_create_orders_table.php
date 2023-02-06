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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('shippingAddress');
            $table->string('shippingCity');
            $table->string('shippingCountry');
            $table->string('shippingCountryCode');
            $table->string('shippingCustomerName');
            $table->string('shippingPhone');
            $table->string('shippingProvince');
            $table->string('shippingZip');


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
        Schema::dropIfExists('orders');
    }
};
