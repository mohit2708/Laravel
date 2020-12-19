<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class RouteOperation extends Model
{
//use SoftDeletes;
    protected $table = 'tbl_route_operation';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
		'device_serial',
		'network_type',
		'route_option',
		'netmask_value',
    ];
}