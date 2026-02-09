<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'section_id',
        'school_id',
        'domain',
        'unit',
        'amount_saved'
    ];

    // ✅ Relations
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
}
