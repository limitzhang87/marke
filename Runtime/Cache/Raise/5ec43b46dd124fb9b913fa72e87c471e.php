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

    <link rel="stylesheet" href="/marke/Public/static/swiper/css/swiper.min.css">

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
    

    <div style="width :100%;background-color: rgb(229, 229, 229);">
        <div class="module">
            <div id="div_menu" class="div_menu" style="margin: 0px;padding-top: 10px;">
                <div class="swiper_mune">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="menu">
                                    <div class="menu_list" onclick="redirect('<?php echo U('Raise/bulletinList',array('type'=>0));?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_news.png') no-repeat;"></li>
                                        <div>商城信息</div>
                                    </div>
                                    <div class="menu_list" onclick="redirect('<?php echo U('Raise/bulletinList',array('type'=>1));?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_bulletin.png') no-repeat;"></li>
                                        <div>商城公告</div>
                                    </div>
                                    <div class="menu_list" onclick="redirect('<?php echo U('Houses/index');?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_housesInfo.png') no-repeat;"></li>
                                        <div>楼盘详情</div>
                                    </div>
                                    <div class="menu_list" onclick="redirect('<?php echo U('HousesNew/index');?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_housesNew.png') no-repeat;"></li>
                                        <div>楼盘动态</div>
                                    </div>
                                    <div class="menu_list" onclick="redirect('<?php echo U('HousesImg/index');?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_housesImg.png') no-repeat;"></li>
                                        <div>楼盘相册</div>
                                    </div>
                                    <div class="menu_list" onclick="redirect('<?php echo U('User/collect');?>')">
                                        <li class="" style=" background: url('/marke/Public/Mobile/images/icon/icon_collect.png') no-repeat;"></li>
                                        <div>我的收藏</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination" style="bottom: -2px;"></div>
                    </div>
                </div>
            </div>
            <div class="div_houses">
                <div class="houses_head">
                    <div id="houses_title" class="houses_title left" style="">
                        <li class="building_icon"></li>
                        <span class="font_title " style="padding-left: 5px; padding-top: 10px;">房源列表
                        </span>
                    </div>
                    <div id="hosues_search" class="hosues_search right hide">
                        <span class="right" style="padding-right: 10px;padding-top: 5px;">
                            <li class="search_icon"></li>
                            <span id="search">搜索：</span>
                            <span style="color: red;" id="search_b">栋号</span>
                            <span style="color: red;">|</span>
                            <span style="color: red;" id="search_u">单元</span>
                        </span>
                        <span id="search_input" class="right hide" >
                            <input type="text" name="search_kw" id="search_kw" style="margin: 0 0 0 10px;width: 1px;">
                        </span>
                    </div>
                </div>
                <div class="select">
                    <div class="select_name"><span>栋号</span></div>
                    <div class="scroll_list" id="building_list">
                        <!-- <div class="button">楼1</div>
                        <div class="button button_on">楼2</div>
                        <div class="button">楼3</div>
                        <div class="button">楼4</div>
                        <div class="button">楼5</div> -->
                    </div>
                </div>
                <div class="select">
                    <div class="select_name"><span>单元</span></div>
                    <div class="scroll_list" id="unit_list">
                        <!-- <div class="button button_on">单元1</div>
                        <div class="button">单元2</div>
                        <div class="button">单元3</div> -->
                    </div>
                </div>
                <!-- <center class="select_value">
                    <span class="">楼1</span>
                    <span class="">单元1</span>
                </center> -->
                <div class="houses_tip">
                    <!-- <center>
                        <span class="status_success"></span>&nbsp;未售
                        <span class="status_waring"></span>&nbsp;锁定
                        <span class="status_error"></span>&nbsp;已售
                    </center> -->
                </div>
                <div class="houses" id="room_list">
                    <!-- <div class="floor">
                        <div class="floor_num">1</div>
                        <div class="room_info">
                            <div class="room_number status_success">0101</div>
                            <div class="room_number status_over">0102</div>
                            <div class="room_number status_waring">0103</div>
                            <div class="room_number status_error">0104</div>
                        </div>
                    </div> -->
                </div>
                <center>
                    <button class="more_btn" >查看更多</button>
                </center>
            </div>
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
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/icon_collect_b.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
	       	<div class="bottom_name">我的收藏</div>
	    </div>
	    <div class="bottom_nav" onclick="redirect('<?php echo U('Houses/index');?>')">
	    	<li class="bottom_icon"  style="background: url('/marke/Public/Mobile/images/icon/icon_housesInfo_b.png') no-repeat; -webkit-background-size: auto 4.6em;"></li>
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

    <script type="text/javascript" src="/marke/Public/static/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="/marke/Public/Mobile/js/index.js"></script>
    <script type="text/javascript" src="/marke/Public/Mobile/js/getHouseRaise.js"></script>
    <script type="text/javascript">
        getBuilding();
        hightLine('Index/index');
    </script>



	<!-- /底部 -->
</body>
</html>