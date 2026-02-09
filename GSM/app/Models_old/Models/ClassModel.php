<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'school_id',
        'class_name',
        'section',
        'total_students',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function actions()
    {
        return $this->hasMany(StudentAction::class, 'class_id');
    }
}
