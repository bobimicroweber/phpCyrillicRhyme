<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RhymeHelper;

class Word extends Model
{
    public static function saveWord($word) {

        $wordModel = Word::where('word', $word)->first();
        if ($wordModel == null) {
            $wordModel = new Word();
        }

        $wordCombinations = RhymeHelper::wordCombinations($word, 4);
        if (!isset($wordCombinations[0])) {
            return;
        }

        $wordFirstSylable = $wordCombinations[0];
        $wordLastSylable = end($wordCombinations);

        $wordModel->word = $word;
        $wordModel->first_syllable = $wordFirstSylable;
        $wordModel->last_syllable = $wordLastSylable;
        $wordModel->word_combinations = implode('|',$wordCombinations);
        $wordModel->similar_sounding = implode('|',RhymeHelper::getSimilarSounding($word));
        $wordModel->save();


    }
}
