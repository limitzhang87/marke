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
    
    <link rel="stylesheet" href="/marke/Public/static/farbtastic/farbtastic.css" type="text/css" />
    <div class="hide">
        <img class="swiper_img" src="/marke/Public/Mobile/images/banner_1.png" style="width: 100%;">
    </div>
    <form class="form_group" method="POST" action="">
        <div class="form_control">
            <label>会员组名:</label>
            <div class="form_control_div">
                <input type="text" name="name" value="<?php echo ($_data["name"]); ?>">
            </div>
        </div>
        <div class="form_control">
            <label style="padding-left: 2rem;">备注:</label>
            <div class="form_control_div">
                <textarea name="remark" style="margin-bottom: 0px;height: 80px;"><?php echo ($_data["remark"]); ?></textarea>
            </div>
        </div>
        <div class="form_control">
            <label>主题颜色:</label>
            <div class="form_control_div">
                <div class="form-item">
                    <input type="text" id="color" name="bg_color" value="<?php echo ($_data["bg_color"]); ?>" style="width: 90%;" />
                </div>
                <div id="picker"></div>
            </div>
        </div>
        <div style="width:100%;display: -webkit-box;">
            <input type="hidden" name="id" value="<?php echo ($_data["id"]); ?>">
            <input type="submit" style="width: 40%;margin: 0px 5%;display: block;"  name="" class="button btn_submit" value="提交">
            <div style="width: 40%;margin: 0px 5%;" class="button btn_submit status_over" onclick="delGroup();">删除 </div>
        </div>
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

    <script type="text/javascript" src="/marke/Public/static/farbtastic/farbtastic.js"></script>
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#demo').hide();
        $('#picker').farbtastic('#color');
    });
    $('#edit div').addClass('bottom_name_on');
    $('#edit li').addClass('edit_icon_on');

    function delGroup(){
        var res = confirm('是否删除该会员组，删除之后将不可恢复？');
        if(res === false){
            return ;
        }
        var id = '<?php echo ($_data["id"]); ?>';
        $.ajax({
            url:'/marke/index.php?s=/Home/Group/delGroup',
            type:'POST',
            data:{'id':id},
            beforsend:function(){
                showdialog('dialog_load');
            },
            error:function(){
                console.log(1);
            },
            complete:function(){
                hidedailog();
            },
            success:function(msg){
                if(msg.status == 1){
                    alert('删除成功！');
                    window.location.href = ThinkPHP.APP + 'Home/Group/index';
                }else{
                    alert(msg.info);
                    window.location.href = document.referrer;
                }
            }
        });
    }
    </script>



	<!-- /底部 -->
</body>
</html>