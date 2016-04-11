<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsRelatedMigrate extends Migration
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
                $table->increments('id');
                $table->integer('product_id')->unsigned();
                $table->integer('product_id_related')->unsigned();
              
                $table->unique(['product_id', 'product_id_related']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('product_id_related')->references('id')->on('products')->onDelete('cascade');
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
