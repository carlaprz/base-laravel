<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class News extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $news = Config::get('configMigrations.news');

        if ($news === true) {

            Schema::create('news', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('image');
                $table->integer('order');
                $table->datetime('publish');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('news_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('news_id')->unsigned();
                $table->string('locale')->index();

                $table->string('title');
                $table->longText('description');
                $table->string('slug');
                $table->timestamps();

                $table->unique(['news_id', 'locale']);
                $table->unique(['title', 'locale']);
                $table->unique(['slug', 'locale']);
                $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
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
        $news = Config::get('configMigrations.news');

        if ($news === true) {

            Schema::drop('news_translations');
            Schema::drop('news');
        }
    }

}
