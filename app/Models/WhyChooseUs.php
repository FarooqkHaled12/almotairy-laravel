<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    use HasFactory;

    protected $table = 'why_choose_us';

    protected $fillable = [
        'highlight_word_ar',
        'highlight_word_en',
        'title_ar',
        'title_en',
        'point_1_title_ar', 'point_1_title_en', 'point_1_desc_ar', 'point_1_desc_en',
        'point_2_title_ar', 'point_2_title_en', 'point_2_desc_ar', 'point_2_desc_en',
        'point_3_title_ar', 'point_3_title_en', 'point_3_desc_ar', 'point_3_desc_en',
        'point_4_title_ar', 'point_4_title_en', 'point_4_desc_ar', 'point_4_desc_en',
        'image',
    ];
}
