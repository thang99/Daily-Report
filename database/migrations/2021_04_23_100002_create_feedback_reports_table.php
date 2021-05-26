<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('from')->nullable()->comment('Id người quản lý');
            $table->integer('to')->nullable()->comment('Id người gửi báo cáo');
            $table->integer('report_id')->nullable()->comment('Id báo cáo');
            $table->text('message')->nullable(false)->comment('Nội dung phản hồi');
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
        Schema::dropIfExists('feedback_reports');
    }
}
