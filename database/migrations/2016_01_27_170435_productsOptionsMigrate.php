<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsOptionsMigrate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $configMigrations = Config::get('configMigrations.ecommerce.products_options');
        if ($configMigrations['size'] === true) {
            Schema::create('sizes', function(Blueprint $table)
            {
                $table->increments('id');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('sizes_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('sizes_id')->unsigned();
                $table->string('locale')->index();
                $table->string('title');
                $table->timestamps();

                $table->unique(['sizes_id', 'locale']);
                $table->unique(['title', 'locale']);

                $table->foreign('sizes_id')->references('id')->on('sizes')->onDelete('cascade');
            });


            Schema::create('products_sizes', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('product_id')->unsigned();
                $table->integer('size_id')->unsigned();

                $table->unique(['size_id', 'product_id']);

                $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }
        if ($configMigrations['colour'] === true) {
            Schema::create('colours', function(Blueprint $table)
            {
                $table->increments('id');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('colours_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('colours_id')->unsigned();
                $table->string('locale')->index();
                $table->string('title');
                $table->timestamps();

                $table->unique(['colours_id', 'locale']);
                $table->unique(['title', 'locale']);

                $table->foreign('colours_id')->references('id')->on('colours')->onDelete('cascade');
            });

            Schema::create('products_colours', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('product_id')->unsigned();
                $table->integer('colour_id')->unsigned();

                $table->unique(['colour_id', 'product_id']);

                $table->foreign('colour_id')->references('id')->on('colours')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        $configMigrations = Config::get('configMigrations.ecommerce.products_options');
        if ($configMigrations['size'] === true) {

            Schema::drop('products_sizes');
            Schema::drop('sizes_translations');
            Schema::drop('sizes');
        }

        if ($configMigrations['colour'] === true) {

            Schema::drop('products_colours');

            Schema::drop('colours_translations');
            Schema::drop('colours');
        }
    }

}
