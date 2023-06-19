<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function (Blueprint $table) {
            $table->id();
            $table->float('base');
            $table->float('common');
            $table->float('uncommon');
            $table->float('rare');
            $table->float('superRare');
            $table->float('epic');
            // $table->float('legendary');
            // $table->float('mythical');

            $table->string('currency');
            $table->string('currencyIcon');
            $table->float('commission');

            $table->integer('cooldown');
            $table->integer('reset');

            // $table->string('adminPassword');
            $table->string('gameName');
            $table->string('gameIcon');

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
        Schema::dropIfExists('system');
    }
}
