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
    
    <style type="text/css">
        .item_info {
            width: 78%;
        }
        .item_more {
            width: 22%;
        }
        .status {
            height: 1.5rem;
            text-align: center;
        }
        .page {
            height: 100%;
            width: calc(25% - 1px);
            font-size: 1.5rem;
            line-height: 30px;
            text-align: center;
        }

        .page_on {
            color: #f00;
            border: #f00 solid;
            border-width: 0 0 2px 0;
        }
        .item_status{
            top:auto;
            bottom: 1.7rem;
        }
    </style>
    <?php if(is_auth(AUTH_RAISE_MANAGE)): ?><div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff; display: -webkit-box;">
            <div class="page"  onclick="redirect('<?php echo U('index');?>')">商城管理</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page" onclick="redirect('<?php echo U('bulletinList',array('type'=>1));?>')">公告列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page"  onclick="redirect('<?php echo U('bulletinList',array('type'=>0));?>')">信息列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page page_on">认购列表</div>
        </div>
    <?php else: ?>
        <div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff; display: -webkit-box;">
            <div class="page"  style="width: calc(33% - 1px);" onclick="redirect('<?php echo U('bulletinList',array('type'=>1));?>')">公告列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page"  style="width: calc(33% - 1px);" onclick="redirect('<?php echo U('bulletinList',array('type'=>0));?>')">信息列表</div>
            <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
            <div class="page page_on"  style="width: calc(33% - 1px);">认购列表</div>
        </div><?php endif; ?>
    <center style="padding: 5px 0px;border: solid #EBEBEB;border-width: 0 0 1px 0;">
        <span id="search_input" >
            <input type="text" name="kw" id="kw" style="margin: 0 0 0 10px;" placeholder="输入姓名/手机号" value="<?php echo ($kw); ?>">
        </span>
        <span>
            <li class="search_icon"></li>
            <span id="search" style="font-size: 1.3rem;">搜索</span>
            <span id="reflesh" style="font-size: 1.3rem;">| 重置</span>
        </span>
    </center>
    <div id="content">
        <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item_s" onclick="redirect('<?php echo U('Raise/info',array('id'=>$vo['id']));?>')" >
                <div class="item_info" style="width: 100%;">
                    <table  class="user_table">
                        <tr>
                            <td>客户姓名:</td>
                            <td><?php echo ($vo["cus_name"]); ?></td>
                            <td>客户手机:</td>
                            <td><?php echo ($vo["cus_phone"]); ?></td>
                        </tr>
                        <tr>
                            <td>置业顾问:</td>
                            <td><?php echo ($vo["user_name"]); ?>(<?php echo ($vo["user_phone"]); ?>)</td>
                        </tr>
                    </table>
                    <div style="position: absolute;bottom: 0.1rem;right: 1rem;"><?php echo (date('Y-m-d H:i:s',$vo["created_time"])); ?></div>
                    <?php if($vo['status'] == 1): if($vo['raise_over'] == 1): ?><div class="item_status status_over">已完成</div>
                        <?php else: ?>
                             <div class="item_status status_raise">审核未完成</div><?php endif; ?>
                    <?php else: ?>
                        <div class="item_status status_error">未审核</div><?php endif; ?>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php else: ?>
            <center>aOh! 暂时还没有内容! </center><?php endif; ?>
        <div id="navigation" align="center">
        <!-- 页面导航-->
            <a href="<?php echo U(CONTROLLER_NAME. '/'.ACTION_NAME ,array('kw'=>$kw));?>&page=2"></a>
            <!-- 此处可以是url，可以是action，要注意不是每种html都可以加，是跟当前网页有相同布局的才可以。另外一个重要的地方是page参数，这个一定要加在这里，它的作用是指出当前页面页码，每加载一次数据，page自动+1,我们可以从服务器用request拿到他然后进行后面的分页处理。-->
        </div>
    </div>
    <?php if(is_auth(AUTH_RAISE_ADD)): ?><div class="fixed_add" style="background-color: <?php echo ($bg_color); ?>; padding: 6px;" onclick="redirect('<?php echo U('Raise/add');?>')">
            <img src="/marke/Public/Mobile/images/icon/add_big.png">
        </div><?php endif; ?>

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

    <script type="text/javascript" src="/marke/Public/static/plugins/infinitescroll/jquery.infinitescroll.js" charset="UTF-8"></script>
    <script type="text/javascript">
    $('#search').click(function(){
        var kw = $('#kw').val();
        // if(kw == ''){
        //     smoke.signal('请输入正确关键词！',1500);
        //     return ;
        // }
        window.location.href = "/marke/index.php?s=/Home/Raise/lists/kw/" + kw;
    });

    $('#reflesh').click(function(){
        window.location.href = "/marke/index.php?s=/Home/Raise/lists";
    })

    var kw = '<?php echo ($kw); ?>';
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
            extraScrollPx: 20, //滚动条距离底部多少像素的时候开始加载，默认150  
            errorCallback: function() {
                $('div#msgText').html('该栏目内容已更新完毕！');
            }, //当出错的时候，比如404页面的时候执行的函数  
        }, function(arrayOfNewElems) {
            //程序执行完的回调函数  
        });
    });
    </script>



	<!-- /底部 -->
</body>
</html>