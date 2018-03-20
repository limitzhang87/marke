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
    
    <link href="/marke/Public/Mobile/css/report.css" rel="stylesheet">
    <!-- <link href="/marke/Public/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="/marke/Public/static/bootstrap/js/bootstrap.min.js"></script> -->
    <style type="text/css">
        .date {
            width: 45%;
            height: 1.7rem;
        }
    </style>
    <div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff;">
        <div class="left page" id="s1" onclick="redirect('<?php echo U('Report/index',array('type'=>1));?>')">锁定</div>
        <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
        <div class="right page" id="s2" onclick="redirect('<?php echo U('Report/index',array('type'=>2));?>')">成交</div>
    </div>
    <div style="height: 3rem;margin-bottom: 5px;">
        <div id="filterbox" class="scroll_list">
            <?php if(is_array($_filter)): $i = 0; $__LIST__ = $_filter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="filter" id="<?php echo ($vo["type"]); ?>"  data-type="<?php echo ($vo["type"]); ?>">
                <div class="dropdown-backdrop"></div>
                <div class="button"  data-value="<?php echo ($vo['data'][0]['value']); ?>"><?php echo ($vo['data'][0]['title']); ?></div>
                <ul class="dropdown-menu <?php echo ($vo["type"]); ?>">
                    <?php if(is_array($vo['data'])): $i = 0; $__LIST__ = $vo['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li role="presentation">
                        <a tabindex="-1" href="#" data-value='<?php echo ($val["value"]); ?>'><?php echo ($val["title"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div style="display: -webkit-box;padding: 0 10px;">
        <div style="width: 70%;"><input type="text" name="date1" class="date"> - <input type="text" name="date2" class="date"></div>
        <div class="button" style="height: 1.8rem; width: 25%;margin: 0px;line-height: 1.8rem;" onclick="dateSearch();">日期查询</div>
    </div>
    <center style="font-size: 1.3rem;color: #AAAAAA;margin:5px 10px;border: solid #ABABAB;border-width: 1px;border-radius: 5px;">
        <span>总房源数：<?php echo ($data["room_total"]); ?>;</span>
        <span>待售房源数：<?php echo ($data["nosole_total"]); ?>;</span>
        <span>销控房源数：<?php echo ($data["market_total"]); ?></span>
        <div id="total" style="color: red;" ></div>
    </center>
    <div id="content">
    </div>

    <div class="fixed_add" style="background-color: <?php echo ($bg_color); ?>; padding: 6px;" onclick="downloadExcel('统计报表')">
        <img src="/marke/Public/Mobile/images/icon/icon_download.png">
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

    <link href="/marke/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
     <!-- <link href="/marke/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">-->
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/marke/Public/Mobile/js/report.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $('#s<?php echo ($type); ?>').addClass('page_on');
        type = '<?php echo ($type); ?>';
        uid = '<?php echo ((isset($uid) && ($uid !== ""))?($uid):"*"); ?>';

        $(function() {
            $('.date').datetimepicker({
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                minView: 2,
                autoclose: true
            });
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language: "zh-CN",
                minView: 2,
                autoclose: true
            });
        });
    </script>



	<!-- /底部 -->
</body>
</html>