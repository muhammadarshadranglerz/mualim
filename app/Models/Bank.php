<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = [ ];

    public function historys()
    {
        return $this->hasMany(Transaction_history::class, 'bank_id', 'id');
    }

}
