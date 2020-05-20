<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @if(!is_null($favicon = Admin::favicon()))
        <link rel="shortcut icon" href="{{$favicon}}">
@endif

<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat;background-size: cover;"@endif>
<div class="login-box">
    <div class="login-logo">
        <a href="{{ admin_url('/') }}"><b><font color="#ffffff">{{config('admin.name')}}</font></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ trans('admin.login') }}</p>
        <form action="{{ admin_url('auth/login') }}" method="post">
            <div class="form-group has-feedback {!! !$errors->has('username') ?: 'has-error' !!}">

                @if($errors->has('username'))
                    @foreach($errors->get('username') as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
                    @endforeach
                @endif

                <input type="text" class="form-control" placeholder="{{ trans('admin.username') }}" id="username" name="username" value="{{ old('username') }}" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

                @if($errors->has('password'))
                    @foreach($errors->get('password') as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
                    @endforeach
                @endif

                <input type="password" class="form-control" placeholder="{{ trans('admin.password') }}" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {!! !$errors->has('captcha') ?: 'has-error' !!}">
                @if($errors->has('captcha'))
                    @foreach($errors->get('captcha') as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
                    @endforeach
                @endif
                <label>
                    <input name="captcha" class="form-control code" type="number" size="6" oninput="if(value.length>6)value=value.slice(0,6)"  placeholder="验证码" style="width: 150px;">
                </label>
                <button type="button" class="codeBtn btn " id="codeBtn">发送验证码</button>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    @if(config('admin.auth.remember'))
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" value="1" {{ (!old('username') || old('remember')) ? 'checked' : '' }}>
                                {{ trans('admin.remember_me') }}
                            </label>
                        </div>
                    @endif
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

<script type="text/javascript">
    var timer="";
    var nums=60;
    var validCode=true;//定义该变量是为了处理后面的重复点击事件
    $(".codeBtn").on('click',function(){
        var phone = $('#username').val();
        if(phone==''){
            alert('用户名不能为空');
            return false;
        } else {
            var code=$(this);
            if(validCode){
                validCode=false;
                timer=setInterval(function(){
                    if(nums>0){
                        nums--;
                        code.text(nums+"s重新发送");
                        code.addClass("redColor");
                    }
                    else{
                        clearInterval(timer);
                        nums=60;//重置回去
                        validCode=true;
                        code.removeAttr("disabled");
                        code.removeClass("redColor");
                        code.text("发送验证码");
                        code.css('color', '#0b74de');
                    }
                },1000)
            }
        }

        $.ajax({
            type:'post',
            url:'/login/code',
            data:{'mobile':phone,'type':1},
            success:function (str) {
                if(str.code != 200){
                    clearInterval(timer);
                    $(".codeBtn").removeClass("redColor");
                    $(".codeBtn").text("发送验证码");
                    alert(str.msg);
                } else if(str.code == 200){
                    document.getElementById("codeBtn").setAttribute("disabled",true);
                    $('#codeBtn').css('color','#9da2a7');
                }
            }
        })
    })
</script>

</body>
</html>