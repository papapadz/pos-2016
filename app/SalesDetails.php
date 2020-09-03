<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    protected $table = 'salesdetails';
    protected $primaryKey = 'salesdetails_id';
    protected $fillable = ['sales_id', 'product_id', 'qty', 'ordersalesprice', 'sales_price'];
    public $timestamps = false;

    public function myProduct()
    {
        return $this->hasOne('App\Product', 'product_id', 'product_id');
    }
}
