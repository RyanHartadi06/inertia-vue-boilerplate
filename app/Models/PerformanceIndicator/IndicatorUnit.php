<?php

namespace App\Models\PerformanceIndicator;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorUnit extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'name'
    ];
}
