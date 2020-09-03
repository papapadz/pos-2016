<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetails extends Model
{
    protected $table = 'deliverydetails';
    protected $primaryKey = 'deliverydetails_id';
    protected $fillable = ['delivery_id', 'product_id', 'qty', 'unitcost'];
    public $timestamps = false;

    public function myProduct()
    {
        return $this->hasOne('App\Product', 'product_id', 'product_id');
    }
}
