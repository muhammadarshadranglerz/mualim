<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'chapter_id',
        'score',
    ];
}