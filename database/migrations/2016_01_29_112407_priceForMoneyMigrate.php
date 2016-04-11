<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PriceForMoneyMigrate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configMigrations = Config::get('configMigrations.ecommerce.money');
        if ($configMigrations['multiple'] === true) {
            Schema::create('currencies', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('title');
                $table->string('code');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });

            Schema::create('products_currencies', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('currency_id')->unsigned();
                $table->integer('product_id')->unsigned();
                $table->float('pvp')->unsigned();
                $table->float('pvp_discounted')->unsigned();
                $table->float('iva')->unsigned();
                $table->timestamps();

                $table->unique(['product_id', 'currency_id']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            });

            Schema::table('products', function(Blueprint $table)
            {
                $table->dropColumn('pvp');
                $table->dropColumn('pvp_discounted');
                $table->dropColumn('iva');
            });

            Schema::create('shipping_costs_currencies', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('currency_id')->unsigned();
                $table->integer('shipping_costs_id')->unsigned();
                $table->float('pvp')->unsigned();
                $table->timestamps();

                $table->unique(['currency_id', 'shipping_costs_id']);
                $table->foreign('shipping_costs_id')->references('id')->on('shipping_costs')->onDelete('cascade');
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            });

            Schema::table('shipping_costs', function(Blueprint $table)
            {
                $table->dropColumn('pvp');
            });

            $this->insertCurrencies();
        }
    }

    private function insertCurrencies()
    {
        $currencies = [
            [
                'title' => 'Euro',
                'code' => '€'
            ],
            [
                'title' => 'Dolar',
                'code' => '$$'
            ],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->insert($currency);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $configMigrations = Config::get('configMigrations.ecommerce.money');
        if ($configMigrations['multiple'] === true) {
            Schema::table('products', function(Blueprint $table)
            {
                $table->float('pvp')->after('order')->unsigned();
                $table->float('pvp_discounted')->after('pvp')->unsigned();
                $table->float('iva')->after('pvp_discounted')->unsigned();
            });

            Schema::table('shipping_costs', function(Blueprint $table)
            {
                $table->float('pvp')->after('name')->unsigned();
            });
            Schema::drop('shipping_costs_currencies');
            Schema::drop('products_currencies');
            Schema::drop('currencies');
        }
    }

}
