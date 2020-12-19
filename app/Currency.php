<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Currency extends Authenticatable{
	
    protected $table = 'currency_master';
    protected $primarykey = 'id';
   
}
