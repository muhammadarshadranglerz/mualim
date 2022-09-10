<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterScore extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_marks',
        'obtained_marks',
        'user_id',
        'subject_id',
        'chapter_id',
    ];
}
