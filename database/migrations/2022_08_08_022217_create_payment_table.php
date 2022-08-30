<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('sales_id');
            $table->float('amounttendered',10,2);
            $table->float('amountpaid',10,2);
            $table->float('balancedue',10,2);
            $table->float('percentDiscount',8,2);
            $table->float('fixedAmtDiscount',10,2)->default(0);
            $table->string('or_number',20);
            $table->dateTime('paymentdate')->nullable();
            $table->string('paymentmethod',50);
            $table->string('cheque_no',20)->nullable();
            $table->dateTime('cheque_date')->nullable();
            $table->dateTime('due_date');
            $table->string('branch',50);
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
