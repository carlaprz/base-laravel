<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartShippingPaymentsCouponsOrders extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ecommerce = Config::get('configMigrations.ecommerce');

        if ($ecommerce['cart']) {
           
            Schema::create('carts', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });

            Schema::create('carts_products', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('cart_id')->unsigned();
                $table->integer('products_salable_id')->unsigned();
                $table->text('product_description');
                $table->integer('cant')->unsigned();
                $table->timestamps();
                $table->foreign('cart_id')->references('id')->on('carts');
                $table->foreign('products_salable_id')->references('id')->on('products_salable');
            });

            //SHIPPING
            if ($ecommerce['cart_opcion']['shipping']) {
              
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

            Schema::create('payments', function(Blueprint $table)
            {
                $table->increments('id');
                $table->text('name');
                $table->boolean('activated')->default(0);
                $table->timestamps();
            });

            Schema::create('payments_errors', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('payment_id')->unsigned();
                $table->integer('code')->unsigned();
                $table->string('description', 255);

                $table->timestamps();
                $table->foreign('payment_id')->references('id')->on('payments');
            });

            $this->insertPayment();

            if ($ecommerce['cart_opcion']['coupons']) {
               
                Schema::create('coupons', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('code', 15)->unique();
                    $table->date('date_start')->nullable();
                    $table->date('date_end')->nullable();
                    $table->float('discount');
                    $table->boolean('activated')->default(0);
                    $table->timestamps();
                });

                Schema::create('coupons_translations', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('coupons_id')->unsigned();
                    $table->string('locale')->index();
                    $table->longText('description');
                    $table->timestamps();

                    $table->unique(['coupons_id', 'locale']);
                    $table->foreign('coupons_id')->references('id')->on('coupons')->onDelete('cascade');
                });
            }


            Schema::create('orders', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('reference', 10)->unique();

                $table->integer('cart_id')->unsigned();

                $table->float('total_pvp');
                $table->float('total_iva');

                $table->integer('status')->default(0);
                $table->string('observations', 255);
                $table->boolean('bill')->default(0);

                $table->timestamps();

                $table->foreign('cart_id')->references('id')->on('carts');
            });

            Schema::create('orders_payments', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('order_id')->unsigned();
                $table->integer('payment_id')->unsigned();

                $table->string('response_code', 255);
                $table->string('operation_code', 255);

                $table->timestamps();
                $table->foreign('order_id')->references('id')->on('orders');
                $table->foreign('payment_id')->references('id')->on('payments');
            });

            Schema::create('orders_details', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('order_id')->unsigned();
                $table->string('shopper_name', 255);
                $table->string('shopper_lastname', 255);
                $table->string('shopper_email', 255);
                $table->string('shopper_address', 175);
                $table->string('shopper_postalcode', 5);
                $table->string('shopper_city', 175);
                $table->string('shopper_province', 175);
                $table->string('shopper_telephone', 15);
                $table->timestamps();
                $table->foreign('order_id')->references('id')->on('orders');
            });


            Schema::table('orders_details', function(Blueprint $table)
            {
                $table->integer('shipping_country')->unsigned();
                $table->foreign('shipping_country')->references('id')->on('shipping_countries');
            });


            if ($ecommerce['cart_opcion']['coupons']) {
               
                Schema::create('orders_coupons', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('order_id')->unsigned();
                    $table->integer('coupon_id')->unsigned();
                    $table->float('discount');

                    $table->timestamps();
                    $table->foreign('order_id')->references('id')->on('orders');
                    $table->foreign('coupon_id')->references('id')->on('coupons');
                });
            }
        }
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

    private function insertPayment()
    {
        $payments = json_decode(file_get_contents(__DIR__ . '/payment.php'));

        foreach ($payments as $payment) {
            DB::table('payments')->insert(array(
                'name' => $payment->name
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
        $ecommerce = Config::get('configMigrations.ecommerce');

        if ($ecommerce['cart']) {
            if ($ecommerce['cart_opcion']['coupons']) {
                Schema::drop('orders_coupons');
            }

            Schema::drop('orders_details');
            Schema::drop('orders_payments');

            Schema::drop('orders');

            if ($ecommerce['cart_opcion']['coupons']) {
                Schema::drop('coupons_translations');
                Schema::drop('coupons');
            }


            Schema::drop('payments_errors');
            Schema::drop('payments');


            Schema::drop('shipping_costs');
            Schema::drop('shipping_countries');
            Schema::drop('shipping_zones');



            Schema::drop('carts_products');
            Schema::drop('carts');
        }
    }

}
