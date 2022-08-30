<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    
    protected $table = 'employee';
    protected $primaryKey = 'employee_id';
    protected $fillable = ['employeename', 'position', 'username', 'password', 'address', 'contactno', 'email'];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
