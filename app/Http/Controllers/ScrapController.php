<?php
namespace App\Http\Controllers;

use App\SoundexBG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Word;
use Illuminate\Support\Facades\Cache;
use App\RhymeHelper;

class ScrapController extends Controller
{

    public function index()
    {

        $words = $this->scrapWord();
        if (!empty($words)) {
            foreach ($words as $word) {
               Word::saveWord($word);
            }
        }

        echo '<meta http-equiv="refresh" content="1">';

    }

    private function scrapWord($word = false) {

        if ($word) {
            $url = 'https://rechnik.chitanka.info/w/' . urlencode($word);
        } else {
            $url = 'https://rechnik.chitanka.info/random';
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);

        $dom = new \DOMDocument();
        $dom->loadHTML($content);

        $words = [];
        $aTags = $dom->getElementsByTagName('a');
        foreach ($aTags as $aLinks) {
            $href = $aLinks->getAttribute('href');
            if (strpos($href, '/w/') !== false) {
                $aLinkWord = $aLinks->nodeValue;
                if (strpos($aLinkWord, '-') !== false) {
                    $aLinkWord = str_replace('-',false,$aLinkWord);
                    $aLinkWord = trim($aLinkWord);
                    $aLinkWord = mb_strtolower($aLinkWord);
                    $words[] = $aLinkWord;
                }
            }
        }

        return $words;

    }
}
