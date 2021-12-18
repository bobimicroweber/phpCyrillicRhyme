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
