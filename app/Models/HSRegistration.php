<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $stream
 * @property string $pre_borad_percentage
 * @property string $father_name
 * @property string $mother_name
 * @property string $dob
 * @property string $gender
 * @property string $last_school
 * @property string $contact_number
 * @property string $email
 * @property string $address
 * @property string $reason_of_interest
 * @property string $pen_number
 * @property string $apaar_id
 * @property string $parents_contact_number
 * @property string $whatsapp
 * @property string $reference_number
 * @property string $payment_screenshot
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
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
        'reference_number',
        'payment_screenshot',
    ];

    protected $casts = [
        'dob' => 'date',
    ];
}
