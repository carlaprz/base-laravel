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
        Schema::create('users_status', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users_roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('rol')->unsigned();
            $table->integer('status')->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::table('users', function(Blueprint $table)
        {
            $table->foreign('rol')->references('id')->on('users_roles');
            $table->foreign('status')->references('id')->on('users_status');
        });
        
        $this->insertStatus();
        $this->insertRoles();
        $this->insertUser();
    }

    private function insertStatus()
    {
        $roles = [
            [
                'name' => 'active',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'inactive',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'waiting confirmation',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'deleted',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'banned',
                'created_at' => date("Y-m-d H:s:i")
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('users_roles')->insert($rol);
        }
    }

    private function insertRoles()
    {
        $roles = [
            [
                'name' => 'admin',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'user',
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'guest',
                'created_at' => date("Y-m-d H:s:i")
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('users_status')->insert($rol);
        }
    }

    private function insertUser()
    {
        $users = [
            [
                'name' => 'Thatzad',
                'email' => 'thatzad@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'Carla Perez',
                'email' => 'carla.perez@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'Pau Garcia',
                'email' => 'pau.garcia@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i")
            ],
            [
                'name' => 'Guest',
                'email' => 'guest@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 2,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i")
            ]
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
        Schema::drop('users_roles');
        Schema::drop('users_status');
    }

}
