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
    
    <style type="text/css">
    body {
        background-color: #EBEBEB;
    }
    
    </style>
    <div style="height: 30px;width: 100%;border: #ccc solid;border-width: 0 0 2px 0;background-color: #fff;">
        <div class="left" style="height:100%;width: 50%; font-size: 1.5rem;line-height: 30px;text-align: center;" onclick="redirect('<?php echo U('Room/house_info_set');?>')">楼栋管理</div>
        <span style="padding-left: 1px;background-color: #EBEBEB;padding-bottom: 17px;" ></span>
        <div class="right" style="height:100%;width: 49%;font-size: 1.5rem;line-height: 30px;text-align: center;color: #f00;border: #f00 solid;border-width: 0 0 2px 0;" >单元管理</div>
    </div>
    <div class="building">
        <?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$building): $mod = ($i % 2 );++$i;?><div class="building_info">
            <div style="display: -webkit-box;">
                <div class="building_title"><?php echo ($building["b_name"]); ?></div>
                <div class="status_success sell_status" ><?php echo ($building["typeNmae"]); ?></div>
                <?php if($building['status'] == '1' ): ?><div class="status_success sell_status" onclick="changeStauts('b','<?php echo ($building["id"]); ?>','<?php echo ($building["status"]); ?>')">在售</div>
                <?php else: ?>
                <div class="status_error sell_status" onclick="changeStauts('b','<?php echo ($building["id"]); ?>','<?php echo ($building["status"]); ?>')">待售</div><?php endif; ?>
            </div>
            <div class="unit_info">
            <?php if(is_array($building['is_w'])): $i = 0; $__LIST__ = $building['is_w'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$is_w): $mod = ($i % 2 );++$i;?><div class="unit_list">
                    <?php if($is_w == 0 ): ?><div class="unit_name left">
                            <?php echo ($key+1); ?>单元
                        </div>

                        <?php if($building['type'] == 1): ?><div class="unit_edit right" onclick="redirect('/marke/index.php?s=/Home/Room/unit_set2/b_id/<?php echo ($building["id"]); ?>/b_name/<?php echo ($building["b_name"]); ?>/u_order/<?php echo ($key); ?>/type/<?php echo ($building["type"]); ?>')" >
                                <li class="edit_s_icon"></li>
                            </div>
                        <?php else: ?>
                            <div class="unit_edit right" onclick="redirect('/marke/index.php?s=/Home/Room/unit_set/b_id/<?php echo ($building["id"]); ?>/b_name/<?php echo ($building["b_name"]); ?>/u_order/<?php echo ($key); ?>/type/<?php echo ($building["type"]); ?>')" >
                                <li class="edit_s_icon"></li>
                            </div><?php endif; ?>
                        <div class="status_over sellU_status right" style="height: 2rem;">未编辑</div>
                    <?php else: ?>
                        <div class="unit_name left">
                            <?php echo ($building['unit'][$is_w]['u_name']); ?>
                        </div>

                        <?php if($building['type'] == 1): ?><div class="unit_edit right" onclick="redirect('/marke/index.php?s=/Home/Room/unit_set2/b_id/<?php echo ($building["id"]); ?>/b_name/<?php echo ($building["b_name"]); ?>/u_order/<?php echo ($key); ?>/type/<?php echo ($building["type"]); ?>')" >
                                <li class="edit_s_icon"></li>
                            </div>
                        <?php else: ?>
                            <div class="unit_edit right" onclick="redirect('/marke/index.php?s=/Home/Room/unit_edit/b_id/<?php echo ($building["id"]); ?>/b_name/<?php echo ($building["b_name"]); ?>/u_order/<?php echo ($key); ?>/type/<?php echo ($building["type"]); ?>')" >
                                <li class="edit_s_icon"></li>
                            </div><?php endif; ?>
                        <div class="status_success sellU_status right">已编辑</div><?php endif; ?>
                    <?php if($building['unit'][$is_w]['status'] == '1' ): ?><div class="status_success sellU_status right" onclick="changeStauts('u', '<?php echo ($building['unit'][$is_w]['id']); ?>' ,'<?php echo ($building['unit'][$is_w]['status']); ?>','<?php echo ($building["id"]); ?>')">在售</div>
                    <?php elseif($building['unit'][$is_w]['status'] == '-1'): ?>
                        <div class="status_error sellU_status right" onclick="changeStauts('u','<?php echo ($building['unit'][$is_w]['id']); ?>','<?php echo ($building['unit'][$is_w]['status']); ?>','<?php echo ($building["id"]); ?>')">待售</div><?php endif; ?>
                    <!-- <div class="status_success sellU_status right">在售</div> -->
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
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

    <script type="text/javascript" charset="utf-8">
        /**
         * [changeStauts description]
         * @param  {string} $type   修改状态的类型，b代表的是修改栋号，u代表修改单元
         * @param  {int} $id     栋ID或者单元ID
         * @param  {状态} $status 当前状态
         * @return {[type]}         [description]
         */
        function changeStauts($type,$id,$status,$b_id){
            $b_id = $b_id != undefined ? $b_id : 0;
            $status = $status * -1;
            var a = confirm('确认修改当前的可售状态？');
            if(!a){
                return;
            }
            $.ajax({
                url:'/marke/index.php?s=/Home/Room/changeBUStatus',
                data:{'type':$type,'id':$id,'status':$status,'b_id':$b_id},
                type:'POST',
                error:function(){
                    console.log(错误);
                },
                success:function(msg){
                    history.go(0);
                }
            })
        }
        hightLine('Room/index');
    </script>



	<!-- /底部 -->
</body>
</html>