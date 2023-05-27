<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartService extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'count',
    ];
    public $timestamps = false;
    
}
