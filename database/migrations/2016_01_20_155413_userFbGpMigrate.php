<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserFbGpMigrate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configMigrations = Config::get('configMigrations.users');
        if ($configMigrations['fb_connect'] === true) {
            Schema::table('users', function(Blueprint $table)
            {
                $table->string('fb_id')->after('remember_token')->nullable();
                $table->string('fb_token')->after('fb_id')->nullable();
                $table->string('fb_image')->after('fb_token')->nullable();
            });
        }
        if ($configMigrations['gp_connect'] === true) {
            Schema::table('users', function(Blueprint $table)
            {
                $table->string('google_id')->after('fb_image')->nullable();
                $table->string('google_token')->after('google_id')->nullable();
                $table->string('google_image')->after('google_token')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $configMigrations = Config::get('configMigrations.users');
        if ($configMigrations['fb_connect'] === true) {
            Schema::table('users', function(Blueprint $table)
            {
                $table->dropColumn('fb_id');
                $table->dropColumn('fb_token');
                $table->dropColumn('fb_image');
            });
        }

        if ($configMigrations['gp_connect'] === true) {
            Schema::table('users', function(Blueprint $table)
            {
                $table->dropColumn('google_id');
                $table->dropColumn('google_token');
                $table->dropColumn('google_image');
            });
        }
    }

}
