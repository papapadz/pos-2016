<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverySet extends Model
{
    protected $primaryKey = 'deliveryset_id';
    protected $table = 'deliveryset';
    protected $fillable = ['employee_id', 'product_id', 'qty', 'unitcost', 'deliverycost','srp'];

    public function myProduct(){
        return $this->hasOne('App\Product', 'product_id', 'product_id');
    }
}
