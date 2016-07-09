<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('profiles', function(Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('gender');
            $table->string('avatar')->nullable();
            $table->integer('score')->default(10);
            $table->integer('follow_count')->default(0);
            $table->integer('fan_count')->default(0);
            $table->integer('right_count')->default(0);
            $table->integer('miss_count')->default(0);
            $table->integer('report_count')->default(0);
            $table->integer('statue_count')->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('profiles');
    }

}
