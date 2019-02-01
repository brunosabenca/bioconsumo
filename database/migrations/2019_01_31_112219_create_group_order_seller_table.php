<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupOrderSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_order_seller', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('group_order_id')->nullable();
            $table->foreign('group_order_id')->references('id')
                ->on('group_orders')->onUpdate('cascade')->onDelete('set null');

            $table->unsignedInteger('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('group_order_seller');
    }
}
