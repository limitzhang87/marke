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
    
    <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="/marke/Public/static/swiper/dist/css/swiper.min.css">

  <!-- Demo styles -->
  <style>
    html, body {
      position: relative;
      height: 100%;
    }
    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color:#000;
      margin: 0;
      padding: 0;
    }
    .swiper-container {
      width: calc(100% - 40px);
      height: 100%;
      border-bottom: solid #EBEBEB 2PX;
      padding: 0 20px;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

      /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        /*margin-right: 0 !important;*/
        border: solid #EBEBEB;
        border-width: 0 1px 0 0;
        line-height: 35px;
        cursor:pointer;
    }
  </style>
    <style type="text/css">
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
    </style>
    <div action="" method="POST">
        <div class="unit_set">
            <div class="unit_set_item">
                <div class="unit_set_title">单元名称（序号）:</div>
                <div class="unit_set_value">
                    <input class="input_m" type="" class="input" name="u_name" value="<?php echo ($_unit['u_name']); ?>">
                </div>
            </div>
        </div>
        <div class="sameroom_set">

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="group swiper-slide" id="room_<?php echo ($vo["id"]); ?>" onclick="showPage('<?php echo ($vo["id"]); ?>')"><?php echo ($vo['r_name']); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="room_page">
                <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><form class="room_set" id="page_<?php echo ($vos["id"]); ?>">
                    <input type="hidden" name="sameroom[id]" value="<?php echo ($vos["id"]); ?>">
                    <div class="unit_set_item">
                        <div class="unit_set_title">房间序号（名称）</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[r_name]" value="<?php echo ($vos["r_name"]); ?>" >
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">单价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[unit_price]" value="<?php echo ($vos["unit_price"]); ?>">
                        </div>
                    </div>
                    <!--<div class="unit_set_item">
                        <div class="unit_set_title">建筑价格差价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[bt_price]" value="<?php echo ($vos["bt_price"]); ?>">
                        </div>
                    </div> -->
                    <div class="unit_set_item">
                        <div class="unit_set_title">建筑面积</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[area]" value="<?php echo ($vos["area"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">总价</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[total_price]" value="<?php echo ($vos["total_price"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">房</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[apartment]" value="<?php echo ($vos["apartment"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">厅</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[hall]" value="<?php echo ($vos["hall"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">厨</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[kitchen]" value="<?php echo ($vos["kitchen"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">卫</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[toilet]" value="<?php echo ($vos["toilet"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item">
                        <div class="unit_set_title">朝向</div>
                        <div class="unit_set_value">
                            <input class="input_m" type="" name="sameroom[orientation]" value="<?php echo ($vos["orientation"]); ?>">
                        </div>
                    </div>
                    <div class="unit_set_item" style="height:auto;">
                        <div class="unit_set_title">户型图:</div>
                        <div class="unit_set_value">
                            <div class="button" onclick="fileSelect('<?php echo ($vos["id"]); ?>')" style="width:auto;margin:5px;padding:0 5px;">选择图片</div>
                            <input class="input_m" id="thumb<?php echo ($vos["id"]); ?>" type="hidden" name="sameroom[thumb]" value="<?php echo ($vos["thumb"]); ?>">
                        </div>
                    </div>
                    <div id="showPic<?php echo ($vos["id"]); ?>"  style="width:90%;margin:0 auto;">
                        <?php if($vos['thumb'] != '' ): $vos['thumb'] = explode(',',$vos['thumb']);$kk = $key+1; ?>
                            <?php if(is_array($vos['thumb'] )): $i = 0; $__LIST__ = $vos['thumb'] ;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$thumb): $mod = ($i % 2 );++$i;?><div class="div_img" data-id="<?php echo ($thumb); ?>">
                                <div class="close_red right" onclick="delImg('<?php echo ($vos["id"]); ?>','<?php echo ($thumb); ?>')">X</div>
                                <img src="/marke<?php echo get_cover($thumb);?>" style="width:100%;">
                            </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                    <center id="button" style="margin: 20px 0;">
                        <input type="hidden" name="b_id" value="<?php echo ($_building["b_id"]); ?>">
                        <input type="hidden" name="u_order" value="<?php echo ($_building["u_order"]); ?>">
                        <div class="button_l btn_submit" onclick="submit('<?php echo ($vos["id"]); ?>')" >提交修改</div>
                    </center>
                </form><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <!-- 用于放置用户要上传图片的表单，没添加一个套房的信息，就添加一个表单 -->
    <div id="fromPicdiv">
        <?php if(is_array($_sameroom)): $i = 0; $__LIST__ = $_sameroom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><form id="form<?php echo ($vos["id"]); ?>" enctype="multipart/form-data">
                <input class="input_m hide fileToUpload" id="fileToUpload<?php echo ($vos["id"]); ?>" name="fileToUpload[]" type="file" multiple="" accept="image/png,image/jpg,image/gif,image/jpeg,image/svg" onchange="fileUpload('<?php echo ($vos["id"]); ?>')">
            </form><?php endforeach; endif; else: echo "" ;endif; ?>
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

    <script src="/marke/Public/static/swiper/dist/js/swiper.min.js"></script>
    <script type="text/javascript" charset="utf-8">
    var room_num = 0;
    var $fields = '<?php echo ($_fields); ?>';
    $fields = JSON.parse($fields);
    var UnitInfohtml = '';
    var fromHtml  = '';
    $(function(){
        $.each($fields, function(i){
            if (this.name == 'thumb') {
                UnitInfohtml += '<div class="unit_set_item" style="height:auto;">' +
                                    '<div class="unit_set_title">' + this.title + ':</div>' +
                                    '<div class="unit_set_value">' +
                                        '<div class="button" onclick="fileSelect(\'%s\')" style="width:auto;margin:5px;padding:0 5px;">选择图片</div>' +
                                        '<input class="input_m" id="thumb%s"  type="hidden" name="sameroom[thumb]">' +
                                    '</div>' +
                                '</div>' +
                                '<div id="showPic%s" class="hide"  style="width:90%;margin:0 auto;margin-top:-1.8rem;"></div>'+
                                ' <center id="button" style="margin: 20px 0;" >'+
                                    '<input type="hidden" name="b_id" value="<?php echo ($_building["b_id"]); ?>">'+
                                    '<input type="hidden" name="u_order" value="<?php echo ($_building["u_order"]); ?>">'+
                                    '<div class="button_l btn_submit" onclick="submit(\'%s\')" >新增别墅</div>'+
                                '</center>';

                fromHtml += '<form id="form%s" enctype="multipart/form-data">' +
                    '<input class="input_m hide fileToUpload" id="fileToUpload%s" name="fileToUpload[]" type="file" multiple  accept="image/png,image/jpg,image/gif,image/jpeg,image/svg"  onChange="fileUpload(\'%s\')" >' +
                    '</form>';
            } else {
                UnitInfohtml += '<div class="unit_set_item">' +
                    '<div class="unit_set_title">' + this.title + '</div>' +
                    '<div class="unit_set_value">' +
                    '<input class="input_m" type="" class="input" name="sameroom[' + this.name + ']">' +
                    '</div>' +
                    '</div>';
            }
        });
        addRoomPage();
    })

    /*添加一个新的别墅表单*/
    function addRoomPage() {
        var roomHtml = '';
        var pageHtml = ''
        var id = 0;
        roomHtml += '<div class="group swiper-slide" id="room_'+id+'" onclick="showPage(\''+id+'\')">新增别墅</div>';
        pageHtml += '<form class="room_set" id="page_0"> ' + UnitInfohtml.replace(/%s/g, id) + '</form>';
        $('#fromPicdiv').prepend(fromHtml.replace(/%s/g, id));

        $('.swiper-wrapper').prepend(roomHtml);
        $('.room_page').prepend(pageHtml);
        showPage(id);
        computed();
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 6,
            spaceBetween: 1,
            // init: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

    }

    function showPage(id) {
        console.log();
        $('.show').removeClass('show');
        $('.group_on').removeClass('group_on');
        $('#room_' +id).addClass('group_on');
        $('#page_' +id).addClass('show');
    }

    /**
     * 提交
     * @param  {string} id 标识
     * @return {[type]}    [description]
     */
    function submit(id) {
        var formData = new FormData($('#page_'+id)[0]); //获取表单
        formData.append('u_name',$('input[name="u_name"]').val());
        formData.append('id',id);
        $.ajax({
            url: ThinkPHP.APP + '/Home/Room/unit_set2',
            type: 'POST',
            data: formData, // Form数据
            cache: false,
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
            processData: false, // 告诉jQuery不要去处理发送的数据
            beforeSend:function(){
            $('#dialog_load').addClass('show');
            },
            complete:function(){
                $('#dialog_load').removeClass('show');
            },
            success: function(msg) {
                if(msg.status == 1){
                    if(id == 0){
                        addHtml(msg.info);
                        alert('添加成功');
                    }else{
                        $('#room_' +id).html(msg.info.r_name);
                        alert('修改成功');
                    }
                }else{
                    alert('添加失败');
                }
            },
            error: function() {
                alert('添加失败');
            },
        });
    }

    /*别墅添加成功后，将新的输入表单中*/
    function addHtml(info){
        $('#room_0').html(info.r_name);
        blink($('#room_0'));
        $('#page_0>center>.button_l').html('提交修改');
        $('#room_0').attr('id','room_' + info.id);
        $('#page_0').attr('id','page_' + info.id);
        $('#thumb0').attr('id','thumb' + info.id);

        $('#showPic0>div').each(function(i,item){
            var did = $(item).data('id');
            $(item).children('div').attr('onclick','delImg('+info.id+','+did+' )');
        })
        $('#showPic0').attr('id','showPic' + info.id);

        $('#form0').attr('id','form' + info.id);
        $('div[onclick="showPage(\'0\')"]').attr('onclick','showPage(\''+info.id+'\')');
        $('div[onclick="submit(\'0\')"]').attr('onclick','submit(\''+info.id+'\')');
        $('div[onclick="fileSelect(\'0\')"]').attr('onclick','fileSelect(\''+info.id+'\')');
        $('input[onchange="fileUpload(\'0\')"]').attr('onchange','fileUpload(\''+info.id+'\')');
        addRoomPage();
    }


    /**
     * 触发文件选择框架
     * @param  {int} id 同类房号ID
     * @return {[type]}    [description]
     */
    function fileSelect(id) {
        $('#form'+id+'>.fileToUpload').click();
    }

    /**
     * 当文件选择框选择文件时自动上传。
     * @param  {int} id 房号的暂时ID
     */
    function fileUpload(id) {
        var formData = new FormData($('#form'+id)[0]); //获取图片表单
        //formData.append('brand_name',$('option[value="'+$('select').val()+'"]').html());
        //FormData的参数只能是 HTMLFormElement,而JQ拿到的是一个对象，但是下标0的属性就是 HTMLFormElement
        $.ajax({
            url: ThinkPHP.APP + '/Home/UploadPic/uploadPicture',
            type: 'POST',
            data: formData, // Form数据
            cache: false,
            contentType: false, // 告诉jQuery不要去设置Content-Type请求头，然后在表单里面设置Content-Type为enctype="multipart/form-data"
            processData: false, // 告诉jQuery不要去处理发送的数据
            beforeSend:function(){
                $('#dialog_load').addClass('show');
            },
            complete:function(){
                $('#dialog_load').removeClass('show');
            },
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
            var html ='<div name="pic" data-id="'+item.id+'"><div class="close" onclick="delImg('+id+',' + item.id + ')">X</div>' +
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
     * @param  {int} id  同类房号ID
     * @param  {int} pid 图片ID
     * @return {[type]}     [description]
     */
    function delImg(id,pid) {
        if(!confirm('是否删除图片！')){
            return ;
        }
        $.ajax({
            type: 'POST',
            data: 'id=' + pid,
            url: ThinkPHP.APP + '/Home/UploadPic/del_Img',
            beforeSend:function(){
                $('#dialog_load').addClass('show');
            },
            complete:function(){
                $('#dialog_load').removeClass('show');
            },
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

    /*监听单价和面积计算总价*/
    function computed() {
        $('#page_0 input[name="sameroom[area]"]').on('input propertychange',function(){
            var area = $(this).val();
            var unitprice =   $('#page_0 input[name="sameroom[unit_price]"]').val();
            $('#page_0 input[name="sameroom[total_price]"]').val(parseInt(area*unitprice));
        })

        $('#page_0 input[name="sameroom[unit_price]"]').on('input propertychange',function(){
            var unitprice = $(this).val();
            var area =   $('#page_0 input[name="sameroom[area]"]').val();
            $('#page_0 input[name="sameroom[total_price]"]').val(parseInt(area*unitprice));
        })

    }
    </script>



	<!-- /底部 -->
</body>
</html>