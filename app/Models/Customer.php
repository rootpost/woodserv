<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fl_name',
        'full_name',
        'phone',
        'address',
        'inn',
        'kpp',
        'ogrn'
    ];
}
