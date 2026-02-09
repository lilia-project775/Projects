<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'green_captain_id',
        'school_name',
        'address',
        'district_region',
        'contact_person',
        'email',
        'phone',
        'password',
        'password_words',
        'type',
        // 'total_classes',
        'logo',
        // 'map_pin'
    ];
  
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'school_id');
    }

  public function baselines()
{
    return $this->hasMany(SchoolBaseline::class, 'school_id');
}
 
    public function baseline()
    {
        return $this->hasOne(SchoolBaseline::class);
    }
    
  

    public function greenCaptain()
    {
        return $this->belongsTo(User::class, 'green_captain_id');
    }

    public function actions()
    {
        return $this->hasMany(StudentAction::class);
    }

    public function medal()
    {
        return $this->hasOne(Medal::class);
    }
    
}
