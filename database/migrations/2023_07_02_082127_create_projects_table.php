<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enterprise_id');
            $table->foreign('enterprise_id')->references('id')->on('enterprises');
            $table->string('name');
            $table->string('province');
            $table->string('district');
            $table->string('ward');
            $table->string('street');
            $table->string('address');
            $table->tinyInteger('status')->nullable();
            $table->text('description');
            $table->integer('apartment');
            $table->integer('buiding');
            $table->integer('price');
            $table->float('size');
            $table->enum('size_unit', ['m2, ha']);
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
        Schema::dropIfExists('projects');
    }
};
