<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageLocationDetailsImage extends Authenticatable{
	
    protected $table = 'package_location_details_image';
    protected $primarykey = 'id';
   
}
