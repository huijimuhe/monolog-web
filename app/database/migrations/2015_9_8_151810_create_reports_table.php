<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reports', function(Blueprint $table) {
            $table->increments('id');
            $table->string('statue_id')->index();
            $table->string('from_user_id');
            $table->string('reason');
            $table->integer('isbanned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('reports');
    }

}
