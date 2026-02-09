<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBaseline extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'water_usage_liters', 'energy_usage_kwh', 'waste_generated_kg'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

