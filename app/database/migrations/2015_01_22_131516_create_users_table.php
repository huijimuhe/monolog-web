<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('phone')->nullable()->index();

            $table->string('password');
            $table->string('salt');
            $table->string('remember_token')->nullable();
            $table->string('app_token')->nullable();
            $table->string('expired_at')->nullable();
            $table->boolean('is_banned')->default(false)->index();
            $table->boolean('is_r')->default(false)->index();
             
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
