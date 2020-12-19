<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageFeatures extends Authenticatable{
	
    protected $table = 'package_features';
    protected $primarykey = 'id';
   
}
