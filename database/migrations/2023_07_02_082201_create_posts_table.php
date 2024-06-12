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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('title'); // Tiêu đề
            $table->text('description'); // Miêu tả
            $table->string('province'); 
            $table->string('district'); // Quận huyện
            $table->string('ward'); // Phường xã
            $table->string('street')->nullable();  // Địa chỉ cụ thể 
            $table->string('address');
            $table->string('legal_documents')->nullable();  //Giấy tờ
            $table->string('furniture')->nullable(); // Nội thất
            $table->integer('bedroom')->nullable(); // Số phòng ngủ
            $table->integer('toilet')->nullable(); // Số phòng tắm/vệ sinh
            $table->integer('floor')->nullable();  // Số tầng
            $table->integer('size');   // Diện tích
            $table->unsignedBigInteger('price')->nullable(); // Giá cả
            $table->enum('unit',['VND', 'VND/m2', 'Thỏa Thuận']);  // Đơn vị
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('post_types');
            $table->tinyInteger('status');  // Trạng thái bài đăng, (đã duyệt 1, chờ duyệt 0, hết hạn 2, đã xoá 3, không duyệt 4)
            $table->dateTime('published_at')->nullable(); // Thời gian lúc bài đăng được duyệt
            $table->dateTime('expired_at')->nullable(); // Thời gian mà bài đăng hết hạn
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
        Schema::dropIfExists('posts');
    }
};
