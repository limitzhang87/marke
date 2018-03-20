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
        .user_status {
            position: absolute;
            right: 10px;
            font-size: 1.3rem;
            color: #ABABAB;
            line-height: 5rem;


        }
    </style>
    <div>
        <img class="swiper_img" src="/marke/Public/Mobile/images/banner_1.png" style="width: 100%;">
    </div>
    <div>
        			<div class="group_scroll" onclick="console.log($('.group_scroll').scrollLeft());">
			<?php if(is_array($groupList)): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] == $_id): ?><div class="group_on"><?php echo ($vo["name"]); ?></div>
			    <?php else: ?>
			        <div class="group" onclick="redirect('<?php echo U('Group/'.ACTION_NAME,array('id'=>$vo['id']));?>')"><?php echo ($vo["name"]); ?></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
        <div style="width: 100%;height:35px;border: solid #EBEBEB;border-width: 0 0 1PX 0;">
            <div class="left" style="padding: 0 0 0 20px;line-height: 35px;" >共<?php echo count($_list);?>个会员</div>
            <div class="right" style="width: 70px;margin: 0 auto;line-height: 35px;display: -webkit-box;" onclick="redirect('<?php echo U('Group/user_add',array('id'=>$_id));?>')">
                <li class="add_icon"></li>添加
            </div>
        </div>
        <div id="content">
        <?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item" onclick="redirect( '<?php echo U('User/index',array('uid'=>$vo['id']));?> ')" >
                <div class="item_info" style="display: -webkit-box;">
                    <div class=" head_img">
                        <img src="/marke/<?php echo ($vo["head_img"]); ?>">
                    </div>
                    <table class="user_table">
                        <tr>
                            <td>姓名：</td>
                            <td><?php echo ($vo["nick_name"]); ?></td>
                        </tr>
                        <tr>
                            <td>手机：</td>
                            <td><?php echo ($vo["phone"]); ?></td>
                        </tr>
                    </table>
                    <?php if($vo['status'] != '1' ): ?><div class="user_status">
                        已禁用
                    </div><?php endif; ?>
                </div>
                <div class="item_more">
                    <li class="arrow"></li>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
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
	
    
	<div style="height:4.5rem;"></div>
	<footer class="footer_fixed">
	    <div class="bottom_nav" style="width: 25%;" id="auth" onclick="redirect('<?php echo U('Group/menuList',array('id'=>$_id));?>')">
    		<li class="auth_icon" ></li>
       		<div class="bottom_name">菜单</div>
	    </div>
	    <div class="bottom_nav" style="width: 25%;" id="auth" onclick="redirect('<?php echo U('Group/bottomList',array('id'=>$_id));?>')">
    		<li class="auth_icon" ></li>
       		<div class="bottom_name">底部</div>
	    </div>
	    <div class="bottom_nav" style="width: 25%;"  id="user"  onclick="redirect('<?php echo U('Group/user',array('id'=>$_id));?>')">
	    	<li class="guser_icon"></li>
	       	<div class="bottom_name">会员</div>
	    </div>
	    <div class="bottom_nav" style="width: 25%;"  id="edit"  onclick="redirect('<?php echo U('Group/edit',array('id'=>$_id));?>')">
	    	<li class="edit_icon" ></li>
	       	<div class="bottom_name">编辑</div>
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
    		<img src="/marke/Public/Mobile/images/icon/load_3.gif" style="width: 70px;margin: 0 auto;display: block;">
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

	<script type="text/javascript" src="/marke/Public/Mobile/js/mobile.js"></script>
	
	<!-- 用于加载js代码 -->
	<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
	<?php echo hook('pageFooter', 'widget');?>
	<div class="hidden">
	    <!-- 用于加载统计代码等隐藏元素 -->
	    
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
        var left = $('.group_on').offset().left - $(window).width()/2+$('.group_on').width()/2;
        $('.group_scroll').scrollLeft(left);

        // $('#user div').removeClass('bottom_name');
        // $('#user li').removeClass('guser_icon');
        $('#user div').addClass('bottom_name_on');
        $('#user li').addClass('guser_icon_on');


        function forbit(){
            alert('禁用');
        }
    </script>



	<!-- /底部 -->
</body>
</html>