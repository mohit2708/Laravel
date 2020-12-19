<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DeviceInfo extends Model
{
    protected $table = 'tbl_device_info';
    protected $primarykey = 'id';

    protected $fillable = [
        'tunnel_ip',
		'device_serial',
		'interface_with_ip',
    ];
}
