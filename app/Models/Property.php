<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

protected $fillable = [
    'category_id',
    'is_building', 'building_id',
    'name_ar', 'name_en',
    'area_ar', 'area_en',
    'description_ar', 'description_en',
    'features_ar', 'features_en',
    'phone', 'whatsapp',
    'location_ar', 'location_en',
    'legal_status_ar', 'legal_status_en',
    'payment_system_ar', 'payment_system_en',
    'image_1', 'image_2', 'image_3', 'image_4',
];


    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array',
        'is_building' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }

    public function building()
    {
        return $this->belongsTo(self::class, 'building_id');
    }

    public function units()
    {
        return $this->hasMany(self::class, 'building_id');
    }
}
