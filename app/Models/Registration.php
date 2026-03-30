<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $admission_for
 * @property string $applicant_name
 * @property string $dob
 * @property string $gender
 * @property string $social_category
 * @property string $aadhaar_no
 * @property string $email
 * @property string $present_class
 * @property string $present_school_name
 * @property string $admission_sought_for_class
 * @property string $father_name
 * @property string $father_phone
 * @property string $mother_name
 * @property string $address
 * @property string $reference_number
 * @property string $payment_screenshot
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Registration extends Model
{
    // app/Models/Registration.php
    protected $fillable = [
        // Student Info
        'admission_for',
        'applicant_name',
        'dob',
        'gender',
        'blood_group',
        'only_child',
        'social_category',
        'nationality',
        'bpl',
        'cwsn',
        'aadhaar_no',
        'udise_no',
        'pen_no',
        'email',
        'present_class',
        'present_school_name',
        'present_school_address',
        'admission_sought_for_class',

        // Academic Info
        "total_subjects",
        "total_marks_obtained",
        "full_marks",
        'last_exam_percentage',


        // Parent Info
        'parents_category',
        'parents_category_b',
        'father_name',
        'father_occupation',
        'father_phone',
        'mother_name',
        'mother_occupation',
        'mother_phone',
        'annual_income',

        // Current Address
        'c_street_area_locality',
        'c_village_town',
        'c_post_office',
        'c_pin_code',
        'c_house_no',
        'c_state',
        'c_district',

        // Permanent Address
        'p_street_area_locality',
        'p_village_town',
        'p_post_office',
        'p_pin_code',
        'p_house_no',
        'p_state',
        'p_district',

        // File Uploads (UUID filenames only)
        'payment_screenshot',
        'reference_number',
    ];

}
