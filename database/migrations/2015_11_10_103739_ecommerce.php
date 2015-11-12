<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ecommerce extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->integer('product_id')->unsigned();

            $table->text('product_description');
            $table->float('pvp')->unsigned();
            $table->float('iva')->unsigned();
            $table->integer('cant')->unsigned();

            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('product_id')->references('id')->on('products');
        });

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
            $table->integer('shipping_country')->unsigned();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });

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
        Schema::drop('orders_coupons');
        Schema::drop('orders_details');
        Schema::drop('orders');

        Schema::drop('carts_products');
        Schema::drop('carts');

        Schema::drop('coupons_translations');
        Schema::drop('coupons');

        Schema::drop('payments');
    }

}
