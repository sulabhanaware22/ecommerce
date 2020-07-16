<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserProductReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_product_reference', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->bigInteger('product_qty');
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
        Schema::dropIfExists('user_product_reference');
    }
}
