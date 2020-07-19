<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->unsignedBigInteger('id_parents');
            $table->unsignedBigInteger('id_student');
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_parents')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_student')->references('id_student')->on('students')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parents');
    }
}
