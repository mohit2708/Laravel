<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Setting extends Authenticatable{
	
    protected $table = 'setting';
    protected $primarykey = 'id';
   
}
