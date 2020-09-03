<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['companyname', 'lastname', 'firstname', 'contactno', 'address', 'city', 'tin'];
    public $timestamps = false;
}
