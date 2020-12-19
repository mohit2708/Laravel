<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpenVpnConfig extends Model
{
    protected $table = 'tbl_openvpn_config_info';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_device',
		'openvpn_config_file',
    ];
}