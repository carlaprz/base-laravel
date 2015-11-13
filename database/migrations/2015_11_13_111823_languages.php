<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Languages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configMigrations = Config::get('configMigrations.languages');

        Schema::create('languages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('locale')->unique();
            $table->string('name', 60);
            $table->boolean('active')->default(1);
            $table->boolean('default')->default(0);
            $table->timestamps();
        });

        $this->insertLanguages($configMigrations);
    }

    private function insertLanguages( $configMigrations )
    {
        $languages = [];
        foreach ($configMigrations as $lang) {
            $languages [] = [
                'code' => $lang['code'],
                'locale' => $lang['locale'],
                'name' => $lang['name'],
                'default' => $lang['default'],
                'created_at' => date("Y-m-d H:s:i")
            ];
        }

        foreach ($languages as $key => $lenguage) {
            DB::table('languages')->insert($lenguage);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('languages');
    }

}
