<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('words', function (Blueprint $table) {
    		$table->bigIncrements('id');
    		$table->string('word')->unique();
    		$table->longText('word_combinations')->nullable();
    		$table->longText('similar_sounding')->nullable();
    		$table->string('first_syllable')->nullable();
    		$table->string('last_syllable')->nullable();
    		$table->longText('soundly_syllables')->nullable();
    		$table->timestamps();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
