<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Airlines extends Authenticatable{
	
    protected $table = 'airlines';
    protected $primarykey = 'id';
   
}
