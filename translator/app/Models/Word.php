<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model {
    use SoftDeletes;

    protected $fillable = [
        "name",
        "examples",
        "synonym",
        "audios",
        'source',
    ];

    protected function casts() {
        return [
            'audios' => 'array',
            'examples' => 'array',
            'synonym' => 'array',
        ];
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
