<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'customerName', 'customerPhone', 'customerEmail', 'destinations', 
        'duration', 'travelers', 'budget', 'accommodation', 'status', 'notes'
    ];
}
