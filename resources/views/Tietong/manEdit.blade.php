@include('Tietong.header',['title' => '员工添加'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <div class="index-search">
            <div class="index">
                <span class="index-text">员工添加</span>
            </div>
        </div>

        <form class="form" id="form" action="/tietong-man/{{$self->id}}" method="put">

            <div class="form-cell">
                {{--<span class="form-cell-title">分公司名称</span>
                <input class="form-cell-input" type="text" name="area_name" value="{{old('area_name')}}"
                       placeholder="请输入分公司名称"/>--}}
                <span class="form-cell-title"><span class="must"></span>分公司</span>
                <select name="area_id">
                    <option value="">请选择分中心</option>
                @if(count($area) > 0)
                        @foreach($area as $k => $v)
                            <option value="{{$k}}" @if($k == $self->young_area_id) selected @endif>{{$v['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">网格</span>
                <input class="form-cell-input" type="text" name="hall_name" value="{{is_null(old('hall_name')) ? $self->young_hall_name : old('hall_name')}}"
                       placeholder="请输入网格"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">所属公司</span>
                <input class="form-cell-input" type="text" name="company_name" value="{{is_null(old('company_name')) ? $self->young_company_name : old('company_name')}}"
                       placeholder="请输入所属公司"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">编号</span>
                <input class="form-cell-input" type="text" name="order" value="{{is_null(old('order')) ? $self->young_order : old('order')}}"
                       placeholder="请输入编号"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">orgcode</span>
                <input class="form-cell-input" type="text" name="orgcode" value="{{is_null(old('orgcode')) ? $self->young_orgcode : old('orgcode')}}"
                       placeholder="请输入orgcode"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">员工名称</span>
                <input class="form-cell-input" type="text" name="name" value="{{is_null(old('name')) ? $self->young_name : old('name')}}"
                       placeholder="请输入员工名称"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">民族</span>
                <input class="form-cell-input" type="text" name="nation_name" value="{{is_null(old('nation_name')) ? $self->young_nation_name : old('nation_name')}}"
                       placeholder="请输入民族"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">学历</span>
                <input class="form-cell-input" type="text" name="school_record" value="{{is_null(old('school_record')) ? $self->young_school_record : old('school_record')}}"
                       placeholder="请输入学历"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">入职时间</span>
                <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       type="text" name="join_time" value="{{is_null(old('join_time')) ? $self->young_join_time : old('join_time')}}" placeholder="入职时间"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">身份证</span>
                <input class="form-cell-input" type="text" name="id_card" value="{{is_null(old('id_card')) ? $self->young_id_card : old('id_card')}}"
                       placeholder="请输入身份证"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">生日</span>
                <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       type="text" name="birthday" value="{{is_null(old('birthday')) ? $self->young_birthday : old('birthday')}}" placeholder="生日"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">银行卡号</span>
                <input class="form-cell-input" type="text" name="bank_number" value="{{is_null(old('bank_number')) ? $self->young_bank_name : old('bank_number')}}"
                       placeholder="请输入银行卡号"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">开户行</span>
                <input class="form-cell-input" type="text" name="bank_name" value="{{is_null(old('bank_name')) ? $self->young_bank_name : old('bank_name')}}"
                       placeholder="请输入开户行"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">开户网点</span>
                <input class="form-cell-input" type="text" name="bank_address" value="{{is_null(old('bank_address')) ? $self->young_bank_address : old('bank_address')}}"
                       placeholder="请输入开户网点"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">档案号</span>
                <input class="form-cell-input" type="text" name="file_number" value="{{is_null(old('file_number')) ? $self->young_file_number : old('file_number')}}"
                       placeholder="请输入档案号"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">户口所在地</span>
                <input class="form-cell-input" type="text" name="hukou_address" value="{{is_null(old('hukou_address')) ? $self->young_hukou_address : old('hukou_address')}}"
                       placeholder="请输入户口所在地"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">地址</span>
                <input class="form-cell-input" type="text" name="address" value="{{is_null(old('address')) ? $self->young_address : old('address')}}"
                       placeholder="请输入地址"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">学校</span>
                <input class="form-cell-input" type="text" name="school_name" value="{{is_null(old('school_name')) ? $self->young_school_name : old('school_name')}}"
                       placeholder="请输入学校"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">专业</span>
                <input class="form-cell-input" type="text" name="school_major" value="{{is_null(old('school_major')) ? $self->young_school_major : old('school_major')}}"
                       placeholder="请输入专业"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">紧急联系人</span>
                <input class="form-cell-input" type="text" name="sos_man" value="{{is_null(old('sos_man')) ? $self->young_sos_man : old('sos_man')}}"
                       placeholder="请输入紧急联系人"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">紧急联系电话</span>
                <input class="form-cell-input" type="text" name="sos_phone" value="{{is_null(old('sos_phone')) ? $self->young_sos_phone : old('sos_phone')}}"
                       placeholder="请输入紧急联系电话"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">社保基数</span>
                <input class="form-cell-input" type="text" name="safe_base" value="{{is_null(old('safe_base')) ? $self->young_safe_base : old('safe_base')}}"
                       placeholder="请输入社保基数"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">合同开始时间</span>
                <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       type="text" name="contract_begin_time" value="{{is_null(old('contract_begin_time')) ? $self->young_contract_begin_time : old('contract_begin_time')}}" placeholder="合同开始时间"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">合同结束时间</span>
                <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       type="text" name="contract_end_time" value="{{is_null(old('contract_end_time')) ? $self->young_contract_end_time : old('contract_end_time')}}" placeholder="合同结束时间"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">团意险</span>
                <input class="form-cell-input" type="text" name="team_safe_total" value="{{is_null(old('team_safe_total')) ? $self->young_team_safe_total : old('team_safe_total')}}"
                       placeholder="请输入团意险"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">团意险结束时间</span>
                <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       type="text" name="team_safe_end_time" value="{{is_null(old('team_safe_end_time')) ? $self->young_team_safe_end_time : old('team_safe_end_time')}}" placeholder="团意险结束时间"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">身高</span>
                <input class="form-cell-input" type="number" name="height" value="{{is_null(old('height')) ? $self->young_height : old('height')}}"
                       placeholder="请输入身高"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">体重</span>
                <input class="form-cell-input" type="number" name="weight" value="{{is_null(old('weight')) ? $self->young_weight : old('weight')}}"
                       placeholder="请输入体重"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">T恤</span>
                <input class="form-cell-input" type="number" name="t_shirt" value="{{is_null(old('t_shirt')) ? $self->young_t_shirt : old('t_shirt')}}"
                       placeholder="请输入T恤"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">工装</span>
                <input class="form-cell-input" type="number" name="work_clothes" value="{{is_null(old('work_clothes')) ? $self->young_work_clothes : old('work_clothes')}}"
                       placeholder="请输入工装"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">鞋码</span>
                <input class="form-cell-input" type="number" name="shoe_size" value="{{is_null(old('shoe_size')) ? $self->young_shoe_size : old('shoe_size')}}"
                       placeholder="请输入鞋码"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>性别</span>
                <div class="form-cell-right">
                    @foreach($sex as $k => $v)
                        <input id="radio_sex_{{$k}}" type="radio" name="sex" value="{{$k}}"
                               @if((old('sex') == $k) || (empty(old('sex')) && ($k == $self->young_sex))) checked @endif/>
                        <label for="radio_sex_{{$k}}">
                            <label class="form-radio" for="radio_sex_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>婚姻状况</span>
                <div class="form-cell-right">
                    @foreach($marry as $k => $v)
                        <input id="radio_marry_{{$k}}" type="radio" name="marry" value="{{$k}}"
                               @if((old('marry') == $k) || (empty(old('marry')) && ($k == $self->young_marry))) checked @endif/>
                        <label for="radio_marry_{{$k}}">
                            <label class="form-radio" for="radio_marry_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>党员</span>
                <div class="form-cell-right">
                    @foreach($communist as $k => $v)
                        <input id="radio_communist_{{$k}}" type="radio" name="communist" value="{{$k}}"
                               @if((old('communist') == $k) || (empty(old('communist')) && ($k == $self->young_communist))) checked @endif/>
                        <label for="radio_communist_{{$k}}">
                            <label class="form-radio" for="radio_communist_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>合同类型</span>
                <div class="form-cell-right">
                    @foreach($contract as $k => $v)
                        <input id="radio_contract_{{$k}}" type="radio" name="contract" value="{{$k}}"
                               @if((old('contract') == $k) || (empty(old('contract')) && ($k == $self->young_contract))) checked @endif/>
                        <label for="radio_contract_{{$k}}">
                            <label class="form-radio" for="radio_contract_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>工种</span>
                <div class="form-cell-right">
                    @foreach($job as $k => $v)
                        <input id="radio_job_{{$k}}" type="radio" name="job" value="{{$k}}"
                               @if((old('job') == $k) || (empty(old('job')) && ($k == $self->young_job))) checked @endif/>
                        <label for="radio_job_{{$k}}">
                            <label class="form-radio" for="radio_job_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>户口类型</span>
                <div class="form-cell-right">
                    @foreach($hukou_type as $k => $v)
                        <input id="radio_hukou_type_{{$k}}" type="radio" name="hukou_type" value="{{$k}}"
                               @if((old('hukou_type') == $k) || (empty(old('hukou_type')) && ($k == $self->young_hukou_type))) checked @endif/>
                        <label for="radio_hukou_type_{{$k}}">
                            <label class="form-radio" for="radio_hukou_type_{{$k}}">●</label>
                            <span class="form-radioText">{{$v}}</span>
                        </label>
                    @endforeach
                </div>
            </div>


        <!--<div class="form-cell">
                <span class="form-cell-title">密码</span>
                <input class="form-cell-input" type="password" name="password" value="{{old('password')}}"
                       placeholder="请输入密码"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title"><span class="must"></span>账号类型</span>
                <div class="form-cell-right">
                <input id="radio3" type="radio" name="power" value="10" @if(old('power') != '20') checked @endif/>
                <label for="radio3">
                    <label class="form-radio" for="radio3">●</label>
                    <span class="form-radioText">查看</span>
                </label>

                <input id="radio4" type="radio" name="power" value="20" @if(old('power') == '20') checked @endif/>
                <label for="radio4">
                    <label class="form-radio" for="radio4">●</label>
                    <span class="form-radioText">编辑</span>
                </label>
            </div>
            </div>-->

            <div class="form-cell">
                <span class="form-cell-title form-titles">备注</span>
                <textarea class="form-textarea" name="note"
                          placeholder="请输入备注">{{is_null(old('note')) ? $self->young_note : old('note')}}</textarea>
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