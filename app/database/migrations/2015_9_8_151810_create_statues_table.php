<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatuesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('statues', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('img_path')->nullable();
            $table->string('text');
            $table->integer('isbanned');
            $table->string('lng')->default('0');
            $table->string('lat')->default('0');
            $table->integer('right_count')->default(0);
            $table->integer('miss_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('statues');
    }

}
