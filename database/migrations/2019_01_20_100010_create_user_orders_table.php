<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_order_id')->nullable();
            $table->foreign('group_order_id')->references('id')->on('group_orders')
                ->onUpdate('cascade')->onDelete('set null');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->integer('billing_total');
            $table->boolean('delivered')->default(false);
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
        Schema::dropIfExists('user_orders');
    }
}
