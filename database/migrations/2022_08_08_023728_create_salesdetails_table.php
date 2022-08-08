<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesdetails', function (Blueprint $table) {
            $table->increments('salesdetails_id');
            $table->integer('sales_id');
            $table->integer('product_id');
            $table->integer('qty')->default(1);
            $table->float('ordersalesprice',10,2);
            $table->float('sales_price',10,2);
            $table->timestamps()->nullable();
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
