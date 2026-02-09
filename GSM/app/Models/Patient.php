<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_image',
        'gender',
        'dob',
        'phone',
        'address',
        'blood_group'
    ];
}
