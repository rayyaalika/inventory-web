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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('id_shipment');
            $table->enum('delivery company', ['HILIFE','FAMILY MART','HCT','7-11','POST', 'SHOPEE SHOP','OFFLINE'])->default('POST');
            $table->string('payment_receipt')->nullable();
            $table->enum('shipment_status', ['shipping', 'draft', 'cancel'])->default('draft');
            $table->integer('shipment_resi')->nullable();
            $table->unsignedBigInteger('id_sales');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_sales')->references('id_sales')->on('salesquotations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
