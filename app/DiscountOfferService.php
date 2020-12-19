<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DiscountOfferService extends Authenticatable{
	
    protected $table = 'discount_offer_services';
    protected $primarykey = 'id';
   
}
