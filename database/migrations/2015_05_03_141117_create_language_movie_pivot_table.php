<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageMoviePivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('language_movie', function(Blueprint $table)
		{
			$table->integer('language_id')->unsigned()->index();
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
			$table->integer('movie_id')->unsigned()->index();
			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('language_movie');
	}

}
