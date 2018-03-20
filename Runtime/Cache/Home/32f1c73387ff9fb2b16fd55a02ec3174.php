<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/> 
<title><?php echo C('WEB_SITE_TITLE');?></title>
<!-- <link href="/marke/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/marke/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/marke/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/marke/Public/static/bootstrap/css/onethink.css" rel="stylesheet"> -->
<link type="image/x-icon" rel="shortcut icon" href="/marke/Public/Home/images/favicon.ico">
<link rel="stylesheet" type="text/css" href="/marke/Public/Mobile/css/mobile.css" >
<!-- <link rel="stylesheet" type="text/css" href="/marke/Public/Mobile/css/smoke.css"> -->
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/marke/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/marke/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/marke/Public/static/jquery-2.0.3.min.js"></script>
<!-- <script type="text/javascript" src="/marke/Public/static/bootstrap/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="/marke/Public/Mobile/js/mobile.js"></script>
<!-- <script type="text/javascript" src="/marke/Public/Mobile/js/smoke.min.js"></script> -->
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->

</head>
<body>
	<!-- 头部 -->
	
    <div class="header_fixed" style="background-color: <?php echo ($bg_color); ?>">
        <div class="header_left">
            <li class="back" ></li>
        </div>
        <div class="title">
            <?php echo ($_title); ?>
        </div>
        <div class="header_right">
            <li class="more" onclick="redirect('<?php echo ($_right_url); ?>');" style="<?php echo ($_right_type); ?>"></li>
        </div>
    </div>
    <div style="height: 3.2rem;"></div>
    <script type="text/javascript">
    $('.header_left').on('click', function(){
        window.history.go(-1);
    });
    function logout() {
        $.ajax({
            url: "<?php echo U('login/logout');?>",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    alert('退出成功！');
                    setTimeout(function() {
                        window.location.href = data.url;
                    }, 1500);
                } else {
                    //self.find(".Validform_checktip").text(data.info);
                }
            },
            error: function(er) {}
        });
    }
    </script>



	<!-- /头部 -->

	<!-- 主体 -->
	<div id="main-container" class="container">
    
    <style type="text/css">
    .tip {
        font-size: 1.5rem;
        line-height: 2rem;
        height: 2rem;
        padding-left: 1rem;
        margin: 10px 0;
        color: #AAAAAA;
    }

    .btn_submit {
        width: 12rem;
    }
    </style>
    <form accept="" method="POST" enctype="multipart/from-data">
            <?php switch($field): case "head_img": ?><input type="hidden" name="head_img" value="<?php echo ($user["head_img"]); ?>">
                    <link rel="stylesheet" type="text/css" href="/marke/Public/static/editHeadThumb/css/font-awesome.4.6.0.css">
<link rel="stylesheet" href="/marke/Public/static/editHeadThumb/css/amazeui.min.css">
<link rel="stylesheet" href="/marke/Public/static/editHeadThumb/css/amazeui.cropper.css">
<link rel="stylesheet" href="/marke/Public/static/editHeadThumb/css/custom_up_img.css">
<style type="text/css">
.up-img-cover {
    width: 100px;
    height: 100px;
}

.up-img-cover img {
    width: 100%;
}
</style>
<center>
    <div class="up-img-cover" id="up-img-touch">
        <img class="am-circle" alt="点击图片上传" src="<?php echo ($user[$field]); ?>">
    </div>
</center>
<div><a style="text-align: center; display: block;" id="pic"></a></div>
<!--图片上传框-->
<div class="am-modal am-modal-no-btn up-frame-bj " tabindex="-1" id="doc-modal-1">
    <div class="am-modal-dialog up-frame-parent up-frame-radius">
        <div class="am-modal-hd up-frame-header">
            <label>修改头像</label>
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd  up-frame-body">
            <div class="am-g am-fl">
                <div class="am-form-group am-form-file">
                    <div class="am-fl">
                        <button type="button" class="am-btn am-btn-default am-btn-sm">
                            <i class="am-icon-cloud-upload"></i> 选择要上传的文件
                       </button>
                    </div>
                    <input type="file" id="inputImage">
                </div>
            </div>
            <div class="am-g am-fl">
                <div class="up-pre-before up-frame-radius">
                    <img alt="" src="" id="image">
                </div>
                <div class="up-pre-after up-frame-radius">
                </div>
            </div>
            <div class="am-g am-fl">
                <div class="up-control-btns" style="width: 180px;">
                    <span class="am-icon-rotate-left" onclick="rotateimgleft()"></span>
                    <span class="am-icon-rotate-right" onclick="rotateimgright()"></span>
                    <span class="am-icon-check" id="up-btn-ok" url="<?php echo U('User/upload_HeadImg');?>"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--加载框-->
<div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="my-modal-loading">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">正在上传...</div>
        <div class="am-modal-bd">
            <span class="am-icon-spinner am-icon-spin"></span>
        </div>
    </div>
</div>
<!--警告框-->
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">信息</div>
        <div class="am-modal-bd" id="alert_content">
            成功了
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn">确定</span>
        </div>
    </div>
</div>
<script src="/marke/Public/static/editHeadThumb/js/jquery-1.8.3.min.js"></script>
<script src="/marke/Public/static/editHeadThumb/js/amazeui.min.js" charset="utf-8"></script>
<script src="/marke/Public/static/editHeadThumb/js/cropper.min.js" charset="utf-8"></script>
<script src="/marke/Public/static/editHeadThumb/js/custom_up_img.js" charset="utf-8"></script>
                    <div class="tip"><div>点击头像上传</div></div><?php break;?>
                <?php case "phone": ?><center>
                        <div class="tip">
                            原手机号码:<?php echo ($user["phone"]); ?>
                        </div>
                        <div>
                            <div class="tip">请输入新的手机号码：</div>
                            <div>
                                <input type="number" name="phone"  value="<?php echo ($user["phone"]); ?>"> </div>
                        </div>
                    </center><?php break;?>
                <?php case "nick_name": ?><center>
                        <div class="tip">
                            原姓名:<?php echo ($user["nick_name"]); ?>
                        </div>
                        <div>
                            <div class="tip">请输入新的姓名：</div>
                            <div>
                                <input type="text" name="nick_name" value="<?php echo ($user["nick_name"]); ?>">
                            </div>
                        </div>
                    </center><?php break;?>
                <?php case "sex": ?><center class="tip">
                        修改性别
                    </center>
                    <div style="display: -webkit-box;height: 1rem; width: 18rem;margin: 10px auto;">
                        <div style="width: 6rem;">
                            <input type="radio" name="sex" value="1" <?php if($user['sex'] == 1 ): ?>checked<?php endif; ?>><span>男  </span>
                        </div>
                        <div style="width: 6rem;">
                            <input type="radio" name="sex" value="2" <?php if($user['sex'] == 2 ): ?>checked<?php endif; ?>>女
                        </div>
                        <div style="width: 6rem;">
                            <input type="radio" name="sex" value="0" <?php if($user['sex'] == 0 ): ?>checked<?php endif; ?>>未知
                        </div>
                    </div><?php break;?>
                <?php case "password": ?><table style="width: 90%;margin: 10px auto;">
                        <tr>
                            <td style="text-align: right;">旧密码:</td>
                            <td><input type="password" name="password_old"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">新密码:</td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">再次输入:</td>
                            <td><input type="password" name="password_re"></td>
                        </tr>
                    </table><?php break; endswitch;?>
        <center style="display: -webkit-box;width: 100%:">
            <input type="hidden" name="field" value="<?php echo ($field); ?>">
            <button class="button btn_submit status_success" type="button" onclick="javascript:history.go(-1);">返回</button>
            <button class="button btn_submit" type="submit">提交</button>
        </center>
    </form>

</div>
<script type="text/javascript">
    // $(function(){
    //     $(window).resize(function(){
    //         $("#main-container").css("min-height", $(window).height() - 120);
    //     }).resize();
    // });
    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=640){
                    docEl.style.fontSize = '18px';
                }else{
                    docEl.style.fontSize = 20 * (clientWidth / 640) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
	// 作者：_minooo_
	// 链接：http://www.jianshu.com/p/b00cd3506782
	// 來源：简书// 
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
<script type="text/javascript">
//(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "/marke", //当前网站地址
		"APP"    : "/marke/index.php?s=", //当前项目地址
		"PUBLIC" : "/marke/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
//})();
</script>

    <script type="text/javascript" charset="utf-8">
    hightLine('User/index');

    </script>



	<!-- /底部 -->
</body>
</html>