<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class BonusInfo extends Authenticatable{
	
    protected $table = 'bonus_info';
    protected $primarykey = 'id';
   
}
