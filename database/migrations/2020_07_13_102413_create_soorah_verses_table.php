<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoorahVersesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soorah_verses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_soorah');
            $table->integer('verse');
            $table->integer('juz');
            $table->integer('page');
            $table->integer('row_start');
            $table->integer('row_end');
            $table->timestamps();

            $table->foreign('id_soorah')->references('id')->on('soorahs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soorah_verses');
    }
}
