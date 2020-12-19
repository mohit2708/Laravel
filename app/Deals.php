<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Deals extends Authenticatable{
	
    protected $table = 'flight_deals';
    protected $primarykey = 'id';
   
}
