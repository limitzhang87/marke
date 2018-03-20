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
        .form_model{
            margin: 10px 0;
        }

        .form_model label{
            font-size: 1.5rem;
            font-weight: bold;
            padding-top: 5px;
            line-height: 2.2rem;
        }

        .form_model input{
            width: 100%;
        }
        textarea {
            width: 100%;
        }
        .img_div{
            width: 49%;
            height: 49%;
            float: left;
            position: relative;
        }
        .file_div{
            width: 80%;
            height: 2.5rem;
            margin: 0 auto;
            margin-top: 10px;
            line-height: 2.5rem;
            text-align: center;
            font-size: 1.5rem;
            background-color: #F5F5F5;
            -moz-box-shadow: 10px 10px 70px #888888;
            border-radius: 7px;
            box-shadow: 2px 2px 10px #888888;
            cursor: pointer;
        }
        .close {
            position: relative;
            color: white;
            background-color: rgba(255, 0, 0, 0.7);
            float: right;
            top: 2rem;
            height: 2rem;
            width: 2rem;
            font-size: 2rem;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            line-height: 2rem;
            text-align: center;
            z-index: 100;
        }
        .close1{
            float: right;
            font-size: 3rem;
            line-height: 2.5rem;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .2;
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            background: 0 0;
            border: 0;
        }
    </style>
    <form action="" method="POST" style="width: 86%; margin: 0 auto;">
        <div class="form_model">
            <label>请输入标题:</label>
            <div><input type="text" name="title" placeholder="请输入公告标题" value="<?php echo ($info["title"]); ?>"></div>
        </div>
        <div class="form_model">
            <label>请输入内容:</label>
            <div><textarea name="content" id="container"><?php echo ($info["content"]); ?></textarea></div>
        </div>
        <div style="height: 6.5rem;width: 100%;">
            <div class="left" style="height: 100%;width: 50%;">
                <img src="/marke/Public/Mobile/images/icon/up_camare.png"  style="width: 70px;height: 60px;margin: 0 auto;display: block;"  onclick="picSelect();">
                <div style="text-align: center;">上传图片</div>
            </div>
            <div class="right"  class="img_div" style="height: 100%;width: 50%;">
                <img src="/marke/Public/Mobile/images/icon/up_folder.png" style="width: 70px;height: 60px;margin: 0 auto;display: block;"  onclick="fileSelect();">
                <div style="text-align: center;">上传文档</div>
            </div>
        </div>
        <div id="showPic" <?php if(empty($info['picturesA'])): ?>class="hide"<?php endif; ?>  style="height: 20rem;overflow-y: auto;">
            <?php if(is_array($info['picturesA'])): $i = 0; $__LIST__ = $info['picturesA'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$picture): $mod = ($i % 2 );++$i;?><div class="img_div"  data-id="<?php echo ($picture); ?>">
                    <div class="close" onclick="delImg(<?php echo ($picture); ?>)">X</div>
                    <img class="up_pic" src="./<?php echo get_cover($picture);?>">
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div id="showFile"  <?php if(empty($info['fileA'])): ?>class="hide"<?php endif; ?>  style="height: 8rem;overflow-y: auto;"">
            <?php if(is_array($info['fileA'])): $i = 0; $__LIST__ = $info['fileA'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><div class="file_div" data-fid="<?php echo ($file); ?>">
                   <span><?php echo get_filename($file);?></span>
                    <button type="button" class="close1" onclick="delFile(<?php echo ($file); ?>)">×</button>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <center>
            <input type="hidden" name="pictures" value="<?php echo ($info["pictures"]); ?>">
            <input type="hidden" name="file" value="<?php echo ($info["file"]); ?>">
            <input type="hidden" name="old_pictures" value="<?php echo ($info["pictures"]); ?>">
            <input type="hidden" name="old_file" value="<?php echo ($info["file"]); ?>">
            <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
            <button class="button btn_submit" type="submit">提交</button>
        </center>
    </form>
    <div id="fromDiv">
        <form id="formPic" enctype="multipart/form-data" style="width:auto;">
            <input type="file" name="picToUpload[]" id="picUpload" onChange="pic2Upload();" multiple style="display:none;" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg" capture="camera">
        </form>
        <form id="formFile" enctype="multipart/form-data" style="width:auto;">
            <input type="file" name="fileToUpload" id="fileUpload" onChange="file2Upload();" accept="application/msword,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  style="display:none;">
        </form>
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

    <script type="text/javascript" src="/marke/Public/Mobile/js/bulletin.js"></script>
    <script type="text/javascript">
        hightLine('Bulletin/index');
    </script>




	<!-- /底部 -->
</body>
</html>