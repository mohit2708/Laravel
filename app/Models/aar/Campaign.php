<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_type',
        'lead_type',
        'quality_type',
        'area_type',
        'states',
        'nation',
        'is_operating_hours',
        'from_time',
        'to_time',
        'from_day',
        'to_day',
        'name',
        'email',
        'phone',
        'quantity',
        'payment_status',
        'status',
    ];
}
