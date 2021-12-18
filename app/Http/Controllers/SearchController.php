<?php
namespace App\Http\Controllers;

use App\SoundexBG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Word;
use Illuminate\Support\Facades\Cache;
use App\RhymeHelper;

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

    //    $getWord = 'божидар';

        $rhymeClassation = [];

        $wordSSC = RhymeHelper::getSimilarSounding($getWord);
        dump($wordSSC);

        foreach ($wordSSC as $desiredWord) {

            $desiredWordCombinations =  RhymeHelper::wordCombinations($desiredWord, 3);
            $desiredWordFirstSylable = $desiredWordCombinations[0];
            $desiredWordLastSylable = end($desiredWordCombinations);

            $findRhymes = Word::
                    where('last_syllable',$desiredWordLastSylable)
                   // ->where('first_syllable',$desiredWordFirstSylable)
                ->get();
            if ($findRhymes->count() > 0) {
                foreach ($findRhymes as $word) {
                    $rhymeClassation[$word->id] = array(
                        'word' => $word->word,
                        'level' => 0
                    );
                }
            }

        }

        array_multisort(array_map(function($element) {
            return $element['level'];
        }, $rhymeClassation), SORT_DESC, $rhymeClassation);

        return view('autocomplete', ['word'=>$getWord,'results'=>$rhymeClassation]);
    }

    public function addWords() {

        return view('add-words');
    }

    public function saveWords(Request $request) {

        $text = $request->get('text');
        $text = mb_strtolower($text);
        $text = str_replace(',','',$text);
        $text = str_replace('!','',$text);
        $text = str_replace('.','',$text);
        $text = str_replace('-','',$text);
        $text = str_replace(':','',$text);
        $words = explode(' ', $text);

        $readyWords = [];
        foreach ($words as $word) {
            if (mb_strlen($word) > 3) {
                $word = mb_strtolower($word);
                $readyWords[] = $word;
            }
        }

        if (!empty($readyWords)) {
            foreach ($readyWords as $word) {
                Word::saveWord($word);
            }
        }

        return redirect(route('add-words'));
    }

    public function search() {
         return view('welcome');
    }

}
