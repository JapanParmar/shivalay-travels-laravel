<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'quote', 'name', 'location', 'destination', 'trip', 'rating', 'avatar', 'image', 'clientImage'
    ];
}
