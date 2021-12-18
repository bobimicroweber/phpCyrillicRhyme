<?php
namespace App\Http\Controllers;

use App\SoundexBG;
use Illuminate\Support\Facades\Input;
use App\Word;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{

    public function autocomplete()
    {
        ini_set('memory_limit', '-1');

        $rhymeClassation = array();

        $getText = Input::get('text');
        $getText = trim($getText);
        $lines = explode('<br>', $getText);

        $getWord = '';
        if (isset($lines[array_key_last($lines)-1])) {
            $getWord = $lines[array_key_last($lines)-1];
            $getWord = trim($getWord);
            $getWord = explode(' ', $getWord);
            if (!empty($getWord)) {
                $getWord = last($getWord);
            }
        }

        if (empty($getWord)) {
            $getWord = explode(' ', $getText);
            $getWord = last($getWord);
        }

        $getWord = trim($getWord);
        $getWord = mb_strtolower($getWord);
        $getWord = str_replace('<br>', '', $getWord);

        $getWord = 'божидар';

        $rhymeClassation = [];

        $dbWords = Cache::rememberForever('words', function () {
            return Word::all();
        });

        $wordSSC = $this->getSoundlyAndSoundlessConsonants($getWord);
        foreach ($wordSSC as $desiredWord) {

            $desiredWordCombinations = $this->wordCombinations($desiredWord, 3);
            $desiredWordFirstSylable = $desiredWordCombinations[0];
            $desiredWordLastSylable = end($desiredWordCombinations);

            foreach ($dbWords as $word) {
                /*
                $wordCombinations = $this->wordCombinations($word, 3);
                $wordFirstSylable = $wordCombinations[0];
                $wordLastSylable = end($wordCombinations);*/

            }

        /*    foreach ($dbWords as $word) {
                $matchesCount = 0;

                $wordCombinations = $this->wordCombinations($word, 3);
                $wordFirstSylable = $wordCombinations[0];
                $wordLastSylable = end($wordCombinations);

                if ($desiredWordFirstSylable == $wordFirstSylable) {
                    $matchesCount++;
                }

                if ($desiredWordLastSylable == $wordLastSylable) {
                    $matchesCount++;
                }

               /* if ($matchesCount > 1) {
                    $rhymeClassation[] = array(
                        'word' => $word->word,
                        'level' => $matchesCount
                    );
                }
            }*/
        }

        array_multisort(array_map(function($element) {
            return $element['level'];
        }, $rhymeClassation), SORT_DESC, $rhymeClassation);

        return view('autocomplete', ['word'=>$getWord,'results'=>$rhymeClassation]);
    }

    public function search() {
         return view('welcome');
    }

}
