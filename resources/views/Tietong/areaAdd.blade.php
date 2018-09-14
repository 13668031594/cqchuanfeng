@include('Tietong.header',['title' => '分中心添加'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <div class="index-search">
            <div class="index">
                <span class="index-text">分中心添加</span>
            </div>
        </div>

        <form class="form" id="form" action="/tietong-area" method="post">
            <div class="form-cell">
                <span class="form-cell-title">分中心名称</span>
                <input class="form-cell-input" type="text" name="name" value="{{old('name')}}" placeholder="请输入分中心名称"/>
            </div>

            <div class="form-cell">
                <span class="form-cell-title">排序</span>
                <input class="form-cell-input" type="number" name="sort" value="{{is_null(old('sort')) ? 500 : old('sort')}}" placeholder="请输入排序"/>
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