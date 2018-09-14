<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTietongMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tietong_masters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('young_nickname');//昵称
            $table->string('young_account_number');//账号
            $table->string('password');//密码
            $table->char('young_power', 2)->default(10);//密码
            $table->integer('young_login_times')->default(0);//登录次数
            $table->timestamp('young_last_login_time')->nullable();//上次登录时间
            $table->timestamp('young_this_login_time')->nullable();//本次登录时间
            $table->string('young_last_login_ip')->nullable();//上次登录IP
            $table->string('young_this_login_ip')->nullable();//本次登录IP
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
        Schema::dropIfExists('tietong_masters');
    }
}
