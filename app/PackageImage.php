<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageImage extends Authenticatable{
	
    protected $table = 'package_image';
    protected $primarykey = 'id';
   
}
