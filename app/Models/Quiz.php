<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
