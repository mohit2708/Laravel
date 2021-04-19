<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $primarykey = 'id';
	
	protected $fillable = [
        'name',
	    'country_id',
    ];
}
