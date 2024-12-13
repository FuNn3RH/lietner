<?php

namespace App\Models;

use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model {
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "word_id",
        "value",
    ];

    public function word() {
        return $this->belongsTo(Word::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
