<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_routes', function (Blueprint $table) {
            $table->unsignedTinyInteger('roles_id');
            $table->unsignedBigInteger('routes_id');
            $table->enum('access', ['yes', 'no'])->default('yes')->nullable(TRUE);
            $table->timestamps();
            // foreign key
            $table->foreign('roles_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('routes_id')->references('id')->on('routes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_routes');
    }
}
