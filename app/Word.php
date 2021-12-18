<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $casts = [
        'word_combinations'=>'json',
        'soundly_syllables'=>'json'
    ];
}
