<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RhymeHelper;

class Word extends Model
{
    protected $casts = [
        'word_combinations'=>'json',
        'soundly_syllables'=>'json'
    ];

    public static function saveWord($word) {

        $wordCombinations = RhymeHelper::wordCombinations($word, 3);
        $wordFirstSylable = $wordCombinations[0];
        $wordLastSylable = end($wordCombinations);

        $findWord = Word::where('word', $word)->first();
        if ($findWord == null) {
            $wordModel = new Word();
            $wordModel->word = $word;
            $wordModel->first_syllable = $wordFirstSylable;
            $wordModel->last_syllable = $wordLastSylable;
            $wordModel->word_combinations = $wordCombinations;
            $wordModel->save();
        }

    }
}
