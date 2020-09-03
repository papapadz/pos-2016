<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    protected $fillable = ['supplier_id', 'order_number', 'deliverydate', 'date_received'];
    protected $primaryKey = 'delivery_id';
    public $timestamps = false;

    public function myDetails()
    {
        return $this->hasOne('App\DeliveryDetails', 'delivery_id', 'delivery_id');
    }

    public function myDetails2()
    {
        return $this->hasMany('App\DeliveryDetails', 'delivery_id', 'delivery_id');
    }

    public function mySupplier()
    {
        return $this->hasOne('App\Supplier', 'supplier_id', 'supplier_id');
    }
}