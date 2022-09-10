<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'note',
        'video',
        'file',
        'chapter_id',
    ];
    
  
}
