<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypingResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'wpm',
        'accuracy',
        'duration',
        'correct_chars',
        'total_chars',
    ];
}
