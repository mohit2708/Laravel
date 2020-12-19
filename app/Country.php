<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Country extends Authenticatable{
	
    protected $table = 'countries';
    protected $primarykey = 'id';
   
}
