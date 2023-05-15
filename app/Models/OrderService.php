<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'service_id',
        'count',
    ];
    public $timestamps = false;
}
