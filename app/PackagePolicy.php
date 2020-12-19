<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackagePolicy extends Authenticatable{
	
    protected $table = 'policy_master';
    protected $primarykey = 'id';
   
}
