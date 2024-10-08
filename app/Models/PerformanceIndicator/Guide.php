<?php

namespace App\Models\PerformanceIndicator;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Guide extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'name',
        'description',
        'file'
    ];

    protected $appends = [
        'short_description',
        'file_url'
    ];

    public function getFileUrlAttribute()
    {
        return $this->file ? URL::to('storage/' . $this->file) : null;
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 30);
    }
}
