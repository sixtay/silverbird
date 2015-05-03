<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryMoviePivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('country_movie', function(Blueprint $table)
		{
			$table->integer('country_id')->unsigned()->index();
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
		Schema::drop('country_movie');
	}

}
