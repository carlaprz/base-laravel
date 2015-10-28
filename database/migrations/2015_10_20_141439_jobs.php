<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Jobs extends Migration {

    public function up()
    {
        Schema::create('jobs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('jobs_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('jobs_id')->unsigned();
            $table->string('locale')->index();

            $table->text('title');
            $table->longText('description');
          
            $table->timestamps();

            $table->unique(['jobs_id', 'locale']);
            $table->foreign('jobs_id')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs_translations');
        Schema::drop('jobs');
    }


}
