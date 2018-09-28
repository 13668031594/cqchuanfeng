@include('Tietong.header',['title' => '员工导入'])

<!-- 外部盒子 -->
<div class="out">
@include('Tietong.left')

<!-- 内容区 -->
    <div class="content">
        <div class="index-search">
            <div class="index">
                <span class="index-text">员工导入</span>
            </div>
        </div>

        <form class="form" id="form" action="/tietong-man-file" method="post" enctype="multipart/form-data">

            <div class="form-cell">
                <span class="form-cell-title">excel文件</span>
                <input type="file" name="excel" value=""
                       placeholder="请选择xls或xlsx后缀的文件"/>
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