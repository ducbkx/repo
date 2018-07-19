<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 200)->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->string('code');
            $table->integer('division_id')->nullable();
            $table->boolean('is_admin')->nullable()->default(null);
            $table->boolean('role')->default(0);
            $table->boolean('active')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
