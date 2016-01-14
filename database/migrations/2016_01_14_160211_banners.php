<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Banners extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$banners = Config::get('configMigrations.banners');
		if ($banners === true) {

			Schema::create('banners', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name');
				$table->string('text');
				$table->string('link');
				$table->string('image');
				$table->integer('priority');
				$table->boolean('active')->default(1);
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$banners = Config::get('configMigrations.banners');
		if ($banners === true) {
			Schema::drop('banners');
		}
	}
}