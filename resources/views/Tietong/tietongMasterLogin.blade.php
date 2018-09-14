<!DOCTYPE html>

<html>
<head>
    <title>刘钰川要的乱七八糟系统</title>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <!-- 移动端声明，按1比例缩放，禁止用户缩放 -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="format-detection" content="telephone=yes"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="format-detection" content="telephone=no"/> <!-- 禁止自动识别为电话号码 -->
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
</head>

<body>
<!--操作提示弹窗-->
<div class="popup" id="popup">
    <div class="icon_check_alt2"></div>
    <div class="icon_close_alt2"></div>
    <div class="pop-text">申请成功，我们会及时处理，请耐心等待！</div>
    <div class="button">
        <a class="sure sure1" href="###">前往xx</a>
        <a class="sure sure2" href="javascript:;">关闭</a>
    </div>
</div>

<!-- 弹窗遮罩 -->
<div class="screen"></div>

<!-- 登录框 -->
<div class="login">
    <!-- 登录标题 -->
    <h5 class="login-title">刘钰川要的乱七八糟系统</h5>
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <p class="hints"><span class="icon_close_alt" style="color: red"></span>{{$error}}</p>
    @endforeach
@endif


<!-- 登录表单 -->
    <form class="login-form" id="form" action="/tietong-login" method="post">
        <div class="login-form-cell inputOut">
            <span class="icon_profile login-form-icon"></span>
            <input class="login-form-item inputs" type="text" name="account_number"
                   value="{{is_null(old('account_number')) ? $account_number : old('account_number')}}"
                   placeholder="请输入管理员账号"/>
        </div>
        <p class="hint"><span class="icon_close_alt"></span>账号不能为空，请输入账号！</p>

        <div class="login-form-cell inputOut">
            <span class="icon_lock login-form-icon"></span>
            <input class="login-form-item inputs" type="password" name="password" value="" placeholder="请输入密码"/>
        </div>
        <p class="hint"><span class="icon_close_alt"></span>密码不能为空，请输入密码！</p>

        @if($login_files_times >= 3)
            <div class="login-form-cell inputOut">
                <div class="login-form-code">
                    <span class="icon_key login-form-icon"></span>
                    <input class="login-form-item inputs" type="number" name="code" value="" placeholder="请输入验证码"/>
                </div>
                <img class="login-form-codeImg" src="{{captcha_src()}}"
                     onclick="this.src='{{captcha_src()}}?'+Math.random()" alt="验证码"/>
            </div>
            <p class="hint"><span class="icon_close_alt"></span>验证码不能为空，请输入验证码！</p>
    @endif

    <!--<div class="login-form-cell1">
             <label class="login-form-label1" for="master">
                  <input class="login-form-input" id="master" type="radio" name="identity" value=""/>
                  <label class="login-form-radio">●</label>
                  <span class="login-form-radioText">管理员登录</span>
             </label>

             <label class="login-form-label1" for="member">
                  <input class="login-form-input" id="member" type="radio" name="identity" value=""/>
                  <label class="login-form-radio">●</label>
                  <span class="login-form-radioText">会员登录</span>
             </label>
        </div>
        <p class="hint"><span class="icon_close_alt"></span>请选择登录者身份！</p>-->

        <div class="login-form-cell">
            <label class="login-form-label" for="remeber">
                <input class="login-form-input" id="remeber" type="checkbox" name="remember" value="1"
                       @if(!is_null($account_number)) checked @endif/>
                <label class="icon_check login-form-check" for="remeber"></label>
                <span class="login-form-remeberText">记住账号</span>
            </label>
        </div>

        <button class="login-form-submit" type="submit" id="submit">立即登录</button>
    </form>
</div>
</body>

<script type="text/javascript" src="/js/jquery.1.12.4.min.js"></script>
<script type="text/javascript" src="/js/formAjax.js"></script>
<script type="text/javascript">
    $('#form').submit(function () {
        var num = 0;
	     $('#form').find('.inputs').each( function(){
	          if( !$(this).val() || $(this).val() == '' ){
	               $(this).parents('.inputOut').next('.hint').show(200);
	               num++;
	          }else{
	               $(this).parents('.inputOut').next('.hint').hide(200);
	          }
	     } );
	     
	     if( num != 0 ){
	          return false;
	     }else{
	          return true;
	     }
    });
</script>

</html>