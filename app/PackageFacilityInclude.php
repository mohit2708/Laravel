<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class PackageFacilityInclude extends Authenticatable{
	
    protected $table = 'package_facility_include';
    protected $primarykey = 'id';
   
}
