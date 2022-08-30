<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverysetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryset', function (Blueprint $table) {
            $table->increments('deliveryset_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->float('srp',10,2);
            $table->float('unitcost',10,2);
            $table->float('deliverycost',10,2);
            $table->integer('employee_id');
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
