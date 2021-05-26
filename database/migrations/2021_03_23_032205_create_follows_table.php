<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable(false)->comment('Id người dùng được theo dõi');
            $table->integer('by')->nullable(false)->comment('Id người theo dõi');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái theo dõi/1:Đang theo dõi,0:Ngừng theo dõi');
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
        Schema::dropIfExists('follows');
    }
}
