<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('image');
            $table->string('thumb');
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('products_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('products_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');
            $table->longText('description');
            $table->longText('description_sheet');
            $table->text('data_sheet')->nullable();
            $table->text('data_comercial')->nullable();
            $table->text('data_iom')->nullable();
            $table->text('data_drawing')->nullable();
            $table->string('slug');

            $table->timestamps();

            $table->unique(['products_id', 'locale']);
            $table->unique(['title', 'locale']);
            $table->unique(['slug', 'locale']);
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_translations');
        Schema::drop('products');
    }

}
