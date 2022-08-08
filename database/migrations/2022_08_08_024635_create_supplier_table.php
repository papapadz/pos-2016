<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('companyname',200);
            $table->string('lastname',100);
            $table->string('firstname',100);
            $table->string('contactno',20);
            $table->string('address',200);
            $table->string('city',20);
            $table->string('tin',20);
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
