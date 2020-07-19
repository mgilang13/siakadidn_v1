<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahfidzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_halaqah');
            $table->unsignedBigInteger('id_student');
            $table->unsignedBigInteger('id_teacher');
            $table->date('tanggal_setor')->nullable(TRUE);
            $table->integer('soorah_start')->nullable(TRUE);
            $table->integer('soorah_end')->nullable(TRUE);
            $table->integer('verse_start')->nullable(TRUE);
            $table->integer('verse_end')->nullable(TRUE);
            $table->text('assessment')->nullable(TRUE);
            $table->enum('type', ['manzil', 'sabaq'])->nullable(TRUE);
            $table->integer('line')->default(0)->nullable(TRUE);
            $table->integer('page')->default(0)->nullable(TRUE);
            $table->enum('absen', ['h', 'a', 'i', 's'])->default('h')->nullable(TRUE);
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_halaqah')->references('id')->on('halaqahs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_student')->references('id_student')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_teacher')->references('id_teacher')->on('teachers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahfidzs');
    }
}
