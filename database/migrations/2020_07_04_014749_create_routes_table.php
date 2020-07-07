<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent')->nullable(TRUE);
            $table->string('icon')->nullable(TRUE);
            $table->string('name')->nullable(TRUE);
            $table->string('title')->nullable(TRUE);
            $table->integer('order')->nullable(TRUE);
            $table->enum('menu', ['yes', 'no'])->default('no')->nullable(TRUE);
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
        Schema::dropIfExists('routes');
    }
}
