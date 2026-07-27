<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'customerName', 'customerPhone', 'customerEmail', 'fromCity', 'toCity', 
        'travelType', 'date', 'returnDate', 'passengers', 'classType', 'status', 
        'amount', 'agentId', 'notes'
    ];
}
