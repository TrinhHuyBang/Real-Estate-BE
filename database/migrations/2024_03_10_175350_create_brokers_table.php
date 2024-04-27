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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->text('certificate_url'); // Ảnh chứng chỉ hành nghề
            $table->tinyInteger('status')->default(0); // Trạng thái của yêu cầu (0: chờ duyệt / 1: đã duyệt / 2: đã huỷ)
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
        Schema::dropIfExists('brokers');
    }
};
