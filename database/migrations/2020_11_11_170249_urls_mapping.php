<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrlsMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls_mapping', function (Blueprint $table) {
            $table->id('__pk');
            $table->bigInteger('_fk_pk_eff_short_wordlist');
            $table->string('url');
            $table->string('description', 140);
            $table->enum('private', [0, 1]);
            $table->dateTime('created');

            $table->index(['_fk_pk_eff_short_wordlist', 'created']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('urls_mapping');
    }
}
