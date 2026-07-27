<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'region', 'tagline', 'duration', 'groupSize', 'difficulty', 
        'bestSeason', 'startingFrom', 'tags', 'highlights', 'includes', 'imagePath', 'gallery'
    ];

    protected $casts = [
        'tags' => 'array',
        'highlights' => 'array',
        'includes' => 'array',
        'gallery' => 'array'
    ];
}
