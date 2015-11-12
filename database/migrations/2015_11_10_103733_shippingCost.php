<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingCost extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zones', function($table)
        {
            $table->increments('id');
            $table->string('name', 255)->unique();
            $table->timestamps();
        });

        Schema::create('shipping_countries', function($table)
        {
            $table->increments('id');
            $table->string('code', 5);
            $table->string('name', 255);
            $table->integer('shipping_zone_id')->unsigned();
            $table->timestamps();

            $table->foreign('shipping_zone_id')->references('id')->on('shipping_zones');
        });

        $this->insertZones();
        $this->insertCountries();

        Schema::create('shipping_costs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 55);
            $table->float('pvp');
            $table->float('min_pvp');
            $table->float('max_pvp');
            $table->integer('shipping_zone_id')->unsigned();
            $table->boolean('activated')->default(0);
            $table->timestamps();

            $table->foreign('shipping_zone_id')->references('id')->on('shipping_zones');
        });
    }

    private function insertZones()
    {
        $zones = json_decode(file_get_contents(__DIR__ . '/zones.php'));

        foreach ($zones as $zone) {
            DB::table('shipping_zones')->insert(array(
                'name' => $zone->name
            ));
        }
    }

    private function insertCountries()
    {
        $countries = json_decode(file_get_contents(__DIR__ . '/countries.php'));

        foreach ($countries as $country) {
            DB::table('shipping_countries')->insert(array(
                'code' => $country->code,
                'name' => $country->name,
                'shipping_zone_id' => $country->zone_id
            ));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shipping_zones');
        Schema::drop('shipping_countries');
        Schema::drop('shipping_costs');
    }

}
