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
    
<link rel="stylesheet" type="text/css" href="/marke/Public/Mobile/share/nativeShare.css">
	<style type="text/css">
		#pic_title {
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

		button.close {
		    -webkit-appearance: none;
		    padding: 0;
		    cursor: pointer;
		    background: 0 0;
		    border: 0;
		}

		.close{
		    float: right;
		    font-size: 3rem;
		    line-height: 2.5rem;
		    color: #000;
		    text-shadow: 0 1px 0 #fff;
		    opacity: .2;
		}
        <?php if($ownership_man['bg_img'] != '' ): ?>.container {
            background: url('./<?php echo get_cover($ownership_man['bg_img']);?>')  repeat !important;
            background-size:100% 100%;
        }<?php endif; ?>
	</style>
	<div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff;">
        <div class="left" style="height:100%;width: 50%; font-size: 1.5rem;line-height: 30px;text-align: center;" onclick="redirect('<?php echo U('OwnerShip/index',array('id'=>$id));?>')">	置业计划
        </div>
        <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
        <div class="right" style="height:100%;width: 49%;font-size: 1.5rem;line-height: 30px;text-align: center;color: #f00;border: #f00 solid;border-width: 0 0 2px 0;" >
        	置业列表
    	</div>
    </div>
    <div style="text-align: center;">
    	<h3>置业计划图片列表</h3>
    </div>
    <?php if($_list == '' ): ?><center>没有更多数据了！</center><?php endif; ?>
    <div id="content">
        <?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div id="pic_title" name="pic_title_<?php echo ($vo["id"]); ?>">
            	<span data-toggle="modal" data-target="#show_pic" onclick="show_pic_fun('<?php echo ($vo["id"]); ?>','<?php echo ($vo["path"]); ?>')" data-url="<?php echo ($vo["path"]); ?>">
            	<?php echo ($vo["created_time"]); ?></span>
            	<button type="button" class="close" onclick="del_own_pic('<?php echo ($vo["id"]); ?>_<?php echo ($vo["path"]); ?>')" >×</button>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <div id="navigation" align="center">
        <!-- 页面导航-->
            <a href="<?php echo U('OwnerShip/lists');?>&page=2"></a>
            <!-- 此处可以是url，可以是action，要注意不是每种html都可以加，是跟当前网页有相同布局的才可以。另外一个重要的地方是page参数，这个一定要加在这里，它的作用是指出当前页面页码，每加载一次数据，page自动+1,我们可以从服务器用request拿到他然后进行后面的分页处理。-->
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

	<script type="text/javascript" src="/marke/Public/static/plugins/infinitescroll/jquery.infinitescroll.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/marke/Public/static/pinchzoom/src/pinchzoom.js"></script>
    <script  type="text/javascript" src="/marke/Public/Mobile/share/nativeShare.js" charset="utf-8"></script>
    <script type="text/javascript">
        var totalpage = '<?php echo ($totalpage); ?>';
        $(document).ready(function() { //别忘了加这句，除非你没学Jquery

            $("#content").infinitescroll({
                loading: {
                    finished: undefined,
                    finishedMsg: "<em>很抱歉，内容已经浏览完了！</em>",
                    msgText: "<div id='msgText'  style='text-align: center;' ><img style='width:2rem;' src='/marke/Public/static/plugins/infinitescroll/images/loading.gif' /><?php if($totalpage == 1): ?>已没有更多数据<?php else: ?>请稍等.正在加载中...<?php endif; ?></div>",
                    selector: null,
                    speed: 'fast',
                    start: undefined
                },
                maxPage: totalpage,
                bufferPx: 1,
                navSelector: "#navigation", //导航的选择器，会被隐藏 
                nextSelector: "#navigation a", //包含下一页链接的选择器  
                itemSelector: "#content ", //你将要取回的选项(内容块)  
                animate: true, //当有新数据加载进来的时候，页面是否有动画效果，默认没有 
                extraScrollPx: 10, //滚动条距离底部多少像素的时候开始加载，默认150  
                errorCallback: function() {
                    $('div#msgText').html('该栏目内容已更新完毕！');
                }, //当出错的时候，比如404页面的时候执行的函数  
            }, function(arrayOfNewElems) {
                //程序执行完的回调函数  
            });
        });
    </script>
	<script type="text/javascript">
    /**
     * 删除置业计划图片
     */
    function del_own_pic($path) {
        $.ajax({
            type: "POST",
            url: ThinkPHP.APP + '/Home/OwnerShip/del_own_pic',
            data: {
                'path': $path,
            },
            error: function(request) {
                alert("Connection error");
            },
            success: function(msg) {
                $('div[name="pic_title_' + msg['info'][0] + '"]').remove();
            }
        });
    }

    /**
     * 下载图片
     * @type {String}
     */
    var host =  "http://<?php echo ($_SERVER['HTTP_HOST']); ?>";
    var config = JSON.parse('<?php echo ($config); ?>');
    function show_pic_fun(id,url) {
        $('#dialog_empty').show();
        var html = '<div id="showpicZoom" ><img src="'+url+'" style="width:90%;height:100%; margin: 0 auto;display: block;" onclick="hidedialog()"><div>';
        $('#empty_content').html(html);
        new RTP.PinchZoom($('#showpicZoom'), 'maxZoom');
        $('#dialog_empty').show();
            var html = '<div id="showpicZoom">'+
                        '<img src="'+url+'" style="width:96%;margin: 0 auto;display: block;" onclick="hidedialog()">'+
                        '<div>';
            $('#empty_content').html(html);
            $('#dialog_empty').append('<div id="share" style="z-index: 1003;width: 100%;color:#fff;"><div id="nativeShare"></div></div>');
            new RTP.PinchZoom($('#showpicZoom'), 'maxZoom');
            config.url =  host + ThinkPHP.APP + '/Home/share/houses_thumb/id/' +id;
            config.img = host + ThinkPHP.ROOT+ '/' +url;
            share_obj = new nativeShare('nativeShare',config);
    }
	</script>



	<!-- /底部 -->
</body>
</html>