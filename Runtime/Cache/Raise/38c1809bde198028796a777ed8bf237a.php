<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>ZFT认筹系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="utf-8">
    <link href="/marke/Public/Mobile/css/login.css" type="text/css" rel="stylesheet">
    <style type="text/css">
        body{ margin:0; padding:0;}
        input[type="checkbox"] {
            margin: 0 ;
            height: 1rem;
            width: 1.2rem;
            padding-top: 0;
            vertical-align: middle;
            margin-right: 3px;
            font-family: inherit;
            font-size: inherit;
            font-weight: inherit;
        }
    </style>
</head>

<body>
    <div class="main">
        <div>
            <li class="login_logo"></li>
            <center><strong>ZFT认筹系统</strong></center>
        </div>
        <div class="center">
            <input class="phone" type="number" name="phone" id="phone" placeholder="请输入手机号码">
        </div>
        <div style="padding-bottom: 10px;width: 90%;margin: 0 auto;text-align: center;color: #f5b02C;">
            <span><input type="checkbox" id="read" name="read" value="1"></span>
            <span onclick="show_daolog()">本人已经阅读并同意选房协议</span>
        </div>
            <!-- <div  style="width: 50%;text-align: center;color: #f5b02d; ">忘记密码</div> -->
        <div class="center">
            <button class="btn login_btn" onClick="login();">登录</button>
        </div>
        <li class="load_icon_3"></li>
        <div class="tip"></div>
    </div>
    <div id="foot" class="foot">
        <center>☏ 技术支持:<strong>0898-66500367</strong></center>
    </div>
     <div id="dialog" class="dialog" name="dialog">
        <div class="dialog_shadow" onclick="hidedialog()"></div>
        <div class="dialog_window">
            <span class="dialog_close"  onclick="hidedialog()">X</span>
            <div class="dialog_content">
                <label class="c_title">购房协议</label>
                <div class="c_main"><?php echo ($agreement["agreement"]); ?></div>
            </div>
        </div>
    </div>
    <script src='/marke/Public/static/js/jquery-2.0.3.min.js'></script>
    <script type="text/javascript">
    $('.phone').focus(function() {
        $('.tip').hide();
        $(this).select();
    });
    $('.password').focus(function() {
        $('.tip').hide();
        $(this).select();
    });

    /**
     * 提示框提示
     */
    function tip(msg) {
        $('.tip').show();
        $('.tip').html(msg);
        setTimeout("$('.tip').hide()",3000);
    }
    function redirect($url) {
        window.location.href = $url;
    }
    function show_daolog(){
        $('#dialog').show();
    }
    /**模态框功能 ————START*/
    function hidedialog() {
        $('.dialog').hide();
    }

    /**
     * AJAX 提及登录信息
     * @return {[type]} [description]
     */
    function login() {
        var phone = $('#phone').val();
        var id = '<?php echo ($id); ?>';
        var houses = '<?php echo ($houses); ?>';
        if (id == '' || houses == '') {
            tip('页面失效，关闭页面重新扫描二维码');
            return;
        }
        if (phone == '' ) {
            tip('请输入手机号码');
            return;
        }
        var read = $('#read').prop('checked') ? 1:0;
        if(read == 0){
            tip('请认真阅读并同意选房协议');
            return;
        }
        $.ajax({
            type: "POST",
            url: "/marke/index.php?s=/Raise/Login/login",
            data: { 'id': id, 'cus_phone': phone, 'houses':houses},
            beforeSend: function() {
                $('.load_icon_3').show();
            },
            complete: function() {
                $('.load_icon_3').hide();
            },
            success: function(msg) {
                if (msg.status == 1) {
                    tip('登录成功！');
                    window.location.href = '/marke/index.php?s=/Raise/Index/index';
                } else {
                    if(msg.msg != undefined){
                        tip(msg.msg);
                    }else{
                        tip('登录失败');
                    }
                }
            }
        });
    };
    </script>
</body>

</html>