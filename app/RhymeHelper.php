<?php

namespace App;

class RhymeHelper
{
    public static function wordCombinations($word, $combinationNumbers = 3) {

        $combinations = array();

        $alphabets = self::split($word);
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

    public static function split($str, $len = 1)
    {
        $arr = [];
        $length = mb_strlen($str, 'UTF-8');

        for ($i = 0; $i < $length; $i += $len) {

            $arr[] = mb_substr($str, $i, $len, 'UTF-8');
        }

        return $arr;
    }

    public static function getSoundlyAndSoundlessConsonants($getWord)
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


    public static function soundlyAndSoundlessConsonants()
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
