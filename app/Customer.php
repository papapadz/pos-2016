<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'cust_id';
    protected $fillable = ['companyname', 'lastname', 'firstname', 'contactno', 'tin_no', 'address', 'city', 'cust_type', 'bound'];
    public $timestamps = false;

    public function getCustomerNameAttribute()
    {
        return $this->attributes['companyname'] .' -- '. $this->attributes['lastname'];
    }

    public function myPayment()
    {
        return $this->hasOne('App\Payment', 'sales_id', 'sales_id');
    }

    public function myPayments()
    {
        return $this->hasMany('App\Payment', 'sales_id', 'sales_id');
    }
}
