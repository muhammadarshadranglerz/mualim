<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'subject_id',
    ];

    /**
     * Get the user that owns the Chapter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get all of the comments for the Chapter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function content()
    {
        return $this->hasMany(ChapterContent::class, 'chapter_id');
    }
    public function quiz()
    {
        return $this->hasMany(Question::class, 'chapter_id');
    }
}
