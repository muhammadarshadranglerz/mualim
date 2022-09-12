<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question', 'details', 'chapter_id', 'first_option',
        'second_option',
        'third_option',
        'fourth_option',
        'correct',
    ];
}
