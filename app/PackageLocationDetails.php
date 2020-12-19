<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageLocationDetails extends Authenticatable{
	
    protected $table = 'package_location_details';
    protected $primarykey = 'id';
   
}
