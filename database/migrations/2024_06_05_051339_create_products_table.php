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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->string('product_type')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_color')->nullable();
            $table->string('product_name');
            $table->string('product_chinese_name')->nullable();
            $table->string('product_english_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_slug')->nullable();
            $table->string('product_barcode');
            $table->decimal('product_cost')->default('0');
            $table->decimal('product_price')->default('0');
            $table->integer('alert_quantity')->nullable();
            $table->integer('product_weight')->nullable();
            $table->integer('product_lenght')->nullable();
            $table->integer('product_height')->nullable();
            $table->integer('product_width')->nullable();
            $table->enum('group_unit',['Pieces','Box Pieces'])->default('Pieces');
            $table->enum('default_inventory_unit',['Pieces','Box Pieces'])->default('Pieces');
            $table->enum('default_sale_unit',['Pieces','Box Pieces'])->default('Pieces');
            $table->enum('default_purchase_unit',['Pieces','Box Pieces'])->default('Pieces');
            $table->string('product_tax')->nullable();
            $table->string('tax_method')->nullable();
            $table->string('link_product')->nullable();
            $table->string('link_video')->nullable();
            $table->string('pre_order_type')->nullable();
            $table->string('branch_owner')->nullable();
            $table->string('tumbnail_image')->nullable();
            $table->string('product_details')->nullable();
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_sub_category');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_supplier')->references('id_supplier')->on('suppliers');
            $table->foreign('id_category')->references('id_category')->on('categories');
            $table->foreign('id_sub_category')->references('id_sub_category')->on('subcategories');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
