<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'weight',
        'attribute',
        'description',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
