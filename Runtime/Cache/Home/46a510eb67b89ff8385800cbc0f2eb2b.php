<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/> 
<title><?php echo ($_title); ?></title>
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
        .page {
            height: 100%;
            width: calc(25% - 1px);
            font-size: 1.5rem;
            line-height: 30px;
            text-align: center;
        }

        .page_on {
            color: #f00;
            border: #f00 solid;
            border-width: 0 0 2px 0;
        }

        button {
            border:none;
            font-size: 1.2rem;
            height: 2em;
            width: 8rem;
            margin-left: 1rem;
        }
    </style>
    <div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff;">
        <div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff; display: -webkit-box;">
            <div class="page page_on"  >商城管理</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page"  onclick="redirect('<?php echo U('bulletinList',array('type'=>1));?>')">公告列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page"  onclick="redirect('<?php echo U('bulletinList',array('type'=>0));?>')">信息列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page" onclick="redirect('<?php echo U('lists');?>')">认购列表</div>
        </div>
    </div>
    <div id="time" style="width: 100%;height: 1.2rem;background-color: #EEEE00;text-align: center;">
        开盘时间倒计时
    </div>

    <center style="margin-top: 10px;">
        <button class="status_success" onclick="redirect('<?php echo U('addBulletin',array('type'=>1));?>')">发布公告</button>
        <button class="status_success" onclick="redirect('<?php echo U('addBulletin',array('type'=>0));?>')">发布信息</button>
    </center>
    <div style="min-height: 20rem;">
        <?php if($info['start_time'] > 0): ?><div style="text-align: center;font-size: 1.6rem;">
                <p >开盘时间</p>
                <p><?php echo (date('Y年m月d日 H:i:s',$info["start_time"])); ?></p>
            </div>
        <?php else: ?>
            <div style="font-size: 2rem;text-align: center;">
                <p>请设置开盘时间</p>
            </div><?php endif; ?>
        <div style="width: 80%;margin: 0 auto;">
            <p>登录协议：</p>
            <p style="text-indent:2rem;"><?php echo ($info["agreement"]); ?></p>
        </div>
        <div style="width: 80%;margin: 0 auto;">
            <p>备注：</p>
            <p style="text-indent:2rem;"><?php echo ($info["remark"]); ?></p>
        </div>
    </div>
    <center>
        <div class="button btn_submit" onclick="redirect('<?php echo U('houses_info');?>')">编辑</div>
    </center>

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
	
	<div style="height:4.5rem;"></div>
	<footer class="footer_fixed">
		<div class="bottom_nav"  style="width: <?php echo ($_bottom_w); ?>" onclick="redirect('<?php echo U('Index/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/home.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">首页</div>
	    </div>
	    <?php if(is_array($_bottom)): $i = 0; $__LIST__ = $_bottom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="bottom_nav"  style="width: <?php echo ($_bottom_w); ?>" onclick="redirect('<?php echo U($vo["path"]);?>')">
	    	<li class="bottom_icon"  style="background: url('/marke<?php echo ($vo['icon']); ?>') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name"><?php echo ($vo["title"]); ?></div>
	    </div><?php endforeach; endif; else: echo "" ;endif; ?>
	    <div class="bottom_nav"  style="width: <?php echo ($_bottom_w); ?>" onclick="redirect('<?php echo U('User/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/my.png') no-repeat;-webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">个人</div>
	    </div>
	</footer>
	<div id="dialog" class="dialog" name="dialog">
        <div class="dialog_shadow" onclick="hidedialog()"></div>
        <div class="dialog_window">
            <li class="dialog_close">X</li>
            <div class="dialog_content">
                <label class="c_title">这是标题</label>
                <div class="c_main">这话四内提供 阿斯蒂芬姐啊算咯姐姐啊弗朗基安静啊咧啊垃圾</div>
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
        var start_time = '<?php echo ($info["start_time"]); ?>';
        if(start_time>0){
            if(new Date() >= new Date(start_time * 1000)){
                 $('#time').html("楼盘已经开始认购！");
            }else{
                getCountDown(start_time);
            }
        }
        function getCountDown(timestamp){
            setInterval(function(){
                var nowTime = new Date();
                var endTime = new Date(timestamp * 1000);

                var t = endTime.getTime() - nowTime.getTime();
                if(t<=0){
                    $('#time').html("楼盘已经开始认购！");
                    console.log(111);
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
       //调用函数：getCountDown(1451556000);//
    </script>



	<!-- /底部 -->
</body>
</html>