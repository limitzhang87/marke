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
        .div_img{
            width:90%;margin:5px auto;
        }
        .div_img>img{
            margin-top: -2rem;
        }
        .div_img>.close_red {
            top: 0;
        }
    </style>
    <form action="" method="POST">
        <div class="unit_set">
            <div class="unit_set_item">
                <div class="unit_set_title">单元名称（序号）:</div>
                <div class="unit_set_value">
                    <input class="input_m" class="input" id="u_name" name="u_name" value="<?php echo ($_unit["u_name"]); ?>">
                </div>
            </div>
            <div class="unit_set_item">
                <div class="unit_set_title">每层房间套数:</div>
                <div class="unit_set_value">
                    <input class="input_s" type="number" name="room_num" value="<?php echo ($_unit["room_num"]); ?>" disabled="disabled">
                </div>
            </div>
            <div class="unit_set_item">
                <div class="unit_set_title">楼层区间:</div>
                <div class="unit_set_value">
                    <input class="input_s" type="number" name="floor_start" value="<?php echo ($_unit["floor_start"]); ?>" disabled="disabled"><span style="margin: 0 10px;">-</span>
                    <input class="input_s" type="number" name="floor_over" value="<?php echo ($_unit["floor_over"]); ?>" disabled="disabled">
                </div>
            </div>
        </div>
        <div class="button_l btn_submit status_success" onclick="editUname();" >修改单元名称</div>
        <div class="sameroom_set">
            <div class="room_scroll">
                <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="group" id="room_<?php echo ($key+1); ?>"><?php echo ($vo['r_name']); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="room_page">
                <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><div class="room_set" id="page_<?php echo ($key+1); ?>">
                    <input type="hidden" name="sameroom[<?php echo ($key); ?>][id]" value="<?php echo ($vos["id"]); ?>">
                    <div class="unit_set_item">
                        <div class="unit_set_title">房间序号（名称）</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][r_name]" value="<?php echo ($vos["r_name"]); ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">最低建筑单价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][unit_price]" value="<?php echo ($vos["unit_price"]); ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">建筑价格差价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][bt_price]" value="<?php echo ($vos["bt_price"]); ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">建筑面积</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][area]" value="<?php echo ($vos["area"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">总价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][total_price]" value="<?php echo ($vos["total_price"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">房</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][apartment]" value="<?php echo ($vos["apartment"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">厅</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][hall]" value="<?php echo ($vos["hall"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">厨</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][kitchen]" value="<?php echo ($vos["kitchen"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">卫</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][toilet]" value="<?php echo ($vos["toilet"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">朝向</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[<?php echo ($key); ?>][orientation]" value="<?php echo ($vos["orientation"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item" style="height:auto;">
                        <div class="unit_set_title">户型图:</div>
                        <div class="unit_set_value">
                            <div class="button" onclick="fileSelect('<?php echo ($key+1); ?>')" style="width:auto;margin:5px;padding:0 5px;">选择图片</div>
                            <input class="input_m" id="thumb<?php echo ($key+1); ?>" type="hidden" name="sameroom[<?php echo ($key); ?>][thumb]" value="<?php echo ($vos["thumb"]); ?>">
                        </div>
                    </div>
                    <div id="showPic<?php echo ($key+1); ?>"  <?php if($vos['thumb'] == '' ): ?>class="hide"<?php endif; ?> style="width:90%;margin:0 auto;">
                        <?php if($vos['thumb'] != '' ): $vos['thumb'] = explode(',',$vos['thumb']);$kk = $key+1; ?>
                            <?php if(is_array($vos['thumb'] )): $i = 0; $__LIST__ = $vos['thumb'] ;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$thumb): $mod = ($i % 2 );++$i;?><div class="div_img" data-id="<?php echo ($thumb); ?>">
                                <div class="close_red right" onclick="delImg('<?php echo ($kk); ?>','<?php echo ($thumb); ?>')">X</div>
                                <img src="/marke<?php echo get_cover($thumb);?>" style="width:100%;">
                            </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <center id="button" >
            <button class="button_l btn_submit" type="submit">确定修改</button>
            <div class="button_l btn_submit status_over" onclick="cleanUnit()">清除重写</div>
        </center>
    </form>
    <div id="fromPicdiv">
        <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><form id="form<?php echo ($key+1); ?>" enctype="multipart/form-data">
                <input class="input_m hide" id="fileToUpload<?php echo ($key+1); ?>" name="fileToUpload[]" type="file" multiple="" accept="image/png,image/jpg,image/gif,image/jpeg,image/svg" onchange="fileUpload('<?php echo ($key+1); ?>')">
            </form><?php endforeach; endif; else: echo "" ;endif; ?>
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

    <script type="text/javascript" charset="utf-8">
    $('#room_1').addClass('group_on');
    $('#page_1').addClass('show');
    $('.sameroom_set').removeClass('hide');
    $('#button').removeClass('hide');

    /**
     * 点击套房，显示对应页面
     */
    $('.group').click(function() {
        $('.show').removeClass('show');
        $('.group_on').removeClass('group_on');
        var roomID = $(this).attr('id');
        var array = roomID.split('_');
        $('#room_' + array[1]).addClass('group_on');
        $('#page_' + array[1]).addClass('show');
    });

    function editUname() {
        var u_name = $('#u_name').val();
        var u_id = '<?php echo ($_unit["id"]); ?>';
        $.ajax({
            url:'/marke/index.php?s=/Home/Room/editUname',
            data:{'u_id':u_id,'u_name':u_name},
            type:'POST',
            error:function(){
                alert('修改失败！');
            },
            success:function(msg){
                if(msg.status == 1){
                    alert('修改成功！');
                }else{
                    alert('修改失败！');
                }
            },
            complete:function(){
                location.reload();
            }
        })
    }

    function cleanUnit() {
        var a = confirm('确定清楚该单元数据？1');
        if(!a){
            return ;
        }
        var b_id    = "<?php echo ($_building["b_id"]); ?>";
        var u_order = "<?php echo ($_building["u_order"]); ?>";
        var b_name  = "<?php echo ($_building["b_name"]); ?>";
        var u_id    = "<?php echo ($_unit["id"]); ?>";
        $.ajax({
            url:'/marke/index.php?s=/Home/Room/cleanUnit',
            type:'POST',
            data:{'b_id':b_id,'u_order':u_order,'b_name':b_name,'u_id':u_id},
            beforeSend:function(){
                $('#dialog_load').show();
            },
            error:function(){
                $('#dialog_load').hide();
                alert('清除失败，请重新提交！');
            },
            success:function(msg){
                $('#dialog_load').hide();
                alert('清除成功');
                //history.go(-1);
            },
            complete:function(){
                $('#dialog_load').hide();
            }
        })

    }

        /**
     * 触发文件选择框架
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    function fileSelect(id) {
        $('#fileToUpload'+id).click();
    }

    /**
     * 当文件选择框选择文件时自动上传。
     * @param  {int} id 房号的暂时ID
     */
    function fileUpload(id) {
        var formData = new FormData($('#form'+id)[0]); //获取表单
        //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
        //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
        $.ajax({
            url: ThinkPHP.APP + '/Home/UploadPic/uploadPicture',
            type: 'POST',
            data: formData, // Form数据
            cache: false,
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
            processData: false, // 告诉jQuery不要去处理发送的数据
            beforeSend: function() {},
            success: function(msg) {
                if (msg.status == 1) {
                    imgHtml(msg.info,id);
                }else{
                     alert('上传失败');
                }
            },
            error: function() {
                alert('上传失败');
            },
        });
    }

    function imgHtml(info,id){
        $(info).each(function(i,item){
            var html ='<div class="div_img" name="pic" data-id="'+item.id+'"><div class="close_red right" onclick="delImg('+id+',' + item.id + ')">X</div>' +
                '<img src="/marke' + item.path + '" style="width:100%;"></div>' ;
            $('#showPic'+id).append(html);
            $('#showPic'+id).removeClass('hide');
        });
        var idA = new Array();
        $('#showPic'+id+'>div').each(function(i,item){
            idA[i] = $(item).data('id');
        });
        var ids = idA.join(',');
        $('#thumb'+id).val(ids);
    }
    /**
     * 删除图片
     * @param  {[type]} pic_path [description]
     * @return {[type]}          [description]
     */
    function delImg(id,pid) {
        if(!confirm('是否删除图片！')){
            return ;
        }
        $.ajax({
            type: 'POST',
            data: 'id=' + pid,
            url: ThinkPHP.APP + '/Home/UploadPic/del_Img',
            success: function(msg) {
                $('#showPic'+id+'>div[data-id="'+pid+'"]').remove();//清除图片
                //$('input[name="thumb[]"]').val('');
                var idA = new Array();
                $('#showPic'+id+'>div').each(function(i,item){
                    idA[i] = $(item).data('id');
                });
                var ids = idA.join(',');
                $('#thumb'+id).val(ids);
                if(ids == ''){
                   $('#showPic'+id).addClass('hide');
                }
            }
        });
    }
    </script>



	<!-- /底部 -->
</body>
</html>