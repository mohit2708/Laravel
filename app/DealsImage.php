<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DealsImage extends Authenticatable{
	
    protected $table = 'flight_deals_img';
    protected $primarykey = 'id';
   
}
