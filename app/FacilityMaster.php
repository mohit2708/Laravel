<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class FacilityMaster extends Authenticatable{
	
    protected $table = 'facility_master';
    protected $primarykey = 'id';
   
}
