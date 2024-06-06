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
        Schema::create('salesproducts', function (Blueprint $table) {
            $table->id('id_salesproduct');
            $table->string('salesproduct_name');
            $table->decimal('salesproduct_price');
            $table->integer('quantity');
    
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_sales');
            // $table->unsignedBigInteger('id_stock')->nullable();
            $table->timestamps();

            $table->foreign('id_product')->references('id_product')->on('products');
            $table->foreign('id_sales')->references('id_sales')->on('salesquotations');
            // $table->foreign('id_stock')->references('id_stock')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salesproducts');
    }
};
