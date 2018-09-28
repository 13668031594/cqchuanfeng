<!DOCTYPE html>

<html>
<head>
    <title>{{isset($title) ? $title : ''}}</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="/css/pc/index.css"/>
</head>

<body>

<!--操作提示弹窗-->
<div class="popup" id="popup">
    <div class="icon_check_alt2" id="success"></div>
    <div class="icon_close_alt2" id="fail"></div>
    <div class="pop-text">申请成功，我们会及时处理，请耐心等待！</div>
    <div class="button">
        <a class="sure sure1" id="sure" href="###">前往xx</a>
        <a class="sure sure2" id="notsure" href="javascript:;">关闭</a>
    </div>
</div>

<div class="popup" id="pop">
    <div class="icon_info_alt"></div>
    <div class="pop-text">申请成功，我们会及时处理，请耐心等待！</div>
    <input class="pop-password" id="pas" type="password" maxlength="6" value="" placeholder="请输入6位操作密码"/>
    <div class="button">
        <a class="sure sure1" id="yes" href="###">前往xx</a>
        <a class="sure sure2" id="no" href="javascript:;">关闭</a>
    </div>
</div>

<!-- 弹窗遮罩 -->
<div class="screen"></div>

<!-- 遮罩 -->
<div class="scrn"></div>

<!-- 顶部 -->
<div class="header">
    <div class="logo">重庆川峰通信技术服务有限公司人力资源系统</div>

    <ul class="header-handle">
        <li>
            <span class="icon_profile"></span>
            <span class="header-name" title="{{$user->young_nickname}}">{{$user->young_nickname}}</span>
        </li>

        <li class="back">
            <span class="arrow_back"></span>
            <span>返回上页</span>
        </li>

        <li class="refresh">
            <span class="icon_refresh"></span>
            <span>刷新页面</span>
        </li>

        <li class="logout">
            <span class="icon_target"></span>
            <span>注销退出</span>
        </li>
    </ul>
</div>

<input type="hidden" id="exit" value="{{$out}}"/>