<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Word;
use App\DerivativeForm;

class RefreshWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'words:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh words';

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
        ini_set('memory_limit', '-1');

        $words = Word::get();
        foreach ($words as $word) {
            Word::saveWord($word->name);
        }

        echo 1;
    }

}
