<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DiscountCouponService extends Authenticatable{
	
    protected $table = 'discount_coupon_services';
    protected $primarykey = 'id';
   
}
