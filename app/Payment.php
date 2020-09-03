<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = ['sales_id', 'amounttendered', 'ammountpaid', 'balancedue', 'or_number', 'paymentdate', 'paymentmode', 'cheque_no', 'cheque_date', 'due_date'];
    public $timestamps = false;

}
