<?php

namespace App\Models\PerformanceIndicator;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'year',
        'weight',
        'direction_weight',
        'status'
    ];

    public function scopeActive()
    {
        return $this->where('status', 1);
    }
}
