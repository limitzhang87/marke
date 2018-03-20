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
        .unit_set_value label{
            padding-left: 10px;
            font-size: 1.5rem;
            line-height: 3rem;
        }
        .tip div{
            width: 100%;
            text-align: center;
            margin: 5px 0;
            font-size: 1.5rem;
            color: #8F8F8F;
        }
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
    <form method="POST">
        <div class="unit_set_item">
            <div class="unit_set_title">栋号</div>
            <div class="unit_set_value">
                 <label><?php echo ($room["b_name"]); ?>栋</label>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">单元号</div>
            <div class="unit_set_value">
                <label><?php echo ($room["u_name"]); ?>单元</label>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">房号</div>
            <div class="unit_set_value">
               <input class="input_m" type="text" name="room_number" class="input" value="<?php echo ($room["room_number"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?> >
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">房</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="sameroom[apartment]" value="<?php echo ($room["apartment"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?>>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">厅</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="sameroom[hall]" value="<?php echo ($room["hall"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?>>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">厨</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="sameroom[kitchen]" value="<?php echo ($room["kitchen"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?>>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">卫</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="sameroom[toilet]" value="<?php echo ($room["toilet"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?>>
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">建筑面积</div>
            <div class="unit_set_value">
               <input class="input_m" type="text" name="sameroom[area]" class="input" value="<?php echo ($room["area"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?> >m²
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">建筑单价</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="unit_price" class="input" value="<?php echo ($room["unit_price"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?> >元/m²
            </div>
        </div>
        <div class="unit_set_item">
            <div class="unit_set_title">总价</div>
            <div class="unit_set_value">
                <input class="input_m" type="text" name="total_price" class="input" value="<?php echo ($room["total_price"]); ?>" <?php if(($edit) != "1"): ?>disabled="disabled"<?php endif; ?> >元
            </div>
        </div>
        <div class="unit_set_item" style="height:auto;">
            <div class="unit_set_title">户型图:</div>
            <div class="unit_set_value">
                <div class="button" onclick="fileSelect()" style="width:auto;margin:5px;padding:0 5px;">选择图片</div>
                <input class="input_m" id="thumb" type="hidden" name="sameroom[thumb]" value="<?php echo ($room["thumb"]); ?>">
            </div>
        </div>
        <div id="showPic" class="hide1" style="width:80%;margin:0 auto;">
            <?php if($room['thumb'] != '' ): $room['thumb'] = explode(',',$room['thumb']);$kk = $key+1; ?>
                <?php if(is_array($room['thumb'] )): $i = 0; $__LIST__ = $room['thumb'] ;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$thumb): $mod = ($i % 2 );++$i;?><div class="div_img" data-id="<?php echo ($thumb); ?>">
                    <div class="close_red right" onclick="delImg('<?php echo ($thumb); ?>')">X</div>
                    <img src="/marke<?php echo get_cover($thumb);?>" style="width:100%;">
                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </div>
        <?php if($edit == 1): ?><center >
            <input type="hidden" name="id" value="<?php echo ($room["id"]); ?>">
            <input type="hidden" name="s_id" value="<?php echo ($room["s_id"]); ?>">
            <button class="button btn_submit">提交</button>
        </center>
        <?php else: ?>
        <div class="tip">
            <div>该房间不是属于未售状态，不能编辑</div>
        </div><?php endif; ?>
    </form>
    <form id="form" enctype="multipart/form-data">
        <input class="input_m hide" id="fileToUpload" name="fileToUpload[]" type="file" multiple="" accept="image/png,image/jpg,image/gif,image/jpeg,image/svg" onchange="fileUpload()">
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

    <script type="text/javascript">
        var unit_price = '<?php echo ($room["unit_price"]); ?>';
        var area = '<?php echo ($room["area"]); ?>'
        $('input[name="unit_price"]').on('input onpropertychange',function(){
            if($(this).val() == ''){
                $('#total_price').html( '0万元');
                return ;
            }
            var price = parseFloat($(this).val());
            price = price.toFixed(2);
            if(isNaN(price)){
                alert('输入错误！');
                $(this).val(unit_price);
                var total_price = area *unit_price;
                $('#total_price').val( total_price.toFixed(0));
                return;
            }

            var total_price = area *price;
            $('#total_price').val( total_price.toFixed(0));
        })



    /**
     * 触发文件选择框架
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    function fileSelect() {
        $('#fileToUpload').click();
    }

    /**
     * 当文件选择框选择文件时自动上传。
     * @param  {int} id 房号的暂时ID
     */
    function fileUpload() {
        var formData = new FormData($('#form')[0]); //获取表单
        //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
        //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
        $.ajax({
            url: ThinkPHP.APP + '/Home/UploadPic/uploadPicture',
            type: 'POST',
            data: formData, // Form数据
            cache: false,
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
            processData: false, // 告诉jQuery不要去处理发送的数据
            beforeSend: function() {
                $('#loading').remove();
                var html = '<div class="img_div" id="loading">' +
                    '<img class="up_pic"  src="' + ThinkPHP.ROOT + '/Public/Mobile/images/icon/load.gif">' +
                    '</div>';
                $('#showPic').append(html);
            },
            success: function(msg) {
                $('#loading').remove();
                if (msg.status == 1) {
                    imgHtml(msg.info);
                }else{
                     alert('上传失败');
                }
            },
            error: function() {
                $('#loading').remove();
                alert('上传失败');
            },
        });
    }

    function imgHtml(info){
        $(info).each(function(i,item){
            var html ='<div class="div_img" name="pic" data-id="'+item.id+'"><div class="close_red right" onclick="delImg(' + item.id + ')">X</div>' +
                '<img src="/marke' + item.path + '" style="width:100%;"></div>' ;
            $('#showPic').append(html);
            $('#showPic').removeClass('hide');
        });
        var idA = new Array();
        $('#showPic>div').each(function(i,item){
            idA[i] = $(item).data('id');
        });
        var ids = idA.join(',');
        $('#thumb').val(ids);
    }
    /**
     * 删除图片
     * @param  {[type]} pic_path [description]
     * @return {[type]}          [description]
     */
    function delImg(pid) {
        if(!confirm('是否删除图片！')){
            return ;
        }

        $('#showPic>div[data-id="'+pid+'"]').remove();//清除图片
        //$('input[name="thumb[]"]').val('');
        var idA = new Array();
        $('#showPic>div').each(function(i,item){
            idA[i] = $(item).data('id');
        });
        var ids = idA.join(',');
        $('#thumb').val(ids);
        if(ids == ''){
           $('#showPic').addClass('hide');
        }
        return ;
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

    
    $('input[name="unit_price"]').on('input onpropertychange', function() {
        var total_price = $(this).val() * $('input[name="sameroom[area]').val();
        if( isNaN(total_price)){
            total_price = 0;
        }
        $('input[name="total_price"]').val(parseInt(total_price));
    });

    $('input[name="total_price"]').on('input onpropertychange', function() {
        var unit_price = $(this).val() / $('input[name="sameroom[area]').val();
        if( isNaN(unit_price)){
            unit_price = 0;
        }
        $('input[name="unit_price"]').val(parseInt(unit_price));
    });
    </script>



	<!-- /底部 -->
</body>
</html>