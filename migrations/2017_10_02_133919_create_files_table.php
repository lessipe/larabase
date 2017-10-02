<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table) {
            $table->increments('id');

            $table->string('file_name');
            $table->string('original_name');
            $table->integer('fileable_id')->unsigned();
            $table->string('fileable_type');
            $table->string('type')->nullable();
            $table->integer('rank')->unsigned();

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
		Schema::drop('files');
	}

}
