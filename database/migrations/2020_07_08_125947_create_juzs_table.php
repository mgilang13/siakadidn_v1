<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juzs', function (Blueprint $table) {
            $table->id();
            $table->integer('juz');
            $table->integer('total_ayat');
            $table->integer('soorah_start');
            $table->integer('verse_start');
            $table->integer('soorah_end');
            $table->integer('verse_end');
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
        Schema::dropIfExists('juzs');
    }
}
