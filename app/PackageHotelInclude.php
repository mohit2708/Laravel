<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageHotelInclude extends Authenticatable{
	
    protected $table = 'package_hotel_include';
    protected $primarykey = 'id';
   
}
