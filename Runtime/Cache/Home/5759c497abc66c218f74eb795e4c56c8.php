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
    
    <div>
        <img class="swiper_img" src="/marke/Public/Mobile/images/banner_1.png" style="width: 100%;">
    </div>
    <div>
        			<div class="group_scroll" onclick="console.log($('.group_scroll').scrollLeft());">
			<?php if(is_array($groupList)): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] == $_id): ?><div class="group_on"><?php echo ($vo["name"]); ?></div>
			    <?php else: ?>
			        <div class="group" onclick="redirect('<?php echo U('Group/'.ACTION_NAME,array('id'=>$vo['id']));?>')"><?php echo ($vo["name"]); ?></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
        <div style="width: 100%;height:2rem; background-color: #EBEBEB;">
            <div style="line-height: 2rem;padding-left: 10px;">菜单权限(<?php echo count($_list);?>)</div>
        </div>  
        <div>
        <?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item_s">
                <div class="item_info" style="width: 100%;">
                    <div class="item_menu" style="background: url('/marke<?php echo get_cover($vo['icon']);?>')  no-repeat;"><?php echo ($vo["title"]); ?></div>
                    <div class="menu_auth">
                        <?php if(is_array($vo["auth"])): $i = 0; $__LIST__ = $vo["auth"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$auth): $mod = ($i % 2 );++$i; if(in_array($auth['id'],$vo['auth_ids'])): ?><div class="auth_item status_success" data-v="1" data-name="send" ><?php echo ($auth["title"]); ?></div>
                            <?php else: ?>
                                <div class="auth_item status_over" data-v="1" data-name="send"  ><?php echo ($auth["title"]); ?></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div style="display: -webkit-box;width:21rem;margin: 1rem auto;">
            <button class="button" style="background-color: red;width:8rem;margin: 0 1rem;color: #fff;" onclick="redirect('<?php echo U('menu_add',array('id'=>$_id));?>')">菜单管理</button>
            <button class="button" style="background-color: red;width:8rem;margin: 0 1rem;color: #fff;" onclick="redirect('<?php echo U('menu_auth',array('id'=>$_id));?>')">修改权限</button>
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
        hightLine('Group/menuList');
        var left = $('.group_on').offset().left - $(window).width() / 2 + $('.group_on').width() / 2;
        $('.group_scroll').scrollLeft(left);
    </script>



	<!-- /底部 -->
</body>
</html>