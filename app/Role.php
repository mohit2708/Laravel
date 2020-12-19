<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Role extends Model
{

    protected $table = 'roles';
    protected $guarded = [];

    public function getRole()
    {
        return $this->belongsTo('App\Role', 'parent_id');
    }

   /* public function getDept()
    {
        return $this->belongsTo('App\Department','dept_id');

    }*/

}

