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
        Schema::create('forecastings', function (Blueprint $table) {
            $table->id('id_forecasting');
            $table->date('date');
            $table->string('parameter');
            $table->Integer('value')->default('0');
            // $table->unsignedBigInteger('id_product')->nullable();
            $table->timestamps();

            // $table->foreign('id_product')->references('id_product')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecastings');
    }
};
