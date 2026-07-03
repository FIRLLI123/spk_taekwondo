<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'athlete_id',
        'criterion_id',
        'user_id',
        'score',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
