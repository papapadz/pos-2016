<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('cust_id');
            $table->string('companyname',200);
            $table->string('lastname',100);
            $table->string('firstname',100);
            $table->string('contactno',20);
            $table->integer('tin_no');
            $table->string('address',200);
            $table->string('city',100);
            $table->integer('cust_type');
            $table->integer('bound');
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
