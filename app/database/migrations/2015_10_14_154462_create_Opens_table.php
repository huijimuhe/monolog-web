<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('opens', function(Blueprint $table) { 
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('type')->index();
            $table->string('open_id')->index();
            $table->string('token');
            $table->string('refresh_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('opens');
    }

}
