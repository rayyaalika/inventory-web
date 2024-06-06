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

            $table->string('warehouse');
            $table->string('staff_name');

            $table->enum('socmed_type', ['Line', 'Instagram', 'WhatsApp', 'Telegram'])->default('WhatsApp')->nullable();
            $table->string('socmed_username')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone_number')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('address_picture')->nullable();

            $table->enum('delivery_company', ['HILIFE','FAMILY MART','HCT','7-11','POST', 'SHOPEE SHOP','OFFLINE'])->default('POST')->nullable();
            $table->string('payment_receipt')->nullable();
            // $table->enum('shipment_status', ['shipping', 'draft', 'cancel'])->default('draft')->nullable();
            
            $table->integer('qty_sales')->default('0')->nullable();
            $table->decimal('total_order')->default('0')->nullable();
            $table->date('send_date')->nullable();
            $table->string('sales_note')->default('none')->nullable();
            $table->enum('sales_status',['Pending Address', 'Pending Shipment','Waiting List', 'Ready to Approved', 'Collected', 'Completed'])->default('Pending Address');
            $table->integer('resi_number')->nullable();



            $table->unsignedBigInteger('id_store');
            // $table->unsignedBigInteger('id_product')->nullable();
            $table->unsignedBigInteger('id_user');
            // $table->unsignedBigInteger('id_customer');
            $table->timestamps();

            $table->foreign('id_store')->references('id_store')->on('stores');
            // $table->foreign('id_product')->references('id_product')->on('products');
            $table->foreign('id_user')->references('id_user')->on('users');
            // $table->foreign('id_customer')->references('id_customer')->on('customers');
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
