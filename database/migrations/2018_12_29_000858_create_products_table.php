<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->unsignedInteger('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock')->default('0');
            $table->string('stock_unit_type')->default('Kg');
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
