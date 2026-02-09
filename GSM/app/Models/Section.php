<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'section_name',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // ❌ Ye hata do (kyunki medals table me section_id column nahi hai)
    // public function medals()
    // {
    //     return $this->hasOne(Medal::class, 'section_id');
    // }
}
