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

                $table->string('image');
                $table->string('thumb');
                $table->boolean('active')->default(1);

                $table->timestamps();
            });

            $categories = Config::get('configMigrations.ecommerce.categories');
            if ($categories) {
                Schema::table('products', function(Blueprint $table)
                {
                    $table->integer('category_id')->unsigned();
                    $table->foreign('category_id')->references('id')->on('categories');
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
                $table->foreign('products_id')->references('id')->on('products');
            });

            $cart = Config::get('configMigrations.ecommerce.cart');
            if ($cart) {
                Schema::create('products_salable', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('products_id')->unsigned();

                    $table->float('pvp')->unsigned();
                    $table->float('pvp_discounted')->unsigned();
                    $table->float('iva')->unsigned();

                    $table->timestamps();
                    $table->foreign('products_id')->references('id')->on('products');
                });
            }
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
            $cart = Config::get('configMigrations.ecommerce.cart');
            if ($cart) {
                Schema::drop('products_salable');
            }
            Schema::drop('products');
        }
    }

}
