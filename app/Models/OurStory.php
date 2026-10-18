<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurStory extends Model
{
    use HasFactory;

    protected $table = 'our_story';

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'name_ar',
        'name_en',
        'position_ar',
        'position_en',
        'image',
    ];
}
