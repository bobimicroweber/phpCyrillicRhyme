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

       // $getWord = 'Инкубатор';

        $rhymeClassation = [];

        if (!empty($getWord)) {

            $getWordCombinations = $this->wordCombinations($getWord, 3);

            $dbWords = Cache::rememberForever('words', function () {
                return Word::all();
            });

            foreach ($dbWords as $word) {

                if ($word->word == $getWord) {
                    continue;
                }

                $matchesCount = 0;
                $dbWordCombinations = $this->wordCombinations($word->word, 3);
                if (empty($dbWordCombinations)) {
                    continue;
                }
                foreach ($dbWordCombinations as $dbWordCombination) {
                    $dbWordCombination = mb_strtolower($dbWordCombination);
                    foreach ($getWordCombinations as $getWordCombination) {
                        $getWordCombination = mb_strtolower($getWordCombination);
                        if ($getWordCombination == $dbWordCombination) {
                            $matchesCount++;
                        }
                    }
                }
                if (end($dbWordCombinations) == end($getWordCombinations)) {
                    $matchesCount = $matchesCount + 2;
                }
                if ($dbWordCombinations[0] == $getWordCombinations[0]) {
                    $matchesCount = $matchesCount + 2;
                }
                if ($matchesCount > 1) {
                    $rhymeClassation[] = array(
                        'word' => $word->word,
                        'level' => $matchesCount
                    );
                }
            }

            array_multisort(array_map(function($element) {
                return $element['level'];
            }, $rhymeClassation), SORT_DESC, $rhymeClassation);
        }

        return view('autocomplete', ['word'=>$getWord,'results'=>$rhymeClassation]);
    }
    public function search() {
         return view('welcome');
    }

	private function wordCombinations($word, $combinationNumbers = 3) {

		$combinations = array();

		$alphabets = $this->split($word);
		$i=0;
		foreach ($alphabets as $alpha) {
			$i++;

			if (!isset($alphabets[$i])) {
				continue;
			}

			if ($combinationNumbers > 2) {
				if (!isset($alphabets[$i+1])) {
					continue;
				}
			}

			if ($combinationNumbers > 3) {
				if (!isset($alphabets[$i+2])) {
					continue;
				}
			}

			if ($combinationNumbers > 4) {
				if (!isset($alphabets[$i+3])) {
					continue;
				}
			}

			$readyAlpha = $alpha . $alphabets[$i];

			if ($combinationNumbers > 2) {
				$readyAlpha .= $alphabets[$i+1];
			}

			if ($combinationNumbers > 3) {
				$readyAlpha .= $alphabets[$i+2];
			}

			if ($combinationNumbers > 4) {
				$readyAlpha .= $alphabets[$i+3];
			}

			$combinations[] = $readyAlpha;
		}

		return $combinations;
	}

	private function split($str, $len = 1)
	{
		$arr = [];
		$length = mb_strlen($str, 'UTF-8');

		for ($i = 0; $i < $length; $i += $len) {

			$arr[] = mb_substr($str, $i, $len, 'UTF-8');
		}

		return $arr;
	}
}
