<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DomainTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'bronze_threshold',
        'silver_threshold',
        'gold_threshold',
        'unit',
        'notes'
    ];
}

