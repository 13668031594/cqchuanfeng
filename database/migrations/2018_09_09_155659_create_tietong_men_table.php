<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTietongMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tietong_men', function (Blueprint $table) {
            $table->increments('id');

            $table->string('young_order')->nullable();//编号
            $table->string('young_orgcode')->nullable();//orgcode

            $table->integer('young_area_id')->nullable();//分中心id
            $table->string('young_area_name')->nullable();//分中心名称
            $table->integer('young_hall_id')->nullable();//网格id
            $table->string('young_hall_name')->nullable();//网格名称
            $table->integer('young_company_id')->nullable();//公司id
            $table->string('young_company_name')->nullable();//公司名称

            $table->string('young_name')->nullable();//名字
            $table->string('young_phone')->nullable();//电话
            $table->char('young_sex', 2)->default(10);//性别，10未知，20男，30女，40人妖，50太监
            $table->integer('young_age')->nullable();//年龄

            $table->integer('young_nation_id')->nullable();//民族id
            $table->string('young_nation_name')->nullable();//民族名称

            $table->char('young_marry', 2)->default(10);//婚姻，10未知，20已婚，30未婚，40离异
            $table->char('young_communist', 2)->default(10);//党员，10未知，20是，30否，40开除
            $table->string('young_school_record')->nullable();//学历
            $table->timestamp('young_join_time')->nullable();//入职时间
            $table->char('young_id_card', 18)->nullable();//身份证
            $table->timestamp('young_birthday')->nullable();//生日
            $table->char('young_contract', 2)->default(10);//合同类型，10未知,20固定期限
            $table->char('young_job', 2)->default(10);//工种，10未知,20线务员，30市场，40后台
            $table->char('young_hukou_type', 2)->default(10);//户口类型，10未知,20农村，30城镇
            $table->string('young_bank_number')->nullable();//银行卡号
            $table->string('young_bank_name')->nullable();//开户行
            $table->string('young_bank_address')->nullable();//开户网点
            $table->string('young_file_number')->nullable();//档案号
            $table->string('young_hukou_address')->nullable();//户口所在地
            $table->string('young_address')->nullable();//地址
            $table->string('young_school_name')->nullable();//学校
            $table->string('young_school_major')->nullable();//专业
            $table->string('young_sos_man')->nullable();//紧急联系人
            $table->string('young_sos_phone')->nullable();//紧急联系电话
            $table->decimal('young_safe_base', 18, 2)->nullable();//社保基数
            $table->string('young_note')->nullable();//备注
            $table->timestamp('young_contract_begin_time')->nullable();//合同开始时间
            $table->timestamp('young_contract_end_time')->nullable();//合同结束时间
            $table->decimal('young_team_safe_total', 18, 2)->nullable();//团体意外险
            $table->timestamp('young_team_safe_end_time')->nullable();//团体意外险结束时间

            $table->integer('young_height')->nullable();//身高
            $table->integer('young_weight')->nullable();//体重
            $table->integer('young_t_shirt')->nullable();//T恤
            $table->integer('young_work_clothes')->nullable();//工装
            $table->integer('young_shoe_size')->nullable();//鞋码

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
        Schema::dropIfExists('tietong_men');
    }
}
