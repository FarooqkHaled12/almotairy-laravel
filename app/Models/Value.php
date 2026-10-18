<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
    ];
}
