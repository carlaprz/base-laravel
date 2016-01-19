<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsRelated extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = Config::get('configMigrations.ecommerce.products_related');

        if ($products === true) {
            Schema::create('products_related', function(Blueprint $table)
            {
                $table->integer('product_id')->unsigned();
                $table->integer('related')->unsigned();
                $table->integer('order');
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products');
                $table->foreign('related')->references('id')->on('products');

                $table->unique(['product_id', 'related']);
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
        $products = Config::get('configMigrations.ecommerce.products_related');
        if ($products) {
            Schema::drop('products_related');
        }
    }

}
