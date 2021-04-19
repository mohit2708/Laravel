<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    protected $primarykey = 'id';
	
	protected $fillable = [
	    'sort',
	    'country_name',
	    'phoneCode',
    ];
}
