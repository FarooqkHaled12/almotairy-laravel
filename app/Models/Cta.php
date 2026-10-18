<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    use HasFactory;

    protected $table = 'cta';

    protected $fillable = [
        'title_ar', 'title_en',
        'description_ar', 'description_en',
        'button_1_text_ar', 'button_1_text_en', 'button_1_link',
        'button_2_text_ar', 'button_2_text_en', 'button_2_link',
    ];
}
