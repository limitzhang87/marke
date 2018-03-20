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
        .tab-nav {
            height: 3rem;
            border: solid #E0E0E0;
            border-width: 0 0 1px 0;
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            display: -webkit-box;
        }
        .tab-nav div {
            height: calc(100% - 1px);
            font-size: 1.2rem;
            line-height: 3rem;
            text-align: center;
            width: 5rem;
            border: solid #E0E0E0;
            border-width: 0 1px;
            margin-right: -1px;
        }
        .current {
            color: <?php echo ($bg_color); ?>;
            border: solid  <?php echo ($bg_color); ?> !important;
            border-width: 0 0 2px 0 !important;

        }
        .tab-pane {
            display: none;
            margin-left: 2em;
        }
        .in {
            display: block;
        }
        .form-item {
            margin: 15px 0;
        }
        .item-label{
            font-weight: bold;
        }
        .input-medium {
            width: 10rem;
        }
        .input-large {
            width: 18rem;
        }
        .btn_submit {
            width: 8rem;
        }
    </style>
   <div class="tab-wrap">
    <div class="tab-nav">
        <?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><div data-tab="tab<?php echo ($key); ?>" <?php if(($key) == "1"): ?>class="current"<?php endif; ?>><?php echo ($group); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <br>
    <div class="tab-content">
    <!-- 表单 -->
    <form id="form" action="<?php echo U('add');?>" method="post" class="form-horizontal">
        <!-- 基础文档模型 -->
        <?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($key); ?>" class="tab-pane <?php if(($key) == "1"): ?>in<?php endif; ?> tab<?php echo ($key); ?>">
            <?php if(is_array($fields[$key])): $i = 0; $__LIST__ = $fields[$key];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field['is_show'] == 1 || $field['is_show'] == 2): ?><div class="form-item">
                    <label class="item-label"><?php echo ($field['title']); ?> :<span class="check-tips"><?php if(!empty($field['remark'])): ?>（<?php echo ($field['remark']); ?>）<?php endif; ?></span></label>
                    <div class="controls">
                        <?php switch($field["type"]): case "num": ?><input type="text" class="input-medium" name="<?php echo ($field["name"]); ?>" value=""><?php break;?>
                            <?php case "string": ?><input type="text" class=" input-large" name="<?php echo ($field["name"]); ?>" value=""><?php break;?>
                            <?php case "textarea": ?><label class="textarea input-large">
                                <textarea name="<?php echo ($field["name"]); ?>"></textarea>
                                </label><?php break;?>
                            <?php case "datetime": ?><input type="text" name="<?php echo ($field["name"]); ?>" class=" input-large time" value="" placeholder="请选择时间" /><?php break;?>
                            <?php case "bool": ?><select name="<?php echo ($field["name"]); ?>">
                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($field["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select><?php break;?>
                            <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($field["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select><?php break;?>
                            <?php case "radio": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="radio">
                                    <input type="radio" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>"><?php echo ($vo); ?>
                                    </label><?php endforeach; endif; else: echo "" ;endif; break;?>
                            <?php case "checkbox": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="checkbox">
                                    <input type="checkbox" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>[]"><?php echo ($vo); ?>
                                    </label><?php endforeach; endif; else: echo "" ;endif; break;?>

                            <?php default: ?>
                            <input type="text" class="text input-large" name="<?php echo ($field["name"]); ?>" value=""><?php endswitch;?>
                    </div>
                </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <center>
            <button class="button btn_submit status_error" type="submit">确 定</button>
            <button class="button btn_submit status_success" type="button" onclick="javascript:history.go(-1);">返 回</button>
        </center>
    </form>
    </div>
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
    <link href="/marke/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $(function(){
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });

        });

        $('.tab-nav div').each(function(){
            $(this).click(function(){
                var tab = $(this).data('tab');
                $('.current').removeClass('current');
                $('.in').removeClass('in');
                $(this).addClass('current');
                $('#' + tab).addClass('in');
            });
        })
        /*数据拼接*/
        var temp_data = JSON.parse('<?php echo ($temp_data); ?>');
        $(function(){
            if(temp_data!=null){
                $.each(temp_data,function(i,item){
                    $('input[name="'+i+'"]').val(item);
                })
            }
        })
    </script>
    <script type="text/javascript">
        $(function(){
            /*当置业顾问点数发生变化时，计算置业顾问佣金*/
            $('input[name="sales_point"]').on('input propertychange',function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var sales_commossion = $(this).val() * base_commission;
                $('input[name="sales_commission"]').val(myToFixed(sales_commossion));
            });
            /*当分销商点数发生变化是，计算分销商佣金*/
            $('input[name="distribution_point"]').on('input propertychange',function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var distribution_commission = $(this).val() * base_commission;
                $('input[name="distribution_commission"]').val(myToFixed(distribution_commission));
            });

            /*当渠道经理点数发生变化是，计算分销商佣金*/
            $('input[name="manager_point"]').on('input propertychange',function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var manager_commission = $(this).val() * base_commission;
                $('input[name="manager_commission"]').val(myToFixed(manager_commission));
            });

            /*当案场主管点数发生变化是，计算分销商佣金*/
            $('input[name="supervisor_point"]').on('input propertychange',function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var supervisor_commission = $(this).val() * base_commission;
                $('input[name="supervisor_commission"]').val(myToFixed(supervisor_commission));
            });

            /*点击置业顾问佣金的时候根据佣金基数和点数计算*/
            $('input[name="sales_commission"]').focus(function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var sales_point = $('input[name="sales_point"]').val();
                $(this).val(myToFixed(base_commission * sales_point));
            });

            /*点击分销商佣金的时候根据佣金基数和点数计算*/
            $('input[name="distribution_commission"]').focus(function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var distribution_point = $('input[name="distribution_point"]').val();
                $(this).val(myToFixed(base_commission * distribution_point));
            });

            /*点击渠道经理佣金的时候根据佣金基数和点数计算*/
            $('input[name="manager_commission"]').focus(function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var manager_point = $('input[name="distribution_point"]').val();
                $(this).val(myToFixed(base_commission * manager_point));
            });

            /*点击案场主管佣金的时候根据佣金基数和点数计算*/
            $('input[name="supervisor_commission"]').focus(function(){
                var base_commission =  $('input[name="base_commission"]').val();
                var supervisor_point = $('input[name="supervisor_point"]').val();
                $(this).val(myToFixed(base_commission * supervisor_point));
            });
        })

        /*在没有选择意向的时候下列禁止填写*/
        $(function(){
            /*首先将所有的*/
            $('input[name="intention_money"]').parent().parent().addClass('hide');
            $('input[name="intention_time"]').parent().parent().addClass('hide');
            $('select[name="return_money"]').parent().parent().addClass('hide');
            $('input[name="intention_room_style"]').parent().parent().addClass('hide');
            $('input[name="serial_number"]').parent().parent().addClass('hide');
            $('input[name="intention_money_return_time"]').parent().parent().addClass('hide');
            $('select[name="is_intention"]').change(function(){
                var is_tentiton = $(this).val();
                if(is_tentiton == 1){
                    $('input[name="intention_money"]').parent().parent().removeClass('hide');
                    $('input[name="intention_time"]').parent().parent().removeClass('hide');
                    $('select[name="return_money"]').parent().parent().removeClass('hide');
                    $('input[name="intention_room_style"]').parent().parent().removeClass('hide');
                    $('input[name="serial_number"]').parent().parent().removeClass('hide');
                    $('input[name="intention_money_return_time"]').parent().parent().removeClass('hide');
                }else{
                    $('input[name="intention_money"]').parent().parent().addClass('hide');
                    $('input[name="intention_time"]').parent().parent().addClass('hide');
                    $('select[name="return_money"]').parent().parent().addClass('hide');
                    $('input[name="intention_room_style"]').parent().parent().addClass('hide');
                    $('input[name="serial_number"]').parent().parent().addClass('hide');
                    $('input[name="intention_money_return_time"]').parent().parent().addClass('hide');
                }
            })
        })
        function myToFixed(num) {
            return num.toFixed(2);
        }
    </script>



	<!-- /底部 -->
</body>
</html>