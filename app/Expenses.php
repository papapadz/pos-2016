<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
	protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable = ['agent','food', 'home_stay', 'diesel', 'load', 'others', 'expensedate'];
}
