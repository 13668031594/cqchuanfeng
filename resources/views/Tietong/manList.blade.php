@include('Tietong.header',['title' => '员工列表'])


<!-- 外部盒子 -->
<div class="out">

@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <form action="/tietong-man" method="get">
            <div class="index-search">
                <div class="index">
                    <span class="index-text">员工列表</span>
                </div>

                <div class="search">
                    <select class="search-select" name="theSelectGroups[select_vague][0][key]">
                        <option value="name"
                                @if(in_array('name', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >员工名称 ▼：
                        </option>
                        <option value="area_name"
                                @if(in_array('area_name', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心名称 ▼：
                        </option>
                    </select>

                    <input class="search-input" type="text" name="theSelectGroups[select_vague][0][value]"
                           @if(in_array('name', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['name']}}"
                           @elseif(in_array('area_name', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['area_name']}}"
                           @endif
                           placeholder="请输入相应搜索内容"/>
                    <input class="search-submit" type="submit" value="搜索"/>
                </div>
            </div>
            <!-- 客户总数 新增客户、签到人数 -->
            <div class="bill">
                {{--<div class="bill-cell">
                    <span>现金(收)：</span>
                    <span>{{$money_in}}</span>
                </div>

                <div class="bill-cell">
                    <span>现金(支)：</span>
                    <span>{{$money_out}}</span>
                </div>

                <div class="bill-cell">
                    <span>{{env('W_INTEGRAL_NAME')}}(收)：</span>
                    <span>{{$w_integral_in}}</span>
                </div>

                <div class="bill-cell">
                    <span>{{env('W_INTEGRAL_NAME')}}(支)：</span>
                    <span>{{$w_integral_out}}</span>
                </div>

                <div class="bill-cell">
                    <span>{{env('R_INTEGRAL_NAME')}}(收)：</span>
                    <span>{{$r_integral_in}}</span>
                </div>

                <div class="bill-cell">
                    <span>{{env('R_INTEGRAL_NAME')}}(支)：</span>
                    <span>{{$r_integral_out}}</span>
                </div>--}}
            </div>

            <div class="table-out">
                <div class="table-handle">
                    @if($user['young_power'] == '20')
                        <a class="handle-cell handle-add" href="/tietong-man/create"><span
                                    class="icon_plus"></span>员工添加</a>
                        <a class="handle-cell handle-delete" href="javascript:;"><span
                                    class="icon_trash_alt"></span>批量删除</a>
                        <a class="handle-cell handle-add" href="/tietong-man-file"><span
                                    class="icon_plus"></span>导入</a>
                        <a class="handle-cell handle-add" href="/tietong-man-down"><span
                                    ></span>导出</a>
                    @endif
                    {{-- <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
                            type="text" name="begin_time" value="" placeholder="起始时间"/>
                     <input class="table-handle-input Wdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
                            type="text" name="end_time" value="" placeholder="结束时间"/>
                     <input id="submit" class="table-handle-submit" type="submit" value="筛选"/>--}}
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            <input id="1" class="checkAll" type="checkbox" name="" value=""/>
                            <label for="1"><span class="icon_check"></span></label>
                        </th>
                        <th>员工名称</th>
                        <th>年龄</th>
                        <th>入职时间</th>
                        <th>社保基数</th>

                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="tbody">
                    @if(count($list) <= 0)
                        <tr>
                            <td colspan='9'>没有数据</td>
                        </tr>
                    @else
                        @foreach($list as $k => $v)
                            <tr>
                                <td>
                                    <input class="table-check" id="{{$v->id}}" type="checkbox" name=""
                                           value="{{$v->id}}"/>
                                    <label for="{{$v->id}}"><span class="icon_check"></span></label>
                                </td>
                                <td>{{$v['young_name']}}</td>
                                <td>{{$v['young_age']}}</td>
                                <td>{{$v['young_join_time']}}</td>
                                <td>{{$v['young_safe_base']}}</td>
                                <td>
                                    <a class="table-handle-item table-info"
                                       href="/tietong-man/{{$v->id}}"><span
                                                class="icon_menu-square_alt2"></span>详情</a>
                                    @if($user['young_power'] == '20')
                                        <a class="table-handle-item table-edit"
                                           href="/tietong-man/{{$v->id}}/edit"><span
                                                    class="icon_pencil-edit"></span>编辑</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                {!! $page !!}

            </div>
        </form>

    </div>
</div>
</body>

@include('Tietong.js')
<script type="text/javascript" src="/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="/js/pc/table.js"></script>
<script type="text/javascript">

    //批量删除
    $('.handle-delete').click(function () {
        handle('/tietong-man/', 'delete', '删除');
    });

    //批量撤回
    $('.handle-withdraw').click(function () {
        handle('/tietong-man-back/', 'get', '撤回');
    });
</script>

</html>