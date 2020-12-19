<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class State extends Authenticatable{
	
    protected $table = 'states';
    protected $primarykey = 'id';
   
}
