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
    <?php if($info['status'] == 0 ): ?><div class="button btn_submit status_success" onclick="check('<?php echo ($info["id"]); ?>')">审核通过</div>
    <?php else: ?>
        <div class="button btn_submit status_over">已通过</div><?php endif; ?>
    </center>
    <?php if($info['room'] != null): ?><div>
        <h3 style="text-align: center;">已购房号</h3>
        <div class="info" onclick="toRoom('<?php echo ($info["room"]["id"]); ?>')">
            <div class="l_info">
                <div class="info_title">地址：</div>
                <div><?php echo getHouses('title'); echo ($info["room"]["b_name"]); ?>-<?php echo ($info["room"]["u_name"]); ?>-<?php echo ($info["room"]["room_number"]); ?>号</div>
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
        <div class="tip"><div>该客户尚未购房！</div></div><?php endif; ?>
    <div style="margin-top: 10px;">
        <center><strong>二维码</strong></center>
        <div style="width: 90%;margin: 0 auto;">
            <!-- <img src="http://qr.liantu.com/api.php?&w=200&text=http://baidu.com"> -->
            <img src="http://qr.liantu.com/api.php?&w=200&text=http://<?php echo ($_SERVER['HTTP_HOST']); echo ($url); ?>" onclick="show_pic('1','http://qr.liantu.com/api.php?&w=200&text=http://<?php echo ($_SERVER['HTTP_HOST']); echo ($url); ?>')">
        </div>
        <center class="tip">(将二维码保存下载分享)</center>
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

    <script type="text/javascript" src="/marke/Public/static/pinchzoom/src/pinchzoom.js"></script>
    <script type="text/javascript">
    /**
     * 放大图片
     * @type {String}
     */
    var host =  "http://<?php echo ($_SERVER['HTTP_HOST']); ?>";
    //var config = JSON.parse('<?php echo ($config); ?>');
    function show_pic(id,url) {
        $('#dialog_empty').show();
        var html = '<div id="showpicZoom" ><img src="'+url+'" style="width:90%;height:100%; margin: 0 auto;display: block;" onclick="hidedialog()"><div>';
        $('#empty_content').html(html);
        new RTP.PinchZoom($('#showpicZoom'), 'maxZoom');
        $('#dialog_empty').show();
            var html = '<div id="showpicZoom">'+
                        '<img src="'+url+'" style="width:96%;margin: 0 auto;display: block;" onclick="hidedialog()">'+
                        '<div>';
            $('#empty_content').html(html);
            //$('#dialog_empty').append('<div id="share" style="z-index: 1003;width: 100%;color:#fff;"><div id="nativeShare"></div></div>');
            new RTP.PinchZoom($('#showpicZoom'), 'maxZoom');
            // config.url =  host + ThinkPHP.APP + '/Home/share/houses_img/id/' +id;
            // config.img = host + ThinkPHP.ROOT+ '/' +url;
            // share_obj = new nativeShare('nativeShare',config);
    }

    function check(id) {
        if(!confirm('是否通过审核？')){
            return ;
        }
        $.ajax({
            url:'/marke/index.php?s=/Home/Raise/check',
            type:'POST',
            data:{'id':id},
            beforeSend:function(){
                $('#dialog_load').hide();
            },
            error:function(){
                alert('修改失败！');
                history.go(0);
            },
            success:function(msg){
                $('#dialog_load').hide();
                if(msg.status == 1){
                    alert('审核成功！');
                    history.go(0);
                }else{
                    alert('审核失败！');
                    history.go(0);
                }
            }
        })
    }
    </script>



	<!-- /底部 -->
</body>
</html>