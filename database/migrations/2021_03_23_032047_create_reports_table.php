<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable(false)->comment('Id của người dùng');
            $table->bigInteger('assign_to')->nullable(false)->comment('Id người được mời xử lý báo cáo');
            $table->string('title', 255)->nullable(false)->comment('Tiêu đề báo cáo');
            $table->text('content')->nullable(false)->comment('Nội dung báo cáo');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái của báo cáo/1:Chấp nhận,0:Đang xử lý,-1:Từ chối');
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
        Schema::dropIfExists('reports');
    }
}
