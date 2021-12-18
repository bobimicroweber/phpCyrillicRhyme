<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Word;
use App\DerivativeForm;

class ConvertWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'words:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert words';

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

        $derivativeForms = DerivativeForm::get();
        foreach ($derivativeForms as $derivativeWord) {
            Word::saveWord($derivativeWord->name);
        }

        echo 1;
    }

}
