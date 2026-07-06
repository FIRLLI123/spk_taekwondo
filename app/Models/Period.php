<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function topsisResults()
    {
        return $this->hasMany(TopsisResult::class);
    }

    public function getDateRangeAttribute()
    {
        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }
}
