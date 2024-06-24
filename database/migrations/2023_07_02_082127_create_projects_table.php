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
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('project_types');
            $table->string('name');
            $table->string('province');
            $table->string('district');
            $table->string('ward');
            $table->string('street')->nullable();
            $table->string('address');
            $table->tinyInteger('project_status')->nullable(); // Trạng thái dự án (1: Sắp mở bán , 2: Đang mở bán, 3: Đã bàn giao)
            $table->string('note')->nullable(); // Ghi chú về trạng thái của dự án
            $table->text('description');
            $table->integer('apartment')->nullable(); // Số căn hộ
            $table->integer('building')->nullable(); // Số toà nhà
            $table->float('start_price', 8, 2)->nullable();
            $table->float('end_price', 8, 2)->nullable();
            $table->float('size', 8, 1)->nullable();
            $table->enum('size_unit', ['m2', 'ha']);
            $table->string('scale')->nullable(); // Quy mô dự án
            $table->string('legal_documents')->nullable(); // Giấy tờ pháp lý
            $table->string('builders')->nullable(); // Cty xây dựng dự án
            $table->string('designer')->nullable(); // Doanh nghiệp thiết kế
            $table->tinyInteger('status')->nullable(); // Trạng thái của bài đăng (0: đang chờ duyệt , 1: Đang hiển thị , 2: bị từ chối)
            $table->integer('number_views')->default(0);
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
