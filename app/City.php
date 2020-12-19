<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class City extends Authenticatable{
	
    protected $table = 'city';
    protected $primarykey = 'id';
   
}
