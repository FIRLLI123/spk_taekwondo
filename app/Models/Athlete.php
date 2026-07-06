<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'gender',
        'birth_date',
        'age',
        'belt_level',
        'competition_class',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function topsisResults()
    {
        return $this->hasMany(TopsisResult::class);
    }

    public function getDisplayNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }
}
