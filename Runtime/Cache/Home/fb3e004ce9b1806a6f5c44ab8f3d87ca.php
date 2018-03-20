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
<link rel="stylesheet" type="text/css" href="/marke/Public/Home/css/mobile.css" >
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
<script type="text/javascript" src="/marke/Public/Home/js/mobile.js"></script>
<!-- <script type="text/javascript" src="/marke/Public/Mobile/js/smoke.min.js"></script> -->
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->

</head>
<body>
	<!-- 头部 -->
	
    <div class="header_fixed"  >
        <div class="header_left">
            <li class="back" ></li>
        </div>
        <div class="title">
            <div style="display: -webkit-box;max-width: 1000px;margin: 0 auto;">
            <div class="bottom_nav" onclick="redirect('<?php echo U('Index/index');?>')">
                <div class="bottom_name">首页</div>
            </div>
            <?php if(is_array($_bottom)): $i = 0; $__LIST__ = $_bottom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="bottom_nav" onclick="redirect('<?php echo U($vo["path"]);?>')">
                <div class="bottom_name"><?php echo ($vo["title"]); ?></div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="bottom_nav"  onclick="redirect('<?php echo U('User/index');?>')">
                <div class="bottom_name">个人</div>
            </div>
        </div>
        </div>
        <div class="header_right">
            <li class="more" onclick="redirect('<?php echo ($_right_url); ?>');" style="<?php echo ($_right_type); ?>"></li>
        </div>
    </div>
    <div style="height:  40px;"></div>
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
    
    <link rel="stylesheet" href="/marke/Public/static/swiper/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Mobile/share/nativeShare.css">
	<style type="text/css">
		.border_bottom {
			border:#EBEBEB solid;
			border-width: 0 0 1px 0;
		}
        .button_l {
            padding: 0px;
            margin: 0px 5px;
            float: center;
        }
        .tip div{
            width: 100%;
            text-align: center;
            margin: 5px 0;
            font-size: 1rem;
            color: #8F8F8F;
        }
        .nativeShare {
            height: 50px;
        }
        .shadow{
            box-shadow: 0px 0px 3px 0px #ababab;
            border-radius: 3px;
        }
	</style>
    <div>
        <?php if($room['thumb'] == NULL ): ?><div class="swiper-slide"><img class="swiper_img" src="/marke/Public/Mobile/images/banner_2.png"></div>
        <?php else: ?>
            <div class="swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper" style="height: 25rem;">
                        <?php if(is_array($room['thumb'])): $i = 0; $__LIST__ = $room['thumb'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                                <img class="swiper_img"  src="/marke<?php echo get_cover($pic);?>" onclick="showPic('<?php echo ($pic); ?>', '/marke<?php echo get_cover($pic);?>')">
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div><?php endif; ?>
    </div>
    <div>
    	<div class="border_bottom" style="height: 3rem;padding: 10px 2px 10px 15px;">
            <label style="font-size: 2.5rem;" <?php if(is_auth(AUTH_ROOM_MANAGE)): ?>onclick="redirect('<?php echo U('Room/room_info_edit',array('id'=>$room['id']));?>')"  class="shadow"<?php endif; ?>>房号:<?php echo ($room["room_number"]); ?></label>
             <label style="font-size: 1.5rem;">·<?php echo ($room["b_name"]); ?>-<?php echo ($room["u_name"]); ?></label>
    	</div>
    	<div  class="border_bottom" style="height: 4.5rem;padding: 15px 0;display: -webkit-box;">

            <div style="width: 30%;border: #EBEBEB solid;border-width: 0 1px 0 0;text-align: center;" >
    			<div style="font-size: 1.5rem;line-height: 2rem;">售价</div>
    			<div style="font-size: 1.8rem;line-height: 2.5rem;color: red;"><?php echo ($room["total_price"]); ?>万</div>
    		</div>
    		<div style="width: 40%;border: #EBEBEB solid;border-width: 0 1px 0 0 ;text-align: center;"">
    			<div style="font-size: 1.5rem;line-height: 2rem;">户型</div>
    			<div style="font-size: 1.7rem;line-height: 2.5rem;color: red;"><?php echo ($room["apartment"]); ?>房<?php echo ($room["hall"]); ?>厅<?php echo ($room["kitchen"]); ?>厨<?php echo ($room["toilet"]); ?>卫</div>
    		</div>
    		<div style="width: 29.5%;text-align: center;"">
    			<div style="font-size: 1.5rem;line-height: 2rem;">建筑面积</div>
    			<div style="font-size: 2rem;line-height: 2.5rem;color: red;"><?php echo ($room["area"]); ?>m²</div>
    		</div>
    	</div>
    	<div  class="border_bottom" style="padding:0 15px;font-size: 1.5rem;line-height: 3rem;">
    		<?php echo ($room["address"]); ?>
    	</div>
    	<div style="width: 100%;display: -webkit-box;">
    		<div style="width: 44%;padding: 10px 3%;font-size: 1.5rem;">
    			<div  style="padding: 5px 0;">
    				<label style="color: #9A9A9A;">单价：</label>
    				<label><?php echo ($room["unit_price"]); ?>元/m²</label>
    			</div>
    			<div  style="padding: 5px 0;">
    				<label style="color: #9A9A9A;">朝向：</label>
    				<label><?php echo ($room["orientation"]); ?></label>
    			</div>
    		</div>
    		<div style="width: 44%;padding: 10px 3%;font-size: 1.5rem;">
    			<div style="padding: 5px 0;">
    				<label style="color: #9A9A9A;">楼层：</label>
    				<label><?php echo ($room["floor"]); ?>楼</label>
    			</div >
                <div  style="padding: 5px 0;">
                    <label style="color: #9A9A9A;">装修：</label>
                    <label>精装修</label>
                </div>
    		</div>
    	</div>
        <div class="tip">
            <?php if(is_array($tip)): $i = 0; $__LIST__ = $tip;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><div> <?php echo ($t); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <center>
            <div class="button_l status_success" style="width:10rem;margin: 5px 0;height: 3rem;line-height: 3rem;" onclick="redirect('<?php echo U('OwnerShip/index',array('id'=>$room['id']));?>')">置业计划试算</div>
            <?php if(is_array($button)): $i = 0; $__LIST__ = $button;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$btn): $mod = ($i % 2 );++$i;?><button class="button_l <?php echo ($btn["color"]); ?>" style="width: <?php echo ($width); ?>%;" onclick="changeStatus('<?php echo ($btn["method"]); ?>')"><?php echo ($btn["title"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
        </center>
    </div>

</div>
<script type="text/javascript">
    // $(function(){
    //     $(window).resize(function(){
    //         $("#main-container").css("min-height", $(window).height() - 120);
    //     }).resize();
    // });
    // (function (doc, win) {
    //     var docEl = doc.documentElement,
    //         resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
    //         recalc = function () {
    //             var clientWidth = docEl.clientWidth;
    //             if (!clientWidth) return;
    //             if(clientWidth>=640){
    //                 docEl.style.fontSize = '18px';
    //             }else{
    //                 docEl.style.fontSize = 20 * (clientWidth / 640) + 'px';
    //             }
    //         };

    //     if (!doc.addEventListener) return;
    //     win.addEventListener(resizeEvt, recalc, false);
    //     doc.addEventListener('DOMContentLoaded', recalc, false);
    // })(document, window);
	// 作者：_minooo_
	// 链接：http://www.jianshu.com/p/b00cd3506782
	// 來源：简书// 
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
	<footer class="footer_fixed">
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
    <div id="dialog_empty" class="dialog newdialog"  >
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
    <script type="text/javascript" src="/marke/Public/static/pinchzoom/src/pinchzoom.js"></script>
    <script src="/marke/Public/Mobile/share/nativeShare.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        hightLine('Room/index');
        var id = '<?php echo ($_id); ?>';
        /*首页轮播图*/
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true
        });
        function changeStatus($method) {
            var a = confirm('是否执行该操作?');
            if(!a){
                return;
            }
            if($method == '*'){
                return ;
            }
            $.ajax({
                url:ThinkPHP.APP + '/Home/Room/changeStatus',
                type:'POST',
                data:{'id': id,'method':$method},
                error:function(){
                    alert('操作失败！');
                    location.reload();
                },
                success:function(msg){
                    if(msg.status == 1){
                        location.reload();
                    }else{
                        alert(msg.info);
                        location.reload();

                    }
                }
            });
        }
         var host =  "http://<?php echo ($_SERVER['HTTP_HOST']); ?>";
        var config = JSON.parse('<?php echo ($config); ?>');
        var houses = '<?php echo ($houses); ?>';
        //var share_obj = new nativeShare('nativeShare',config);
        function showPic(id,url){
            $('#dialog_empty').show();
            var html = '<div id="showpicZoom">'+
                        '<img src="'+url+'" style="width:96%;margin: 0 auto;display: block;" onclick="hidedialog()">'+
                        '<div>';
            $('#empty_content').html(html);
            $('#dialog_empty').append('<div id="share" style="z-index: 1003;width: 100%;color:#fff;"><div id="nativeShare"></div></div>');
            new RTP.PinchZoom($('#showpicZoom'), 'maxZoom');
            config.url = config.url  + '/id/' +id;
            config.img = host + ThinkPHP.ROOT+ '/' +url;
            share_obj = new nativeShare('nativeShare',config);
        }

    </script>



	<!-- /底部 -->
</body>
</html>