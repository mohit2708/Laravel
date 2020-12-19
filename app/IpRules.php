<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class IpRules extends Model
{
    protected $table = 'tbl_iptables_rules';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule_operation_id',
		'map_device_key',
		'device_serial',
		'chain_type',
		'packets',
		'bytes',
        'target',
        'protocol',
        'opt',
        'in_interface',
        'out_interface',
        'source_address',
        'destination_address',
        'rule_details',
    ];
}