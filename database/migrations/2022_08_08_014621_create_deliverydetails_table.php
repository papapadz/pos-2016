<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverydetails', function (Blueprint $table) {
            $table->increments('deliverydetails_id');
            $table->integer('delivery_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->float('srp',10,2);
            $table->float('unitcost',10,2);
            $table->float('deliverycost',10,2)->default(0);
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
        //
    }
}
