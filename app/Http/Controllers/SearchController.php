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

    private function getSoundlyAndSoundlessConsonants($getWord)
    {
        $wordSSC = [];
        $wordSSC[] = $getWord;
        $syllables = $this->soundlyAndSoundlessConsonants();

        foreach($syllables as $syllable=>$secondSyllable) {

            $replacedWord = str_replace($syllable, $secondSyllable, $getWord);
            if ($replacedWord !== $getWord) {
                $wordSSC[] = $replacedWord;
            }

            $replacedWord = str_replace($secondSyllable, $syllable, $getWord);
            if ($replacedWord !== $getWord) {
                $wordSSC[] = $replacedWord;
            }

        }

        return $wordSSC;
    }


    private function soundlyAndSoundlessConsonants()
    {
        return [
            "ба"=>"па",
            "бъ"=>"пъ",
            "бо"=>"по",
            "бу"=>"пу",
            "бе"=>"пе",
            "би"=>"пи",

            "ва"=>"фа",
            "въ"=>"фъ",
            "во"=>"фо",
            "ву"=>"фу",
            "ве"=>"фе",
            "ви"=>"фи",

            "да"=>"та",
            "дъ"=>"тъ",
            "до"=>"то",
            "ду"=>"ту",
            "де"=>"те",
            "ди"=>"ти",

            "за"=>"са",
            "зъ"=>"съ",
            "зо"=>"со",
            "зу"=>"су",
            "зе"=>"се",
            "зи"=>"си",

            "жа"=>"ша",
            "жъ"=>"шъ",
            "жо"=>"шо",
            "жу"=>"шу",
            "же"=>"ше",
            "жи"=>"ши",

            "га"=>"ка",
            "гъ"=>"къ",
            "го"=>"ко",
            "гу"=>"ку",
            "ге"=>"ке",
            "ги"=>"ки",

        ];
    }

}
