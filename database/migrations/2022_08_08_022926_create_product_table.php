<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('productcode',50);
            $table->string('productname',50);
            $table->string('pattern',50);
            $table->float('unitprice',10,2);
            $table->float('set_price',10,2);
            $table->integer('stock');
            $table->integer('reorderlimit');
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->integer('status');
            $table->float('unitcost',10,2);
            $table->float('percentage',5,2);
            $table->float('markup',10,2);
            $table->timestamps();
            $table->softDeletes();
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
