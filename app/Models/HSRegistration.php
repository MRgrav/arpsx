<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HSRegistration extends Model
{
    protected $fillable = [
        'name',
        'stream',
        'pre_borad_percentage',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'last_school',
        'contact_number',
        'email',
        'address',
        'reason_of_interest',
        'pen_number',
        'apaar_id',
        'parents_contact_number',
        'whatsapp',
    ];

    protected $casts = [
        'dob' => 'date',
    ];
}
