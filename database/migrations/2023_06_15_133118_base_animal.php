<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseAnimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baseAnimals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('folder');
            // $table->integer('price');
            $table->float('rarity')->nullable();
            $table->boolean('base')->default(false);
            $table->string('gene');
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
        Schema::dropIfExists('baseAnimals');
    }
}
