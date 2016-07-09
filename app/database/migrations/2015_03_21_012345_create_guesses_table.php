<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuessesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('guesses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->index();
            $table->integer('user_id')->index();
            $table->string('statue_id')->index();
            $table->integer('result')->index();
            $table->boolean('is_readed')->defalut(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('guesses');
    }

}
