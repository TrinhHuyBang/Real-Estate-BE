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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name'); // Tên công ty
            $table->string('abbreviation');  // Tên viết tắt
            $table->text('description')->nullable();
            $table->text('logo');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->string('website');
            $table->string('business_number'); // Số đăng ký kinh doanh
            $table->text('certificate_url'); // Ảnh giấy phép kinh doanh
            $table->unsignedBigInteger('main_field');  // Lĩnh vực chính
            $table->foreign('main_field')->references('id')->on('fields');
            $table->tinyInteger('status'); // Trạng thái của yêu cầu (0: chờ duyệt / 1: đã duyệt / 2: đã huỷ)
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
        Schema::dropIfExists('enterprises');
    }
};
