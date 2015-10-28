<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lenguages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        
        $this->insertLanguages();
    }

    private function insertLanguages()
    {
        $languages = [
            [
                'code' => 'es',
                'locale' => 'es_ES',
                'name' => 'Español',
                'default' => 1,
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'code' => 'en',
                'locale' => 'en_EN',
                'name' => 'Ingles',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'code' => 'fr',
                'locale' => 'fr_FR',
                'name' => 'Frances',
                'created_at' => date("Y-m-d H:s:i")
            ]
        ];

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
