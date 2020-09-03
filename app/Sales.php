<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sales_id';
    protected $fillable = ['cust_id', 'invoicenumber', 'fixedAmtDiscount', 'sales_type', 'status', 'sales_date', 'terms'];
    public $timestamps = false;

    public function myDetails()
    {
        return $this->hasMany('App\SalesDetails', 'sales_id', 'sales_id');
    }

    public function myPayments()
    {
        return $this->hasMany('App\Payment', 'sales_id', 'sales_id');
    }

    public function myPayment()
    {
        return $this->hasOne('App\Payment', 'sales_id', 'sales_id');
    }

    public function myCustomer()
    {
        return $this->hasOne('App\Customer', 'cust_id', 'cust_id');
    }
}
