<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configMigrations = Config::get('configMigrations.users');

        $this->createRoles($configMigrations);

        $this->insertRoles($configMigrations);

        $this->createStatus();

        $this->insertStatus();

        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);

            $table->string('address', 175);
            $table->string('postalcode', 5);
            $table->string('city', 175);
            $table->string('telephone', 15);
            $table->string('province', 175);

            $table->rememberToken();
            $table->timestamps();

            $table->integer('rol')->unsigned();
            $table->integer('status')->unsigned();

            $table->foreign('rol')->references('id')->on('users_roles');
            $table->foreign('status')->references('id')->on('users_status');
        });

        $this->insertUser();

        Schema::create('password_resets', function(Blueprint $table)
        {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    private function insertUser()
    {
        $users = [
            [
                'name' => 'Thatzad',
                'email' => 'informacion@thatzad.com',
                'password' => bcrypt('MM6665MM'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i"),
                'address' => 'Marques de Mulhacen 11',
                'postalcode' => '08034',
                'city' => 'Barcelona',
                'telephone' => '936350620',
                'province' => 'Barcelona'
            ],
            [
                'name' => 'Carla Perez',
                'email' => 'carla.perez@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i"),
                'address' => 'Marques de Mulhacen 11',
                'postalcode' => '08034',
                'city' => 'Barcelona',
                'telephone' => '936350620',
                'province' => 'Barcelona'
            ],
            [
                'name' => 'Pau Garcia',
                'email' => 'pau.garcia@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i"),
                'address' => 'Marques de Mulhacen 11',
                'postalcode' => '08034',
                'city' => 'Barcelona',
                'telephone' => '936350620',
                'province' => 'Barcelona'
            ],
            [
                'name' => 'Manel Domenech',
                'email' => 'manel.domenech@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i"),
                'address' => 'Marques de Mulhacen 11',
                'postalcode' => '08034',
                'city' => 'Barcelona',
                'telephone' => '936350620',
                'province' => 'Barcelona'
            ],
            [
                'name' => 'Guest',
                'email' => 'guest@thatzad.com',
                'password' => bcrypt('123456'),
                'rol' => 2,
                'status' => 1,
                'created_at' => date("Y-m-d H:s:i"),
                'address' => 'Marques de Mulhacen 11',
                'postalcode' => '08034',
                'city' => 'Barcelona',
                'telephone' => '936350620',
                'province' => 'Barcelona'
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }

    private function createRoles()
    {
        Schema::create('users_roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    private function insertRoles( $configMigrations )
    {
        if (!empty($configMigrations['admin'])) {
            $roles [] = [
                'name' => 'admin',
                'created_at' => date("Y-m-d H:s:i")
            ];
        }

        if (!empty($configMigrations['front'])) {
            $roles [] = [
                'name' => 'user',
                'created_at' => date("Y-m-d H:s:i")
            ];
        }

        foreach ($roles as $rol) {
            DB::table('users_roles')->insert($rol);
        }
    }

    private function createStatus()
    {
        Schema::create('users_status', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    private function insertStatus()
    {
        $roles = [
            ['name' => 'active', 'created_at' => date("Y-m-d H:s:i")],
            ['name' => 'inactive', 'created_at' => date("Y-m-d H:s:i")],
            ['name' => 'waiting confirmation', 'created_at' => date("Y-m-d H:s:i")],
            [ 'name' => 'deleted', 'created_at' => date("Y-m-d H:s:i")],
            ['name' => 'banned', 'created_at' => date("Y-m-d H:s:i")],
        ];

        foreach ($roles as $rol) {
            DB::table('users_status')->insert($rol);
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
        Schema::drop('password_resets');
    }

}
