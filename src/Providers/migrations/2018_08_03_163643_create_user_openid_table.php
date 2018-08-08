<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOpenidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smy_openid', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openId', 64)->nullable(FALSE)->comment('openId');
            $table->string('mobilePhoneNo', 64)->nullable(FALSE)->comment('手机号码');
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
        Schema::dropIfExists('smy_openid');
    }
}
