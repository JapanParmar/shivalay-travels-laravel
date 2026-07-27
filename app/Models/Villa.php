<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'location', 'description', 'price', 'imagePath', 'rating', 'amenities', 'gallery'
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery' => 'array'
    ];
}
