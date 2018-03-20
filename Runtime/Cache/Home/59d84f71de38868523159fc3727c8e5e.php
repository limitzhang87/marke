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
            width:30%;
            text-align: right;
            font-weight: bolder;
            font-family: Tahoma, Geneva, sans-serif;
        }
        h2{
            font-size: 1.6rem;
            height: 3rem;
            line-height: 3rem;
            border: solid red;
            border-width: 0 0 2px 0;
            padding-left: 10px;
        }
        input, textarea{
            width: 98%;
        }
        input[type="checkbox"],input[type="radio"]{
            width: auto;
        }
        textarea {
            height: 3rem;
        }
        .h_item{
            border: dashed #ABABAB;
            border-width: 0 0 1px 0;
            padding-bottom: 5px;
            margin: 10px 0;
        }
        .h_title{
            color: #8F8F8F;
            font-weight: bolder;
            font-size: 1.2em;
            font-family: Tahoma, Geneva, sans-serif;
        }
        .button{
            width: 12rem;
            margin: 0 1rem;

        }
    </style>
    <strong>
        <?php echo ($data["title"]); ?>
    </strong>
    <div class="mod-hd"><h2>基本信息</h2></div>
    <form method="POST">
    <div style="width: 96%;margin: 10px auto;">
        <form id="form" action="<?php echo U('edit');?>" method="post">
        <!-- 基础文档模型 -->
            <div id="tab<?php echo ($key); ?>" class="tab-pane <?php if(($key) == "1"): ?>in<?php endif; ?> tab<?php echo ($key); ?>">
                <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field['is_show'] == 1 || $field['is_show'] == 3): ?><div class="h_item">
                        <label class="h_title"><?php echo ($field['title']); ?><span class="check-tips"><?php if(!empty($field['remark'])): ?>（<?php echo ($field['remark']); ?>）<?php endif; ?></span></label>
                        <div class="controls">
                            <?php switch($field["type"]): case "num": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                                <?php case "string": ?><input type="text" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                                <?php case "textarea": ?><label>
                                        <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($data[$field['name']]); ?></textarea>
                                    </label><?php break;?>
                                <?php case "date": if($field['name'] == comptime or $field['name'] == starttime or $field['name'] == launchtime or $field['name'] == openingtime ): $data[$field['name']]=($data[$field['name']]=='1970-01-01' or $data[$field['name']]=='0000-00-00')?'':$data[$field['name']] ?>
                                     <input type="text" name="<?php echo ($field["name"]); ?>" class="text date" value="<?php echo ($data[$field['name']]); ?>" placeholder="请选择日期" />
                                 <?php else: ?>
                                    <input type="text" name="<?php echo ($field["name"]); ?>" class="text date" value="<?php echo (date('Y-m-d',$data[$field['name']])); ?>" placeholder="请选择日期" /><?php endif; break;?>
                                <?php case "datetime": ?><input type="text" name="<?php echo ($field["name"]); ?>"  value="<?php echo (time_format($data[$field['name']])); ?>" placeholder="请选择时间" /><?php break;?>
                                <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
                                        <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($data[$field['name']]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select><?php break;?>
                                <?php case "radio": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="radio">
                                        <input type="radio" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>" <?php if(($data[$field['name']]) == $key): ?>checked="checked"<?php endif; ?>><?php echo ($vo); ?>
                                        </label><?php endforeach; endif; else: echo "" ;endif; break;?>
                                <?php case "checkbox": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="checkbox">
                                        <input type="checkbox" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>[]" <?php if(check_document_position($data[$field['name']],$key)): ?>checked="checked"<?php endif; ?>><?php echo ($vo); ?>
                                        </label><?php endforeach; endif; else: echo "" ;endif; break;?>
                                <?php case "editor": ?><label class="textarea">
                                    <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($data[$field['name']]); ?></textarea>
                                    <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$data[$field['name']]));?>
                                    </label><?php break; endswitch;?>
                        </div>
                    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <center style="display: -webkit-box;width: 100%:">
                <input type="hidden" name="id" value="<?php echo ($id); ?>">
                <button class="button btn_submit status_success" type="button" onclick="javascript:history.go(-1);">返回</button>
                <button class="button btn_submit" type="submit">提交</button>
            </center>
        </form>
        <!-- <div>
            <div class="mod-hd"><h2>楼盘介绍</h2></div>
            <ul style='padding:0 10px;font-size: 1.3rem;'>
                <li style='color:#000;font-family:"微软雅黑"' class='fon-si'><p style='text-indent:2em'><?php echo (op_t($data["content"])); ?></p></li>
            </ul>
        </div> -->
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




	<!-- /底部 -->
</body>
</html>