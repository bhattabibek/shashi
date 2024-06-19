<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'price', 'category', 'description', // Add other columns as needed
    ];
}
