<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCakesTable extends Migration
{
    public function up()
    {
        Schema::create('cakes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('flavor');
            $table->string('size');    // Ukuran kue (small, medium, large)
            $table->decimal('price', 10, 2); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cakes');
    }
}
