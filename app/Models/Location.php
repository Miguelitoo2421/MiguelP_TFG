<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * Los campos que pueden asignarse en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city',
        'province',
        'region',
        'street_type',
        'street_name',
        'street_number',
        'postal_code',
        'phone',
        'latitude',
        'longitude',
        'active',
        'notes',
    ];
}
