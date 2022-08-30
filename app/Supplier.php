<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['companyname', 'owner_name', 'contactno', 'address', 'tin'];
}
