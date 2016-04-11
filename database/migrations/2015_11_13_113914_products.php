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
        $products = Config::get('configMigrations.ecommerce.products');
        if ($products === true) {
            Schema::create('products', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('reference');
                $table->string('image');
                $table->string('thumb');
                $table->integer('order');
                $table->float('pvp')->unsigned();
                $table->float('pvp_discounted')->unsigned();
                $table->float('iva')->unsigned();
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            $categories = Config::get('configMigrations.ecommerce.categories');
            if ($categories) {
                Schema::table('products', function(Blueprint $table)
                {
                    $table->integer('category_id')->unsigned();
                    $table->foreign('category_id')->references('id')->on('categories');
                    $table->unique(['reference']);
                });
            }

            Schema::create('products_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('products_id')->unsigned();
                $table->string('locale')->index();

                $table->string('title');
                $table->longText('description');

                $table->string('slug');
                $table->timestamps();

                $table->unique(['products_id', 'locale']);
                $table->unique(['title', 'locale']);
                $table->unique(['slug', 'locale']);
                $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
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
        $products = Config::get('configMigrations.ecommerce.products');
        if ($products) {
            Schema::drop('products_translations');
            Schema::drop('products');
        }
    }

}
