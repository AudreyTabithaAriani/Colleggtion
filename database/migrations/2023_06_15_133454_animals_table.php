<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->string('image');
            $table->integer('price');
            $table->float('rarity');
            $table->string('gene');
            $table->unsignedBigInteger('baseAnimal')->nullable();
            $table->unsignedBigInteger('parentOne')->nullable();
            $table->unsignedBigInteger('parentTwo')->nullable();
            $table->timestamps();

            $table->foreign('baseAnimal')->references('id')->on('baseAnimals')->onDelete('cascade');
            $table->foreign('parentOne')->references('id')->on('baseAnimals')->onDelete('cascade');
            $table->foreign('parentTwo')->references('id')->on('baseAnimals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
