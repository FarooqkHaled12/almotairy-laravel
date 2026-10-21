<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'interest',
        'message',
        'locale',
        'status',
        'property_id',
        'preferred_visit_at',
        'preferred_location',
        'preferred_category_id',
        'budget_min',
        'budget_max',
        'area_min',
        'area_max',
    ];

    protected $casts = [
        'preferred_visit_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function preferredCategory(): BelongsTo
    {
        return $this->belongsTo(PropertyCategory::class, 'preferred_category_id');
    }
}
