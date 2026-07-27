<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = ['category', 'title', 'readTime', 'badge', 'image', 'icon'];
}
