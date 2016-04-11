<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = Config::get('configMigrations.ecommerce.categories');
        if ($categories === true) {
            Schema::create('categories', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('parent')->unsigned();
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('categories_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('categories_id')->unsigned();
                $table->integer('parent')->unsigned();
                $table->string('locale')->index();

                $table->string('title');
                $table->longText('description');
                $table->text('meta_title');
                $table->longText('meta_description');
                $table->string('slug');

                $table->timestamps();

                $table->unique(['categories_id', 'locale']);
                $table->unique(['parent', 'locale', 'title']);
                $table->unique(['parent', 'locale', 'slug']);
                $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');
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
        $categories = Config::get('configMigrations.ecommerce.categories');
        if ($categories === true) {
            Schema::drop('categories_translations');
            Schema::drop('categories');
        }
    }

}
