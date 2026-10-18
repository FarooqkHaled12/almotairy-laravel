<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_info';

    protected $fillable = [
        'phone',
        'email',
        'address_ar',
        'address_en',
        'facebook',
        'instagram',
        'youtube',
        'whatsapp',
    ];
}
