<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfoTwo extends Model
{
    use HasFactory;

    protected $table = 'contact_info_two';

    protected $fillable = [
        'working_hours',
        'phone_1', 'phone_2',
        'email_1', 'email_2', 'email_3',
        'address_ar', 'address_en',
        'whatsapp',
    ];
}
