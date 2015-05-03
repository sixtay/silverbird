<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('poster_path');
			$table->string('backdrop_path');
			
			$table->timestamps();
		});


		Schema::create('movies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('adult');
			$table->string('backdrop_path');
			$table->integer('collection_id')->unsigned();
			$table->integer('budget');
			$table->string('homepage');
			$table->integer('provider_id');
			$table->integer('imdb_id');
			$table->string('original_language');
			$table->longtext('overview');
			$table->decimal('popularity', 18, 15);
			$table->string('poster_path');
			$table->date('release_date');
			$table->integer('revenue');
			$table->integer('runtime');
			$table->string('status');
			$table->string('tagline');
			$table->string('string');
			$table->boolean('video');
			$table->decimal('vote_average', 3, 1);
			$table->integer('vote_count');
			$table->timestamps();

			$table->foreign('collection_id')->references('id')->on('collections');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movies');
		Schema::drop('collections');

	}

}
