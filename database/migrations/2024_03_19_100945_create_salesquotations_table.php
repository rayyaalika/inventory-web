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
        Schema::create('salesquotations', function (Blueprint $table) {
            $table->id('id_sales');
            $table->dateTime('transaction_date');
            $table->string('sq_numbering');
            $table->integer('qty_sales')->default('0');
            $table->decimal('total_order')->default('0');
            $table->date('send_date')->nullable();
            $table->string('sales_note')->nullable();
            $table->enum('sales_status',['Pending Address','Waiting List', 'Ready to Approved', 'Pending Shipment', 'Collected', 'Completed'])->default('Pending Address');
            $table->integer('sales_resi')->nullable();
            $table->unsignedBigInteger('id_store');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_customer');
            $table->timestamps();

            $table->foreign('id_store')->references('id_store')->on('stores');
            $table->foreign('id_product')->references('id_product')->on('products');
            $table->foreign('id_user')->references('id_user')->on('users');
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
        Schema::dropIfExists('salesquotations');
    }
};
