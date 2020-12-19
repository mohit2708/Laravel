<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DiscountOffer extends Authenticatable{
	
    protected $table = 'discount_offers';
    protected $primarykey = 'id';
   
}
