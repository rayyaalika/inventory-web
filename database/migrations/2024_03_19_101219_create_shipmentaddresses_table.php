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
        Schema::create('shipmentaddresses', function (Blueprint $table) {
            $table->id('id_address');
            $table->string('address_details');
            $table->string('address_picture')->nullable();
            $table->enum('address_status', ['active','inactive'])->default('active');
            $table->unsignedBigInteger('id_customer');
            $table->timestamps();

            $table->foreign('id_customer')->references('id_customer')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipmentaddresses');
    }
};
