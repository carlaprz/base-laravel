<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });
        $this->insertUser();
    }

    private function insertUser()
    {
        $users = [
            [
                'name' => 'Thatzad',
                'email' => 'thatzad@thatzad.com',
                'password' => bcrypt('123456'),
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'Carla Perez',
                'email' => 'carla.perez@thatzad.com',
                'password' => bcrypt('123456'),
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'Pau Garcia',
                'email' => 'pau.garcia@thatzad.com',
                'password' => bcrypt('123456'),
                'created_at' => date("Y-m-d H:s:i")
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
