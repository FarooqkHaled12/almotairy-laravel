<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title_ar', 'title_en',
        'description_ar', 'description_en',
        'feature_title_ar', 'feature_title_en',
        'features_ar', 'features_en',
        'service_type_ar', 'service_type_en',
        'session_duration_ar', 'session_duration_en',
        'suitable_for_ar', 'suitable_for_en',
        'feature_text_ar', 'feature_text_en',
        'image',
    ];

    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array',
    ];
}
