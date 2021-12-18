<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RhymeHelper;

class Word extends Model
{
    protected $casts = [
        'similar_sounding'=>'json',
        'word_combinations'=>'json',
        'soundly_syllables'=>'json'
    ];

    public static function saveWord($word) {

        $findWord = Word::where('word', $word)->first();
        if ($findWord == null) {

            $wordCombinations = RhymeHelper::wordCombinations($word, 3);
            if (!isset($wordCombinations[0])) {
                return;
            }

            $wordFirstSylable = $wordCombinations[0];
            $wordLastSylable = end($wordCombinations);

            $wordModel = new Word();
            $wordModel->word = $word;
            $wordModel->first_syllable = $wordFirstSylable;
            $wordModel->last_syllable = $wordLastSylable;
            $wordModel->word_combinations = $wordCombinations;
            $wordModel->similar_sounding = RhymeHelper::getSimilarSounding($word);
            $wordModel->save();
        }

    }
}
