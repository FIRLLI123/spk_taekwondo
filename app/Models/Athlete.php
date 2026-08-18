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

    public static function generateNextCode(): string
    {
        $lastCode = static::query()
            ->where('code', 'LIKE', 'A%')
            ->orderBy('id', 'desc')
            ->value('code');

        if (!$lastCode) {
            return 'A001';
        }

        if (preg_match('/^([A-Z]+)(\d+)$/i', $lastCode, $matches)) {
            $prefix = $matches[1];
            $number = (int) $matches[2] + 1;
            $digits = max(3, strlen($matches[2]));
            return $prefix . str_pad($number, $digits, '0', STR_PAD_LEFT);
        }

        $count = static::count() + 1;
        return 'A' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
