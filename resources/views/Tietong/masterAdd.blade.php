@include('Tietong.header',['title' => '管理员添加'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <div class="index-search">
            <div class="index">
                <span class="index-text">管理员添加</span>
            </div>
        </div>

        <form class="form" id="form" action="/tietong-master" method="post">
            <div class="form-cell">
                <span class="form-cell-title">管理员昵称</span>
                <input class="form-cell-input" type="text" name="nickname" value="{{old('nickname')}}"
                       placeholder="请输入管理员昵称"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">账号</span>
                <input class="form-cell-input" type="text" name="account_number" value="{{old('account_number')}}"
                       placeholder="请输入管理员账号"/>
            </div>

            <div class="form-cell">
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
            </div>


            <div class="form-cell-submit">
                <button class="form-submit" type="submit" id="submit">确认并提交</button>
            </div>
        </form>
    </div>
</div>
</body>

@include('Tietong.js')
<script type="text/javascript">
    $('#form').submit(function () {
        verify(Ajax, this, success, '正在提交...');
        return false;
    });
</script>

</html>