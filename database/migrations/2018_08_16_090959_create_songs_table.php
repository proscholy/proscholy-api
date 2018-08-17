<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('songs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 191)->nullable();
			$table->text('licence_content', 65535)->nullable();
			$table->integer('licence_type')->nullable();
			$table->boolean('visible')->nullable();
			$table->boolean('approved')->nullable();
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
		Schema::drop('songs');
	}

}
