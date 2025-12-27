<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'share_token',
    ];

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ensureShareToken()
    {
        if ($this->share_token) {
            return $this->share_token;
        }

        $token = Str::uuid()->toString();
        $this->share_token = $token;
        $this->save();

        return $token;
    }

    public static function findByShareToken($token)
    {
        return static::where('share_token', $token)->first();
    }
}
