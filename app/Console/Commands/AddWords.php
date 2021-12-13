<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Word;

class AddWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'words:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add words in wordlist';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $wordList = [];

    	$wordList1 = $this->_getWordlistFromFile('bg-idioms-cyrillic.txt');
    	$wordList2 = $this->_getWordlistFromFile('bg-jargon-cyrillic.txt');
    	$wordList3 = $this->_getWordlistFromFile('bg-neologisms-cyrillic.txt');
    	$wordList4 = $this->_getWordlistFromFile('bg-obscene-cyrillic.txt');

        $wordList = array_merge($wordList, $wordList1);
        $wordList = array_merge($wordList, $wordList2);
        $wordList = array_merge($wordList, $wordList3);
        $wordList = array_merge($wordList, $wordList4);

    	$databaseWords = array();
    	foreach(Word::all() as $word) {
    		$databaseWords[] = $word->word;
    	}

    	foreach($wordList as $word) {

            $word = trim($word);

    		$searchWord = array_search($word, $databaseWords);

    		if (!$searchWord) {

                try {
                    $wordModel = new Word();
                    $wordModel->word = $word;
                    $wordModel->save();
                    // echo $word . PHP_EOL;
                } catch (\Exception $e) {

                }
    		}


    	}

    }

    private function _getWordlistFromFile($file)
    {
    	$words = array();
    	$wordList = file_get_contents(storage_path($file));

    	foreach(explode(PHP_EOL, $wordList) as $word) {

    		$word = trim($word);

    		if (empty($word)) {
    			continue;
    		}

    		$words[] = $word;
    	}

    	return $words;
    }
}
