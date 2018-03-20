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
        .titleN{
            font-size: 1.6rem;
            line-height: 4.5rem;
            padding-left: 20px;
            display: -webkit-box;
        }
        .icon{
            margin-top: 1.3rem;
            height: 2rem;
            width: 2rem;
            display: block;
            background: url('/marke/Public/Mobile/images/icon/user_info.png') no-repeat;
            background-size: auto 1.8rem;
        }
        table{
            width: 80%;
            margin-left: 5%;
            font-size: 1.6rem;
        }
        tr{
            margin: 5px 0;
        }
        tr>td:first-child{
            min-width: 7rem;
            font-weight:bold;
            font-size: 1.3rem;
        }
        td>img{
           /* max-height: 20rem;*/
           height: auto;
        }

        .info{
            border: solid #EBEBEB 1px;
            margin:5px 10px;
            border-radius: 4px;
            min-height: 10rem;
            width: calc(100%-10px);
            padding: 10px 5px;
        }
        .info>div{
            height: 2rem;
            line-height: 2rem;
            float: left;
        }
        .l_info{
            width: 100%;
            display: -webkit-box;
        }
        .s_info{
            width: 49%;
            display: -webkit-box;
        }
        .info_title{
            min-width: 6rem;
            font-weight: bold;
        }
    </style>
    <table >
        <tr>
            <td>客户姓名：</td>
            <td><?php echo ($info["cus_name"]); ?></td>
        </tr>
        <tr>
            <td>客户手机：</td>
            <td><?php echo ($info["cus_phone"]); ?></td>
        </tr>
        <tr>
            <td>凭证图片：</td>
            <td><img src="/marke<?php echo get_cover($info['voucher_thumb']);?>" onclick="show_pic('<?php echo ($info['voucher_thumb']); ?>','/marke<?php echo get_cover($info['voucher_thumb']);?>')"></td>
        </tr>
        <tr>
            <td>凭证编码：</td>
            <td><?php echo ($info["voucher_number"]); ?></td>
        </tr>
        <tr>
            <td>顾问姓名：</td>
            <td><?php echo ($info["user_name"]); ?></td>
        </tr>
        <tr>
            <td>顾问电话：</td>
            <td><?php echo ($info["user_phone"]); ?></td>
        </tr>
        <tr>
            <td>认筹时间：</td>
            <td><?php echo (date('Y-m-d H:i:s',$info["created_time"])); ?></td>
        </tr>
    </table>
    <center>
    <?php if($info['status'] == 1 ): ?><div class=" status_success">审核已通过</div>
    <?php else: ?>
        <div class="status_over">审核未通过</div><?php endif; ?>
    </center>

    <?php if($info['room'] != null): ?><div>
        <h3 style="text-align: center;">已购房号</h3>
        <div class="info" onclick="toRoom('<?php echo ($info["room"]["id"]); ?>')">
            <div class="l_info">
                <div class="info_title">合同地址：</div>
                <div><?php echo getHouses('title'); echo ($info["room"]["b_name"]); ?>(栋)<?php echo ($info["room"]["u_name"]); ?>(单元)<?php echo ($info["room"]["room_number"]); ?></div>
            </div>
            <div class="s_info">
                <div class="info_title">房号：</div>
                <div><?php echo ($info["room"]["u_name"]); ?> - <?php echo ($info["room"]["room_number"]); ?></div>
            </div>
            <div class="s_info">
                <div class="info_title">面积：</div>
                <div><?php echo ($info["room"]["area"]); ?> m²</div>
            </div>
            <div class="s_info">
                <div class="info_title">朝向：</div>
                <div><?php echo ($info["room"]["orientation"]); ?></div>
            </div>
            <div class="l_info">
                <div class="info_title">户型：</div>
                <div><?php echo ($info["room"]["apartment"]); ?>室<?php echo ($info["room"]["hall"]); ?>厅<?php echo ($info["room"]["kitchen"]); ?>厨<?php echo ($info["room"]["toilet"]); ?>卫</div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="tip"><div>尚未购房，赶紧收场抢房吧！</div></div><?php endif; ?>
    <center>
        <button class="button btn_submit" style="margin: 30px auto;background-color: <?php echo ($bg_color); ?>" onclick="redirect('<?php echo U('Login/logout');?>');">
           退出登录
        </button>
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

    <script type="text/javascript" charset="utf-8">
    hightLine('User/index');
    function toRoom(id){
            var url = ThinkPHP.APP + '/Raise/Room/room_info/id/' + id;
            window.location.href = url;
        }
    </script>



	<!-- /底部 -->
</body>
</html>