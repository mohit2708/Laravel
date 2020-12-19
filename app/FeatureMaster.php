<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class FeatureMaster extends Authenticatable{
	
    protected $table = 'features_master';
    protected $primarykey = 'id';
   
}
