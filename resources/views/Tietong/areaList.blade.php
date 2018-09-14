@include('Tietong.header',['title' => '分中心列表'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <form action="/tietong-area" method="get">
            <div class="index-search">
                <div class="index">
                    <span class="index-text">分中心列表</span>
                </div>

               {{-- <div class="search">
                    <select class="search-select" name="theSelectGroups[select_vague][0][key]">
                        <option value="id"
                                @if(in_array('id', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心编号 ▼：
                        </option>

                        <option value="name"
                                @if(in_array('name', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心姓名 ▼：
                        </option>
                        <option value="phone"
                                @if(in_array('phone', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心电话 ▼：
                        </option>
                        <option value="age"
                                @if(in_array('age', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心年龄 ▼：
                        </option>
                        <option value="address"
                                @if(in_array('address', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心地址 ▼：
                        </option>
                        <option value="note"
                                @if(in_array('note', array_keys($theSelectGroups['select_vague'])))
                                selected
                                @endif
                        >分中心备注 ▼：
                        </option>
                    </select>
                    <input class="search-input" type="text" name="theSelectGroups[select_vague][0][value]"
                           @if(in_array('name', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['name']}}"
                           @elseif(in_array('phone', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['phone']}}"
                           @elseif(in_array('age', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['age']}}"
                           @elseif(in_array('address', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['address']}}"
                           @elseif(in_array('note', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['note']}}"
                           @elseif(in_array('id', array_keys($theSelectGroups['select_vague'])))
                           value="{{$theSelectGroups['select_vague']['id']}}"
                           @endif
                           placeholder="请输入相应搜索内容"/>
                    <input class="search-submit" type="submit" value="搜索"/>
                </div>--}}
            </div>

            <!-- 分中心总数 新增分中心、签到人数 -->
            <div class="bill">
          {{--      <div class="bill-cell">
                    <span>分中心总数：</span>
                    <span>{{$customer_number}}</span>
                </div>

                <div class="bill-cell">
                    <span>今日新增分中心：</span>
                    <span>{{$today}}</span>
                </div>

                <div class="bill-cell">
                    <span>昨日新增分中心：</span>
                    <span>{{$yesterday}}</span>
                </div>

                <div class="bill-cell">
                    <span>今日签到人数：</span>
                    <span>{{$today_sign_number}}</span>
                </div>--}}
            </div>

            <div class="table-out">
                <div class="table-handle">
                    <a class="handle-cell handle-add" href="/tietong-area/create"><span
                                class="icon_plus"></span>添加分中心</a>
                    <a class="handle-cell handle-delete" href="javascript:;"><span class="icon_trash_alt"></span>批量删除</a>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            <input id="1s" class="checkAll" type="checkbox" name="" value=""/>
                            <label for="1s"><span class="icon_check"></span></label>
                        </th>
                        <th>名称</th>
                        <th>排序</th>

                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="tbody">
                    @if(count($list) <= 0)
                        <tr>
                            <td colspan='10'>没有数据</td>
                        </tr>
                    @else
                        @foreach($list as $k => $v)
                            <tr>
                                <td>
                                    <input class="table-check" id="{{$v->id}}" type="checkbox" name="" value="{{$v->id}}"/>
                                    <label for="{{$v->id}}"><span class="icon_check"></span></label>
                                </td>
                               <td>{{$v['young_name']}}</td>
                                <td>{{$v['young_sort']}}</td>

                                <td>
                                    <a class="table-handle-item table-edit"
                                       href="/tietong-area/{{$v->id}}/edit"><span
                                                class="icon_pencil-edit"></span>编辑</a>
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
<script type="text/javascript" src="/js/pc/table.js"></script>
<script type="text/javascript">

    //批量删除
    $('.handle-delete').click(function () {
        handle('/tietong-area/', 'delete', '删除', '');
    });

    $('.table-change').click(function () {
        var change = $(this);
        $(scrn).show().click(function () {
            console.log('点击了遮罩层');
            $(this).hide();
            $(pop).hide(300);
            $(this).off('click');
        });
        $(pop).find('.pop-text').text('确定要将该分中心注册成为会员吗？');
        $(yes).attr('href', 'javascript:;').text('确定').show().click(function () {
            $.getJSON($(change).attr('lang'), function (data) {
                $(pop).hide();
                $(scrn).hide();
                success(data);
            });

            $(this).off('click');
        });
        $(no).text('取消').show().click(function () {
            $(scrn).hide();
            $(pop).hide(300);
            $(this).off('click');
        });
        popupShow(pop);
    });

    $('.table-sign').click(function () {
        var text = $(this).prev('input').val();
        var change = $(this);
        $(scrn).show().click(function () {
            console.log('点击了遮罩层');
            $(this).hide();
            $(pop).hide(300);
            $(this).off('click');
        });
        $(pop).find('.pop-text').text('该分中心上一次签到日期为：【 ' + text + ' 】,确定签到吗？');
        $(yes).attr('href', 'javascript:;').text('确定').show().click(function () {
            $.getJSON($(change).attr('lang'), function (data) {
                $(pop).hide();
                success(data);
            });

            $(this).off('click');
        });
        $(no).text('取消').show().click(function () {
            $(scrn).hide();
            $(pop).hide(300);
            $(this).off('click');
        });
        popupShow(pop);
    });
</script>

</html>