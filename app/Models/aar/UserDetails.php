<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'user_details';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'city'
    ];

    use HasFactory;
}
