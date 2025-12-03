<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'question',
        'correct_answer',
        'wrong_answer_1',
        'wrong_answer_2',
        'wrong_answer_3',
        'quiz_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
