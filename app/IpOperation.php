<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class IpOperation extends Model
{
    protected $table = 'tbl_iptables_rules_operation';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule_type',
		'in_interface',
		'out_interface',
		'protocol',
		'orginal_desti_ip',
		'orginal_desti_port',
        'orginal_source_ip',
        'orginal_source_port',
        'rule_action',
        'translate_desti_address',
        'translate_source_address',
        'redirect_select',
        'redirect_port',
        'masquerade_select',
        'masquerade_port',
        'add_delete',
        'ip_flag',
    ];
}