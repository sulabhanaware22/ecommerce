<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
            $table->bigInteger('price');
            $table->bigInteger('total_quantity');
            $table->bigInteger('remain_quantity');
            $table->longText('product_image');
            $table->longText('product_description');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('deleted_flag')->default(0);
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
        Schema::dropIfExists('products');
    }
}
