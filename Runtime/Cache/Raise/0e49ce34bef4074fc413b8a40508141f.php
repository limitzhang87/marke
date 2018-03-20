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
        strong{
            font-size: 1.8rem;
            text-align: center;
            display: block;
            margin: 10px;
        }
        table{
            font-size: 1.3rem;
        }
        tr{
            width: 100%;
            height: 2rem;
        }
        .tdl{
            text-align: right;
            font-weight: bolder;
            font-family: Tahoma, Geneva, sans-serif;
            min-width: 7rem;
        }
        h2{
            font-size: 1.6rem;
            height: 3rem;
            line-height: 3rem;
            border: solid red;
            border-width: 0 0 2px 0;
            padding-left: 10px;
        }
    </style>
    <strong>
        <?php echo ($data["title"]); ?>
    </strong>
    <div class="mod-hd"><h2>基本信息</h2></div>
    <div style="width: 96%;margin: 10px auto;">
        <table>
            <tr>
                <td class="tdl">楼盘地址:</td>
                <td><?php echo ($data["address"]); ?></td>
            </tr>
            <!-- <tr>
                <td class="tdl">项目特色:</td>
                <td><?php if($data['housefeature'] == null): ?>暂无数据<?php else: echo (get_checkbox("HOUSE_HOUSEFEATURE",$data["housefeature"])); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">装修情况:</td>
                <td><?php if($data['renovation'] == null): ?>暂无数据<?php else: echo (get_checkbox("HOUSE_RENOVATION",$data["renovation"])); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">建筑类别:</td>
                <td><?php if($data['hcategory'] == null): ?>暂无数据<?php else: echo (get_checkbox("HOUSE_HCATEGORY",$data["hcategory"])); endif; ?></td>
            </tr> -->
            <tr>
                <td class="tdl">占地面积:</td>
                <td><?php if($data['areacovered'] == null): ?>暂无数据<?php else: echo ($data["areacovered"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">容 积 率:</td>
                <td><?php if($data['plotratio'] == null): ?>暂无数据<?php else: echo ($data["plotratio"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">绿 化 率:</td>
                <td><?php if($data['greeningrate'] == null): ?>暂无数据<?php else: echo ($data["greeningrate"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">开盘时间:</td>
                <td>
                    <?php if($data['openingtime']=='1970-01-01'){ if($data['openingtime_remark']==''){ echo "未定"; }else{ echo $data['openingtime_remark']; } }else{ echo $data['openingtime']; } ?>
                </td>
            </tr>
            <tr>
                <td class="tdl">交房时间:</td>
                <td>
                    <?php if($data['launchtime']=='1970-01-01'){ if($data['launchtime_remark']==''){ echo "未定"; }else{ echo $data['launchtime_remark']; } }else{ echo $data['launchtime']; } ?>
                </td>
            </tr>
            <tr>
                <td class="tdl">物业公司:</td>
                <td><?php if($data['mcompany'] == null): ?>暂无数据<?php else: echo ($data["mcompany"]); endif; ?></span></td>
            </tr>
            <tr>
                <td class="tdl">物业类型:</td>
                <td><?php if($data['housetype'] == null): ?>暂无数据<?php else: echo (get_housetype($data["housetype"])); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">开 发 商:</td>
                <td><?php if($data['developer'] == null): ?>暂无数据<?php else: echo ($data["developer"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">销售许可证:</td>
                <td><?php if($data['salepermit'] == null): ?>暂无数据<?php else: echo ($data["salepermit"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">售楼地址:</td>
                <td><?php if($data['salesaddress'] == null): ?>暂无数据<?php else: echo ($data["salesaddress"]); endif; ?></td>
            </tr>
            <tr>
                <td class="tdl">售楼电话:</td>
                <td><?php if($data['salesphone'] == null): ?>暂无数据<?php else: echo ($data["salesphone"]); endif; ?></td>
            </tr>
        </table>
        <div>
            <div class="mod-hd"><h2>楼盘介绍</h2></div>
            <ul style='padding:0 10px;font-size: 1.3rem;'>
                <li style='color:#000;font-family:"微软雅黑"' class='fon-si'><p style='text-indent:2em'><?php echo ($data["description"]); ?></p></li>
            </ul>
        </div>
    </div>
    <?php if(is_auth(AUTH_HOUSE_MANAGE)): ?><div class="fixed_add" style="background-color: <?php echo ($bg_color); ?>; padding: 6px;" onclick="redirect('<?php echo U('Houses/edit');?>')">
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
         hightLine('Houses/index');
    </script>



	<!-- /底部 -->
</body>
</html>