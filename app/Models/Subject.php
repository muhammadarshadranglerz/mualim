<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'thumbnail',
        'description',
    ];
    /**
     * Get all of the comments for the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(User::class, 'subject_id');
    }


    public function chapter()
    {
        return $this->hasMany(Chapter::class, 'subject_id')->orderBy('chapter_no');
    }
}
