<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PageAccess extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'role_page_access';
    protected $primarykey = 'id';
    protected $fillable = [
        //'name', 'email', 'password',
        'id','role_id', 'privilege_id',
    ];
   
}
