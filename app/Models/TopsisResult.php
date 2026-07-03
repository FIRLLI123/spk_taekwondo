<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopsisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'athlete_id',
        'preference_value',
        'positive_distance',
        'negative_distance',
        'rank',
        'calculation_detail',
    ];

    protected $casts = [
        'calculation_detail' => 'array',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
