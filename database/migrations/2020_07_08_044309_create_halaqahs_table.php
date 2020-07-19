<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHalaqahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halaqahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_teacher');
            $table->string('name');
            $table->text('description');
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_teacher')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('halaqahs');
    }
}
