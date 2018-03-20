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
        .info{
            width: 100%;
            border:solid #EAEAEA 1px;
            box-shadow: 3px;
            font-size: 1.2rem;
        }
        .info section:first-child{
            margin: 10px;
        }
        .info ul{
            list-style: none;
            margin: 0px;
            padding: 0px;
        }
        .info ul li{
            display: -webkit-box;
            padding: 0.1em 0.2em;
            min-height: 1.2em;
            line-height: 1.2em;
        }
        .tit{
            border-top: 1px dashed #d9d9d9;
            font-size: 0.9em;
            line-height: 1.8em;
            color: #f19411;
            text-align: center;
        }
        .tit>strong{
            font-weight: normal;
            display: block;
            margin: 0 auto;
            line-height: 1.6em !important;
        }
        section{
            margin: 10px 0;
        }
        button {
            border:none;
            font-size: 1.2rem;
            height: 2em;
            width: 8rem;
            margin-left: 1rem;
        }
        strong {
            box-flex: 1;
            -webkit-box-flex: 1;
            font-size: 0.9375em;
            color: #ea6413;
        }
        .line{
            height: 1px;
            border-top: solid #EBEBEB 1px; 
        }
        .track_list{
            width: 96%;
            margin: 10px 2%;
            display: -webkit-box;
        }
        .track_list>div:first-child{
            width: 7rem;
            background: url(/marke/Public/Mobile/images/icon/tuwen8.png) no-repeat 5.25em 5px;
        }
        .track_list>div:last-child{
            display: -webkit-box;
            width: calc(100% - 7rem);
        }
        .sanjiao{
            width: 17px;
            height: 18px;
            background: url(/marke/Public/Mobile/images/icon/bg_sanjiao.png) no-repeat 6px;
            margin-top: 8px;
        }
        .track_list>div:last-child>div:last-child{
           background-color: #ddd;
           min-height: 4rem;
           width: calc(100% - 17px);
        }
        .content{
            color: #e38307;
            font-size: 0.8em;
        }
        #intention img{
            width: auto;
        }
    </style>
    <div style="width: 96%;margin: 10px 2%;">
        <div class="info">
            <section>
                <ul>
                    <li>客户姓名：<?php echo ($_info["name"]); ?></li>
                    <li>客户电话：<?php echo ($_info["phone"]); ?></li>
                    <li>登记时间：<?php echo (date("Y-m-d H:i:s",$_info["first_time"])); ?></li>
                    <li>登记时间：<?php echo (date("Y-m-d H:i:s",$_info["first_time"])); ?></li>
                    <li>是否本省：<?php echo (getyn($_info["in_province"])); ?></li>
                    <li>意向判断：<span id="intention"  data-score="<?php echo ($_info["intention"]); ?>"></span></li>
                    <li>客户来源：<?php echo ($_info["cus_from"]); ?></span></li>
                </ul>
                <ul style="text-align: center;color: #e38307" id="show" onclick="showmore()">显示更多信息</ul>
                <ul id="more_info" class="hide">
                    <li>要求位置：<?php echo ($_info["position"]); ?></li>
                    <li>面    积：<?php echo ($_info["area"]); ?></li>
                    <li>主要抗性：<?php echo ($_info["installation"]); ?></li>
                    <li>心理价位：<?php echo ($_info["like_price"]); ?></li>
                    <li>职    业：<?php echo ($_info["job"]); ?></li>
                    <li>置业次数：<?php echo ($_info["come_num"]); ?></li>
                    <li>要    求：<?php echo ($_info["require"]); ?></li>
                    <li>用    途：<?php echo ($_info["use"]); ?></li>
                    <li>是否成交：<?php echo (getyn($_info["is_deal"])); ?></li>
                    <li>是否退房：<?php echo (getyn($_info["check_out"])); ?></li>
                    <li>是否完成：<?php echo (getyn($_info["over"])); ?></li>
                    <li>置业顾问：<?php echo ($_info["sales_name"]); ?></li>
                    <li>备    注：<?php echo ($_info["remark"]); ?></li>
                </ul>
                <ul style="text-align: center;color: #e38307" class="hide" id="hide" onclick="hidemore()">收起</ul>
            </section>
            <li class="line"></li>
            <section>
                <?php if($_info['over'] != 1 && $_info['check_out'] != 1): ?><button class="status_success" onclick="add_log('来电来访')">来电来访</button>
                <button class="status_success" onclick="add_log('电话回访')">电话回访</button>
                <button class="status_success" onclick="add_log('客户来访')">客户来访</button>
                <input type="text" style="width: 96%;display: block;margin: 10px 2%;" name="remark" id="remark"><?php endif; ?>
            </section>
            <li class="line"></li>
            <section id="tarck_log">
                <?php if(is_array($_info['log'])): $i = 0; $__LIST__ = $_info['log'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><div class="track_list">
                    <div><?php echo (date("Y-m-d H:i:s", $log["time"])); ?></div>
                    <div>
                        <div class="sanjiao"></div>
                        <div>
                            <strong>【<?php echo ($log["type"]); ?>】</strong>
                            <div class="content"><?php echo ($log["remark"]); ?></div>
                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="track_list">
                    <div><?php echo (date("Y-m-d H:i:s", $_info["first_time"])); ?></div>
                    <div>
                        <div class="sanjiao"></div>
                        <div>
                            <strong>【初次登记】</strong>
                            <div class="content"><?php echo ($_info["remark"]); ?></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <center style="margin-top: 10px;" >
            <?php if(is_array($button)): $i = 0; $__LIST__ = $button;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$btn): $mod = ($i % 2 );++$i;?><button class="<?php echo ($btn["color"]); ?>" onclick="changeStatus('<?php echo ($btn["method"]); ?>')"><?php echo ($btn["title"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
        </center>
    </div>
    <?php if(is_auth(AUTH_TRACK_ADD) || is_auth(AUTH_TRACK_MANAGE)): ?><div class="fixed_add" style="background-color: <?php echo ($bg_color); ?>; padding: 6px;"  onclick="redirect('<?php echo U('edit',array('id'=>$_info['id']));?>')">
            <img src="/marke/Public/Mobile/images/icon/edit.png">
        </div><?php endif; ?>
    <?php if(is_auth(AUTH_TRACK_ADD) || is_auth(AUTH_TRACK_MANAGE)): if($_info["status"] == 1): ?><center style="margin-top: 10px;" >
                <button class="status_error" style="width: auto;" onclick="status('<?php echo ($_info["id"]); ?>','recycle')">删除该条记录</button>
            </center>
        <?php else: ?>

            <center style="margin-top: 10px;" >
                <button class="status_success" style="width: auto;" onclick="status('<?php echo ($_info["id"]); ?>','unrecycle')">还原数据</button>
                <button class="status_error" style="width: auto;" onclick="status('<?php echo ($_info["id"]); ?>','del')">彻底清空</button>
            </center><?php endif; endif; ?>

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

    <script type="text/javascript" src="/marke/Public/static/raty-2.5.2/lib/jquery.raty.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#intention').raty({
                score: function() {
                    return $(this).attr('data-score');
                },
                readOnly:true,
            });
        })

        var id = '<?php echo ($_info["id"]); ?>';
        var uid = '<?php echo ($uid); ?>';
        console.log(uid);
        /*添加跟踪记录*/
        function add_log(type) {
            if(!confirm('是否提交？')){
                return ;
            }
            var remark = $('#remark').val();
            $.ajax({
                url:'/marke/index.php?s=/Home/Track/add_log',
                type:'post',
                data:{'id': id,'remark':remark,'type':type},
                beforeSend:function(){

                },
                error:function(){
                    alert('提交失败');
                },
                success:function(msg){
                    if(msg.status == 1){
                        trackHtml(msg.info);
                    }else{
                        alert('提交失败');
                    }
                }
            })
        }

        /* 跟踪信息渲染 */
        function trackHtml(info) {
            if(!info){
                return ;
            }
            html = '<div class="track_list">'+
                        '<div>'+info.time+'</div>'+
                        '<div>'+
                            '<div class="sanjiao"></div>'+
                            '<div>'+
                                '<strong>【'+info.type+'】</strong>'+
                                '<div class="content">'+info.remark+'</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
            $('#tarck_log').prepend(html);
        }

        function showmore() {
            $('#more_info').removeClass('hide');
            $('#show').addClass('hide');
            $('#hide').removeClass('hide');
        }
        function hidemore() {
            $('#more_info').addClass('hide');
            $('#hide').addClass('hide');
            $('#show').removeClass('hide');
        }


        /*修改状态*/
        function changeStatus(method) {
            if(method == '*' || method == ''){
                return;
            }
            if(!confirm('是否提交？')){
                return ;
            }
            $.ajax({
                url:ThinkPHP.APP + '/Home/Track/changeStatus',
                type:'POST',
                data:{'id':id,'method':method},
                beforeSend:function(){

                },
                error:function(){
                    alert('提交失败！');
                },
                success:function(msg){
                    if(msg.status == 1){

                    }else{
                        alert('提交成功');
                    }
                    history.go(0);
                }
            })
        }


        function status(id,option) {
            var title = '';
            switch(option){
                case 'del':
                    title = '是否彻底删除？';
                    break;
                case 'recycle':
                    title = '是否删除？';
                    break;
                case 'unrecycle':
                    title = '是否还原？';
                    break;
            }
            if(!confirm(title)){
                return;
            }
            $.ajax({
                url:ThinkPHP.APP + '/Home/Track/status',
                type:'POST',
                data:{'id':id,'option':option},
                beforeSend:function(){
                    $('#dialog_load').addClass('show');
                },
                complete:function(){
                    $('#dialog_load').removeClass('show');
                },
                error:function(){
                    alert('删除失败！');
                },
                success:function(msg){
                    if(msg.status == 1){
                        if(option == 'del'){
                            history.go(-1);
                        }else{
                            history.go(0);
                        }
                    }else{
                        alert('提交成功');
                    }
                }
            })
        }

    </script>



	<!-- /底部 -->
</body>
</html>