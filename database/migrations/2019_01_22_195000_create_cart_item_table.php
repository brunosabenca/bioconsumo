<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_order_id')->nullable();
            $table->foreign('user_order_id')->references('id')
                ->on('user_orders')->onUpdate('cascade')->onDelete('set null');

            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')
                ->on('products')->onUpdate('cascade')->onDelete('set null');

            $table->unsignedInteger('quantity');
            $table->unsignedInteger('delivered_quantity')->nullable();

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
        Schema::dropIfExists('cart_item');
    }
}
