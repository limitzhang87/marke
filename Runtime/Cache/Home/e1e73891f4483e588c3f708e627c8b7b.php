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
	


	<!-- /头部 -->

	<!-- 主体 -->
	<div id="main-container" class="container">
    
    <link rel="stylesheet" type="text/css" href="/marke/Public/Mobile/share/nativeShare.css">
    <style type="text/css">
        .dialog {
            position: static;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
        }
        .dialog_shadow {
            position: fixed;
            z-index: 10001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
        }
        .tips_div {
            position: fixed;
            height: 100%;
            width: 260px;
            z-index: 10002;
            top: 2px;
            right: 5px;
        }
        .tips_div img {
            width: 260px;
            height: 165px;
        }
        .tips_div a {
            width: 240px;
            height: 34px;
            background: #eee;
            border: 1px solid #c2c2c2;
            font-size: 16px;
            text-align: center;
            line-height: 34px;
            margin: 25px auto 0;
            color: #666;
            display: block;
        }
        .btn1 {
        }
        .btn2 {
            border-radius: 5px;
        }
    </style>

    <div class="lp-con col-xs-12">
        <div id="main" style="width: 96%;margin: 10px auto;">
            <div style="padding-bottom: 10px;">
                <img src="<?php echo ($info["path"]); ?>" name="img" style="width: 100%;">
            </div>
            <div id="share">
                <div id="nativeShare"></div>
            </div>
            <div id="remind" style="color: red;display: none;">图片已经生成，可点击底部列表查看</div>

        </div>
    </div>
    <!-- 发送邀请提示框 （分享到微信） -->
    <div id="shareHint" class="dialog" style="display: none;">
        <div class="dialog_shadow" onclick="hideDialog();">
        </div>
        <div class="tips_div">
            <div>
                <img src="/marke/Public/Mobile/images/icon/tips.png"></div>
            <div style="text-align: center;">
                <a href="javascript:void(0)" onclick="hideHint()" title="关闭提示">关闭提示</a></div>
        </div>
    </div>

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

    <!-- <script src="/marke/Public/Home/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="/marke/Public/static/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="/marke/Public/Mobile/share/nativeShare.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    //提示分享框
    function showHint() {
        var isApp = 0;
        //isApp = isAppBrowser();
        if(isApp==1){
            setupWebViewJavascriptBridge(function(bridge) {
                bridge.callHandler('Share', {'url': url,'title':title,'message':content,'logo_type':'1'}, function(response) {});
            });
        }else{
            $("#shareHint").show();
            setTimeout("hideHint()", 5000);
        }
    }

    function hideHint() {
        $("#shareHint").hide();
    }


    var config = {
        url:'http://www.zfangw.net/index.php?s=Home/share/ownership_pic_show/id/<?php echo ($id); ?>',
        title:'置业计划',
        desc:'置业计划',
        img:'http://www.zfangw.net<?php echo ($info["path"]); ?>',
        img_title:'置业计划',
        from:'中房通'
    };
    var share_obj = new nativeShare('nativeShare',config);
    </script>



	<!-- /底部 -->
</body>
</html>