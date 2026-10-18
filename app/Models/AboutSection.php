<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $table = 'about_section';

    protected $fillable = [
        'image',
        'title_1_ar',
        'title_1_en',
        'title_2_ar',
        'title_2_en',
        'description_ar',
        'description_en',
        'features_ar',
        'features_en',
        'signature_ar',
        'signature_en',
    ];

    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array',
    ];
}
