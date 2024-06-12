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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('avatar')->nullable();
            $table->boolean('status');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role'); // Định danh tài khoản của amdin (0: admin tổng,
                                        // 1: các admin bé hơn)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
