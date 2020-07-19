<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id_student');
            $table->string('nisn');
            $table->string('nis');
            $table->unsignedBigInteger('id_halaqah')->nullable(TRUE);
            $table->date('entry_date')->nullable(TRUE);
            $table->integer('hafalan_pra_idn')->nullable(TRUE);
            $table->integer('target_hafalan')->nullable(TRUE);
            $table->string('father_name')->nullable(TRUE);
            $table->string('father_job')->nullable(TRUE);
            $table->string('mother_name')->nullable(TRUE);
            $table->string('mother_job')->nullable(TRUE);
            
            $table->timestamps();
            $table->softDeletes();

            //Foreign key
            $table->foreign('id_student')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_halaqah')->references('id')->on('halaqahs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
