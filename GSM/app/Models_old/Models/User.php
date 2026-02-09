<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'school_id',
        'class_id',
        'name',
        'email',
        'password',
        // 'phone',
        // 'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relation: One user can be a Green Captain of many schools.
     */
    public function schools()
    {
        return $this->hasMany(School::class, 'green_captain_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

}
