@include('Tietong.header',['title' => '员工详情'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <div class="index-search">
            <div class="index">
                <span class="index-text">员工详情</span>
            </div>
        </div>

        <form class="form" id="form" action="/tietong-man" method="post">

            <div class="form-cell">
                {{--<span class="form-cell-title">分公司名称</span>
                <input class="form-cell-input" type="text" name="area_name" value="{{old('area_name')}}"
                       placeholder="请输入分公司名称"/>--}}
                <span class="form-cell-title"><span class="must"></span>分公司</span>
                {{$self->young_area_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">网格</span>
                {{$self->young_hall_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">所属公司</span>
                {{$self->young_company}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">编号</span>
                {{$self->young_order}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">orgcode</span>
                {{$self->young_orgcode}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">员工名称</span>
                {{$self->young_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">民族</span>
                {{$self->young_nation_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">学历</span>
                {{$self->young_school_record}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">入职时间</span>
                {{$self->young_join_time}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">身份证</span>
                {{$self->young_id_card}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">生日</span>
                {{$self->young_birthday}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">银行卡号</span>
                {{$self->young_bank_number}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">开户行</span>
                {{$self->young_bank_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">开户网点</span>
                {{$self->young_bank_address}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">档案号</span>
                {{$self->young_file_number}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">户口所在地</span>
                {{$self->young_hukou_address}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">地址</span>
                {{$self->young_address}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">学校</span>
                {{$self->young_school_name}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">专业</span>
                {{$self->young_school_major}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">紧急联系人</span>
                {{$self->young_sos_man}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">紧急联系电话</span>
                {{$self->young_sos_phone}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">社保基数</span>
                {{$self->young_safe_base}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">合同开始时间</span>
                {{$self->young_contract_begin_time}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">合同结束时间</span>
                {{$self->young_contract_end_time}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">团意险</span>
                {{$self->young_team_safe_total}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">团意险结束时间</span>
                {{$self->young_team_safe_end_time}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">身高</span>
                {{$self->young_height}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">体重</span>
                {{$self->young_weight}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">T恤</span>
                {{$self->young_t_shirt}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">工装</span>
                {{$self->young_work_clothes}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title">鞋码</span>
                {{$self->young_shoe_size}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>性别</span>
                {{$sex[$self->young_sex]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>婚姻状况</span>
                {{$marry[$self->young_marry]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>党员</span>
                {{$communist[$self->young_communist]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>合同类型</span>
                {{$contract[$self->young_contract]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>工种</span>
                {{$job[$self->young_job]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>户口类型</span>
                {{$hukou_type[$self->young_hukou_type]}}
            </div>

            <div class="form-cell">
                <span class="form-cell-title form-titles">备注</span>
                {{$self->young_note}}
            </div>

            <div class="form-cell-submit">
                <button class="form-submit" type="submit" id="submit">确认并提交</button>
            </div>
        </form>
    </div>
</div>
</body>

@include('Tietong.js')
<script type="text/javascript" src="/js/date/WdatePicker.js"></script>
<script type="text/javascript">

    $('#form').submit(function () {
        verify(Ajax, this, success, '正在提交...');
        return false;
    });
</script>

</html>