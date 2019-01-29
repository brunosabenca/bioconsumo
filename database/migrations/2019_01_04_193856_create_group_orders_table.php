<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('open_date');
            $table->date('close_date');
            
            $table->boolean('cancelled')->default(false);
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
        Schema::dropIfExists('group_orders');
    }
}
