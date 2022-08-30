<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = ['product_id', 'category_id', 'employee_id', 'qty', 'salesprice', 'orderprice'];

    public function myProduct()
    {
        return $this->hasOne('App\Product', 'product_id', 'product_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'category_id', 'category_id');
    }
}
