<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sales_id');
            $table->integer('cust_id');
            $table->string('invoicenumber',20);
            $table->float('totalsales',10,2);
            $table->float('discount',10,2)->default(0);
            $table->float('fixedAmtDiscount',10,2)->default(0);
            $table->integer('sales_type'); //1-CASH, 2-CREDIT
            $table->integer('status'); //0-UNPAIDM 1-PAID, 2-PARTIAL PAYMENT
            $table->dateTime('salesdate')->nullable();
            $table->integer('terms');
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
