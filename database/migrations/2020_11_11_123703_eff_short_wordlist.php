<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EffShortWordlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eff_short_wordlist', function (Blueprint $table) {
            $table->id('__pk');
            $table->string('short_word');
            $table->enum('used', [0, 1]);
            $table->bigInteger('visited');

            $table->unique('short_word');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eff_short_wordlist');
    }
}
