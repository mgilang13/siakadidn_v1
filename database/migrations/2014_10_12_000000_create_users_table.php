<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20);
            $table->enum('gender', ['l', 'p'])->default('l');
            $table->string('birth_place')->nullable(TRUE);
            $table->date('birth_date')->nullable(TRUE);
            $table->string('address')->nullable(TRUE);
            $table->string('image_large')->nullable(TRUE);
            $table->string('image_medium')->nullable(TRUE);
            $table->string('image_small')->nullable(TRUE);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
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
