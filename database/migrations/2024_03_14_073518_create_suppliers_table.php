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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('supplier_company');
            $table->string('supplier_name');
            $table->enum('supplier_type',['local','foreign'])->default('local');
            $table->string('supplier_country');
            $table->string('supplier_address');
            $table->string('supplier_phone_number');
            $table->string('supplier_city');
            $table->integer('supplier_postal_code')->nullable();
            $table->string('supplier_email')->unique();
            $table->enum('supplier_currency',['NTD','RMB'])->default('NTD');
            $table->string('vat_number')->nullable();
            $table->string('gst_number')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
