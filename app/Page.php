<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Page extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'page_master';
    protected $primarykey = 'id';
    protected $fillable = [
        'page_id', 'page_title', 'slug', 'page_content'
    ];
   
}
