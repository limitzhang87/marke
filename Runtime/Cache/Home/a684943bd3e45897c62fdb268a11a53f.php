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
        .btn_submit {
            width: 12rem;
        }
    </style>
    <div class="user_header" style="background-color: <?php echo ($bg_color); ?>;">
        <img class="user_head" src="<?php echo ($user["head_img"]); ?>">
        <div class="user_nick_name">
            <?php echo ($user["nick_name"]); ?>
        </div>
    </div>
    <div>
        <div class="item_s">
            <div style="font-size: 2rem;line-height: 4.5rem;margin-left: 10px;">会员管理</div>
        </div>
        <div class="item_s" onclick="redirect('<?php echo U('User/user_info',array('id'=>$user['id']));?>')">
            <div class="item_info">
                <div class="titleN" style=""><li class="icon" style="background-position: 0 0;"></li>会员信息</div>
            </div>
            <div class="item_more">
                <li class="arrow"></li>
            </div>
        </div>
        <div class="item_s" onclick="redirect('<?php echo U('User/jobAdjust',array('id'=>$user['id']));?>')">
            <div class="item_info">
                <div class="titleN" style=""><li class="icon" style="background-position: 0 0;"></li>职位调整</div>
            </div>
            <div class="item_more">
                <li class="arrow"></li>
            </div>
        </div>
    </div>
    <div>
        <div class="item_s">
            <div style="font-size: 2rem;line-height: 4.5rem;margin-left: 10px;">业绩统计</div>
        </div>
        <div class="item_s" onclick="redirect('<?php echo U('Report/index',array('type'=>2,'uid'=>$user['id']));?>')">
            <div class="item_info">
                <div class="titleN" style=""> <li class="icon" style="background-position: -4.5rem 0;"></li>他的成交统计</div>
            </div>
            <div class="item_more">
                <li class="arrow"></li>
            </div>
        </div>
        <div class="item_s" onclick="redirect('<?php echo U('Report/index',array('type'=>1,'uid'=>$user['id']));?>')">
            <div class="item_info">
                <div  class="titleN" style=""><li class="icon" style="background-position: -6.85rem 0;"></li>他的锁定统计</div>
            </div>
            <div class="item_more">
                <li class="arrow"></li>
            </div>
        </div>
    </div>
    <!-- <center style="display: -webkit-box;width: 100%:">
        <?php if($user['status'] == '1' ): ?><div style="width: 40%;margin: 0px 3%;" class="button btn_submit " onclick="forUser();">禁用 </div>
        <?php else: ?>
            <div style="width:40%;margin: 0px 3%;" class="button btn_submit status_over " onclick="acUser();">启用 </div><?php endif; ?>
        <button class="button btn_submit status_success" type="button" onclick="javascript:history.go(-1);">返回</button>
    </center> -->
     <center style="display: -webkit-box;width: 100%:">
        <?php if($user['status'] == '1' ): ?><button class="button btn_submit " onclick="forUser();">禁用 </button>
        <?php else: ?>
            <button class="button btn_submit status_over " onclick="acUser();">启用 </button><?php endif; ?>
            <button class="button btn_submit status_success" type="button" onclick="javascript:history.go(-1);">返回</button>
            <!-- <div style="width:40%;margin: 0px 3%;" class="button btn_submit " onclick="delUser();">删除 </div> -->
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

    <script type="text/javascript" charset="utf-8">
    hightLine('User/index');

    function delUser(){
        var res = confirm('是否删除该会员？删除后该会员的数据将全部清空。');
        if(res === false){
            return ;
        }
        var id = '<?php echo ($user["id"]); ?>';
        $.ajax({
            url:'/marke/index.php?s=/Home/User/delUser',
            type:'POST',
            data:{'id':id},
            error:function(){
                console.log(1);
            },
            success:function(msg){
                if(msg.status == 1){
                    alert('删除成功！');
                    window.location.href = document.referrer;
                }else{
                    alert('删除失败！');
                     window.location.href = document.referrer;
                }
            }
        });
    }

     function forUser(){
        var res = confirm('是否禁用会员？');
        if(res === false){
            return ;
        }
        var id = '<?php echo ($user["id"]); ?>';
        $.ajax({
            url:'/marke/index.php?s=/Home/User/forUser',
            type:'POST',
            data:{'id':id},
            error:function(){
                console.log(1);
            },
            success:function(msg){
                if(msg.status == 1){
                    alert('禁用成功！');
                    location.reload();
                }else{
                    alert('禁用失败！');
                    location.reload();
                }
            }
        });
    }

    function acUser(){
        var res = confirm('是否启用会员？');
        if(res === false){
            return ;
        }
        var id = '<?php echo ($user["id"]); ?>';
        $.ajax({
            url:'/marke/index.php?s=/Home/User/acUser',
            type:'POST',
            data:{'id':id},
            error:function(){
                console.log(1);
            },
            success:function(msg){
                if(msg.status == 1){
                    alert('启用成功！');
                    location.reload();
                }else{
                    alert('启用失败！');
                    location.reload();
                }
            }
        });
    }
    </script>



	<!-- /底部 -->
</body>
</html>