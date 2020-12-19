<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Coupon extends Authenticatable{
	
    protected $table = 'coupons';
    protected $primarykey = 'id';
   
}
