<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('movie_id')->unsigned();
			$table->integer('image_type_id')->unsigned();
			$table->float('aspect_ratio');
			$table->string('file_path');
			$table->integer('height');
			$table->integer('width');
			$table->string('iso_639_1');
			$table->float('vote_average');
			$table->integer('vote_count');

			$table->timestamps();

			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
			$table->foreign('image_type_id')->references('id')->on('image_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
		Schema::drop('image_types');
	}

}
