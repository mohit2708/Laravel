<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primarykey = 'id';
	
	protected $fillable = [
        'f_name',
	    'l_name',
	    'email',
	    'phone_number',
    ];
}
