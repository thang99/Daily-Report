<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_networks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('Id của người dùng');
            $table->text('provider_id')->comment('Id mạng');
            $table->string('provider_name')->comment('Tên mạng');
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
        Schema::dropIfExists('user_networks');
    }
}
