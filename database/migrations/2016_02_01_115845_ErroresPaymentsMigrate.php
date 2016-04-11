<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErroresPaymentsMigrate extends Migration
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
            $this->insertPaymentErrors();
        }
    }

    private function insertPaymentErrors()
    {
        $errorsPaypal = json_decode(file_get_contents(__DIR__ . '/errorsPaymentsPaypal.php'), true);
        $errorsTvp = json_decode(file_get_contents(__DIR__ . '/errorsPaymentsTPV.php'), true);

        foreach ($errorsPaypal as $error) {
            DB::table('payments_errors')->insert([
                'payment_id' => 2,
                'code' => $error["code"],
                'description' => $error["description"]
            ]);
        }


        foreach ($errorsTvp as $error) {

            DB::table('payments_errors')->insert([
                'payment_id' => 1,
                'code' => $error["code"],
                'description' => $error["description"]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//
    }

}
