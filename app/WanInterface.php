<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class WanInterface extends Model
{
    protected $table = 'tbl_wan_interface';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_device',
		'ip_address',
		'netmask',
		'getway',
		'metric',
		'dhcp',
    ];
}