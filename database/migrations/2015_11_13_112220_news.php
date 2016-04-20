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

            Schema::create('news_categories', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('order');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('news_categories_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('news_cat_trans_id')->unsigned();
                $table->string('locale')->index();
                $table->string('slug');

                $table->string('title');
                $table->longText('description');

                $table->timestamps();

                $table->unique(['news_cat_trans_id', 'locale']);
                $table->foreign('news_cat_trans_id')->references('id')->on('news_categories')->onDelete('cascade');
            });

            Schema::create('news', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('news_categories_id')->unsigned();
                $table->string('image');
                $table->integer('order');
                $table->datetime('publish');
                $table->boolean('active')->default(1);
                $table->timestamps();

                $table->foreign('news_categories_id')->references('id')->on('news_categories')->onDelete('cascade');
            });

            Schema::create('news_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('news_id')->unsigned();
                $table->string('locale')->index();
                $table->string('title');
                $table->string('description')->nullable();
                $table->longText('content');
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
            Schema::drop('news_categories_translations');
            Schema::drop('news_categories');
            
            
        }
    }

}
