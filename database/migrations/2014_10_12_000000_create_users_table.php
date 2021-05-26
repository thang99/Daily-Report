<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên người dùng');
            $table->integer('position_division_id')->nullable()->comment('Id bộ phận');
            $table->string('avatar', 255)->default('default-avatar.png')->comment('Ảnh đại diện người dùng');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable()->comment('Số điện thoại người dùng');
            $table->date('birthday')->nullable()->comment('Ngày sinh người dùng');
            $table->tinyInteger('status')->default(1)->comment('Trạng thái người dùng/1:Active,0:Disabled,-1:Block');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
