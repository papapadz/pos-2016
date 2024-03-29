<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'productcode', 
        'productname', 
        //'pattern', 
        'unitprice', 
        //'unitcost', 
        //'percentage', 
        //'markup', 
        'stock', 
        'category_id', 
        'reorderlimit', 
        //'supplier_id', 
        'status'];

    public function myCategory()
    {
        return $this->hasOne('App\Category', 'category_id', 'category_id');
    }

    public function mySupplier()
    {
        return $this->hasOne('App\Supplier', 'supplier_id', 'supplier_id');
    }

    public function mySales()
    {
        return $this->hasOne('App\SalesDetails', 'product_id', 'product_id');
    }
}
