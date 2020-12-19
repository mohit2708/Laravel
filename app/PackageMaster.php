<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageMaster extends Authenticatable{
	
    protected $table = 'package_master';
    protected $primarykey = 'id';
   
}
