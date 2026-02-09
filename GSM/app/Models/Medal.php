<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Medal extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'class_id', 'section_id','medal_type', 'performance_percentage'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
