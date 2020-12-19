<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DiscountCoupon extends Authenticatable{
	
    protected $table = 'discount_coupons';
    protected $primarykey = 'id';
   
}
