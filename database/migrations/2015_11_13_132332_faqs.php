<?php

 use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Faqs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faqs = Config::get('configMigrations.faqs');
        if ($faqs === true) {
            Schema::create('faqs_categories', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('order');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('faqs_categories_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('faqs_categories_id')->unsigned();
                $table->string('locale')->index();

                $table->string('title');
                $table->longText('description');

                $table->timestamps();

                $table->unique(['faqs_categories_id', 'locale']);
                $table->foreign('faqs_categories_id')->references('id')->on('faqs_categories')->onDelete('cascade');
            });


            Schema::create('faqs', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('faqs_categories_id')->unsigned();
                $table->integer('order');
                $table->boolean('active')->default(1);
                $table->timestamps();

                $table->foreign('faqs_categories_id')->references('id')->on('faqs_categories');
            });

            Schema::create('faqs_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('faqs_id')->unsigned();
                $table->string('locale')->index();
                $table->string('question');
                $table->longText('answer');
                $table->timestamps();

                $table->unique(['faqs_id', 'locale']);
                $table->foreign('faqs_id')->references('id')->on('faqs')->onDelete('cascade');
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
        $faqs = Config::get('configMigrations.faqs');
        if ($faqs === true) {
            Schema::drop('faqs_translations');
            Schema::drop('faqs');
            Schema::drop('faqs_categories_translations');
            Schema::drop('faqs_categories');
        }
    }

}
