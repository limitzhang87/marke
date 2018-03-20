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
<link type="image/x-icon" rel="shortcut icon" href="/marke/Public/Raise/images/favicon.ico">
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
    <div id="time" style="width: 100%;height: 1.2rem;background-color: #EEEE00;text-align: center;">
        开盘时间倒计时
    </div>
    <script type="text/javascript">
        $('.header_left').on('click', function(){
            window.history.go(-1);
        });
        var start_time = '<?php echo ($start_time); ?>';
        if(start_time>0){
            if(new Date() >= new Date(start_time * 1000)){
                 $('#time').html("楼盘已经开始认筹！");
            }else{
                getCountDown(start_time);
            }
        }

        function getCountDown(timestamp){
            var timer = setInterval(function(){
                var nowTime = new Date();
                var endTime = new Date(timestamp * 1000);

                if(nowTime >= endTime){
                    clearInterval(timer);
                    $('#time').html("楼盘已经开始认筹！");
                }
                var t = endTime.getTime() - nowTime.getTime();
                if(t<=0){
                    $('#time').html("楼盘已经开始认筹！");
                    clearInterval(timer);
                    return ;
                }
                var d=Math.floor(t/1000/60/60/24);
                var hour=Math.floor(t/1000/60/60%24);
                var min=Math.floor(t/1000/60%60);
                var sec=Math.floor(t/1000%60);
                if (d < 10) {
                     d = "0" +  d;
                }
                if (hour < 10) {
                     hour = "0" + hour;
                }
                if (min < 10) {
                     min = "0" + min;
                }
                if (sec < 10) {
                     sec = "0" + sec;
                }
                var countDownTime = '开盘倒计时：<span style="color:red;">'+　d +'</span>天<span style="color:red;">'+ hour + '</span>小时<span style="color:red;">' + min + '</span>分<span style="color:red;">' + sec +'</span>秒';
                $('#time').html(countDownTime);
            },1000);
        }
    </script>

	<!-- /头部 -->

	<!-- 主体 -->
	<div id="main-container" class="container">
    
	<style type="text/css">
        .bulletin_title {
            height: 60%;
        }
        .bulletin_title label{
            margin-left: 5px;
            font-size: 2rem;
            line-height: 3rem;
        }
        #picdiv>img{
        	width: 90%;
        	margin: 5px 5%;
        }
        .upload-pre-file {
			margin: 5px auto;
			width: 90%;
			height: 2rem;
			line-height: 2rem;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			border: 1px dashed #ccc;
			background-color: #fff;
		}
		.upload_icon_all {
			width: 15px;
			height: 15px;
			background: url(/marke/Public/Mobile/images/icon/attachment_1.png);
			display: inline-block;
			vertical-align: middle;
			margin-right: 5px
		}
		a{
			text-decoration:none;
		}
    </style>
    <div style="padding: 0 10px;">
    	<div class="bulletin_title">
			<li></li>
			<label><?php echo ($info["title"]); ?></label>
		</div>

		<div style="height: 40%;display: -webkit-box;color: #AAAAAA;font-size: 0.8em;">
	        <div style="margin-left: 10px;width: 12rem;">发布于：<span id="create_time"><?php echo ($info["created_time"]); ?></span> </div>
	        <div>浏览数：<?php echo ($info["view"]); ?></div>
	    </div>
		<div style="margin: 10px 0;text-indent:25px;font-size: 1.5rem;">
			<?php echo ($info["content"]); ?>
		</div>
		<div id="picdiv">
			<?php if(is_array($info['pictures'])): $i = 0; $__LIST__ = $info['pictures'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$picture): $mod = ($i % 2 );++$i;?><img src="./<?php echo get_cover($picture);?>"><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div>
			<?php if(is_array($info['file'])): $i = 0; $__LIST__ = $info['file'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><div class="upload-pre-file"><span class="upload_icon_all"></span><a href="<?php echo U('File/download',array('id'=>$file));?>"><?php echo get_filename($file);?> </a></div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
    </div>
	<div style="z-index: -1;position: fixed;bottom: 50px;">
		<img src="/marke/Public/Mobile/images/icon/houses_bg.png">
	</div>
    <?php if(is_auth(AUTH_RAISE_MANAGE)): ?><div class="fixed_add" style="background-color: <?php echo ($bg_color); ?>; padding: 6px;" onclick="redirect('<?php echo U('editBulletin',array('id'=>$info['id']));?>')">
            <img src="/marke/Public/Mobile/images/icon/edit.png">
        </div><?php endif; ?>

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
                    docEl.style.fontSize = '20px';
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
	
	<div style="height:4.5rem;"></div>
	<footer class="footer_fixed">
		<div class="bottom_nav"  onclick="redirect('<?php echo U('Index/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/home.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">全部房源</div>
	    </div>
	    <div class="bottom_nav" onclick="redirect('<?php echo U('User/collect');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/home.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">我的收藏</div>
	    </div>
	    <div class="bottom_nav" onclick="redirect('<?php echo U('Houses/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/home.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">楼盘详情</div>
	    </div>
	    <div class="bottom_nav"  onclick="redirect('<?php echo U('User/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/my.png') no-repeat;-webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">个人中心</div>
	    </div>
	</footer>
	<div id="dialog" class="dialog" name="dialog">
        <div class="dialog_shadow" onclick="hidedialog()"></div>
        <div class="dialog_window">
            <li class="dialog_close">X</li>
            <div class="dialog_content">
                <label class="c_title">这是标题</label>
                <div class="c_main">内容</div>
            </div>
        </div>
    </div>
    <div id="dialog_load" class="dialog" >
        <div class="dialog_shadow" onclick="hidedialog()"></div>
		<div style="position: fixed;z-index: 1002;top:45%;width: 100%;">
    		<img src="/marke/Public/Mobile/images/icon/load_3.gif" style="width: 50px;margin: 0 auto;display: block;">
		</div>
    </div>
    <div id="dialog_empty" class="dialog newdialog" >
    	<div class="close_red" onclick="hidedialog()" style="position: fixed;z-index: 1005;top:2%;right: 1%;width: 3rem;height: 3rem;line-height: 2.8rem;font-size: 3rem;">x</div>
		<div style="z-index: 1002;width: 100%;margin-top: 10px;" id="empty_content">
		</div>
    </div>

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

	<script type="text/javascript">
		hightLine('Raise/index');
		$(function(){
			$('#create_time').html(getDateDiff( $('#create_time').html() ));
		});
	</script>



	<!-- /底部 -->
</body>
</html>