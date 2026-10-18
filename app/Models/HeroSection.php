<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_section';

    protected $fillable = [
        'title_ar',
        'title_en',
        'highlight_word_1_ar',
        'highlight_word_1_en',
        'subtitle_ar',
        'subtitle_en',
        'highlight_word_2_ar',
        'highlight_word_2_en',
        'description_ar',
        'description_en',
        'button_1_title_ar',
        'button_1_title_en',
        'button_1_link',
        'button_2_title_ar',
        'button_2_title_en',
        'button_2_link',
        'stat_1_number',
        'stat_1_title_ar',
        'stat_1_title_en',
        'stat_2_number',
        'stat_2_title_ar',
        'stat_2_title_en',
        'stat_3_number',
        'stat_3_title_ar',
        'stat_3_title_en',
        'image',
    ];
}
