<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Connection extends Authenticatable{
	
    protected $table = 'tbl_route_tables_info';
    protected $primarykey = 'id';
   
}