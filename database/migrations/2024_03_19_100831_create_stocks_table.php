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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('id_stock');
            $table->integer('wh_stock')->nullable();
            $table->integer('in_stock')->nullable();
            $table->integer('out_stock')->nullable();
            $table->integer('real_stock')->nullable();
            $table->integer('alert_stock')->nullable();
            $table->unsignedBigInteger('id_product');
            $table->timestamps();

            $table->foreign('id_product')->references('id_product')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
