<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrailersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trailer_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('url');
			$table->timestamps();
		});


		Schema::create('trailers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('movie_id')->unsigned();
			$table->integer('trailer_type_id')->unsigned();
			$table->string('name');
			$table->string('size');
			$table->string('source');
			$table->string('type');
			$table->timestamps();

			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
			$table->foreign('trailer_type_id')->references('id')->on('trailer_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trailers');
		Schema::drop('trailer_types');
	}

}
