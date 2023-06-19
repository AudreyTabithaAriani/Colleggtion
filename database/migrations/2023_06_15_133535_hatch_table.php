<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hatches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->timestamp('bought');
            $table->boolean('hatched')->default(false);
            $table->timestamps();

            $table->foreign('user')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hatches');
    }
}
