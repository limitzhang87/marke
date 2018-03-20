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
    <form action="" method="POST">
        <div class="unit_set">
            <div class="unit_set_item">
                <div class="unit_set_title">单元名称（序号）:</div>
                <div class="unit_set_value">
                    <input class="input_m" type="" class="input" name="u_name">
                </div>
            </div>
            <div class="unit_set_item">
                <div class="unit_set_title">每层房间套数:</div>
                <div class="unit_set_value">
                    <input class="input_s" type="number" name="room_num">
                </div>
            </div>
            <div class="unit_set_item">
                <div class="unit_set_title">楼层区间:</div>
                <div class="unit_set_value">
                    <input class="input_s" type="number" name="floor_start"><span style="margin: 0 10px;">-</span>
                    <input class="input_s" type="number" name="floor_over">
                </div>
            </div>
        </div>
        <div class="check_other">
            <label>勾选其他相同单元</label>
            <div class="check_info"></div>
            <div class="check_unit_set">
            </div>
        </div>
        <div class="sameroom_set">
            <div class="room_scroll">
            </div>
            <div class="room_page">
            </div>
        </div>
        <center id="button" style="margin: 20px 0;" class="hide">
            <input type="hidden" name="b_id" value="<?php echo ($_building["b_id"]); ?>">
            <input type="hidden" name="u_order" value="<?php echo ($_building["u_order"]); ?>">
            <button class="button_l btn_submit" type="submit">确认无误提交</button>
        </center>
    </form>
    <!-- 用于放置用户要上传图片的表单，没添加一个套房的信息，就添加一个表单 -->
    <div id="fromPicdiv">
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
    var room_num = 0;
    var $fields = '<?php echo ($_fields); ?>';
    $fields = JSON.parse($fields);
    var UnitInfohtml = '';
    var fromHtml  = '';
    /**
     * 每种套房设计方案
     */
    $.each($fields, function(i){
        if (this.name == 'thumb') {
            UnitInfohtml += '<div class="unit_set_item" style="height:auto;">' +
                                '<div class="unit_set_title">' + this.title + ':</div>' +
                                '<div class="unit_set_value">' +
                                    '<div class="button" onclick="fileSelect(\'%s\')" style="width:auto;margin:5px;padding:0 5px;">选择图片</div>' +
                                    '<input class="input_m" id="thumb%s"  type="hidden" name="thumb[]">' +
                                '</div>' +
                            '</div>' +
                            '<div id="showPic%s" class="hide"  style="width:90%;margin:0 auto;margin-top:-1.8rem;"></div>';

            fromHtml += '<form id="form%s" enctype="multipart/form-data">' +
                '<input class="input_m hide" id="fileToUpload%s" name="fileToUpload[]" type="file" multiple  accept="image/png,image/jpg,image/gif,image/jpeg,image/svg"  onChange="fileUpload(\'%s\')" >' +
                '</form>';
        } else {
            UnitInfohtml += '<div class="unit_set_item">' +
                '<div class="unit_set_title">' + this.title + ':</div>' +
                '<div class="unit_set_value">' +
                '<input class="input_m" type="" class="input" name="' + this.name + '[]">' +
                '</div>' +
                '</div>';
        }
    });
    $('.room_page').html(UnitInfohtml);
    /**
     * AJAX获取所有的栋和单元，为填写相同的单元准备
     */
    $.ajax({
        url: '/marke/index.php?s=/Home/Room/get_building_list',
        type: 'POST',
        data: {'a=':1},
        success: function(msg) {
            if (msg.error == 0) {
                check_html(msg.list);
            } else {

            }
        },
    })

    /**
     * 检测获取到的栋和单元判断那些已经填写，那个是当前填写
     */
    function check_html($list) {
        $($list).each(function(i, item) {
            var html = '';
            html += '<div class="check_building">' +
                '<div class="check_b_name">' + item.b_name + '栋</div>' +
                '<div class="check_unit">';
            var $is_w = item.is_w;
            $is_w = $is_w.split(',');
            $($is_w).each(function(k, itemI) {
                //如果itemI是0表示还没有填写ID
                if (itemI == 0) { //z
                    if ((k) == "<?php echo ($_building["u_order"]); ?>" && (item.id == "<?php echo ($_building["b_id"]); ?>")) { //正在编辑的单元
                        html += '<div class="check_u_item" style="color:red;">' +
                            '' + (k + 1) + '单元' +
                            '</div>';
                    } else {
                        html += '<div class="check_u_item">' +
                            '<input type="checkbox" name="other_b_id[]" value="' + item.id + '-' + (k) + '-' + item.b_name + '">' + (k + 1) + '单元 ' +
                            '</div>';
                    }
                    // 每个复选框中的value都是有栋号ID，单元排序，栋号名称通过"-"组合成的
                } else {
                    html += '<div class="check_u_item">' +
                        '' + (k + 1) + '单元 ' +
                        '</div>';
                    // 每个复选框中的value都是有栋号ID，单元排序，栋号名称通过"-"组合成的
                }
            });
            html += '</div>' +
                '</div>';
            $('.check_info').append(html);
        });
        //勾选的后的单元显示输入框填写单元信息
        $('input[name="other_b_id[]"]').each(function(i, check) {
            $(check).click(function() {
                if ($(this).prop("checked")) {
                    add_check($(this).val());
                } else {
                    remove_check($(this).val());
                }

            });
        });
        inputSelect();
    }

    /**
     * 添加相同的单元的单元表单
     */
    function add_check($id) {
        var array = $id.split('-');
        var add_html = '<div id="check_' + $id + '">' +
            '<label>' + array[2] + '栋' + (parseInt(array[1]) + 1) + '单元</label>' +
            '<div class="unit_set_item">' +
            '<div class="unit_set_title">单元名称（序号）:</div>' +
            '<div class="unit_set_value">' +
            '<input class="input_m" type="" class="input" name="u_name-' + array[0] + '_' + array[1] + '">' +
            '</div>' +
            '</div>' +
            '<div class="unit_set_item">' +
            '<div class="unit_set_title">楼层区间:</div>' +
            '<div class="unit_set_value">' +
            '<input class="input_s" type="number" name="floor_start-' + array[0] + '_' + array[1] + '"><span style="margin: 0 10px;">-</span>' +
            '<input class="input_s" type="number" name="floor_over-' + array[0] + '_' + array[1] + '">' +
            '</div>' +
            '</div>' +
            '</div>';
        $('.check_unit_set').append(add_html);
        inputSelect();
    }

    /**
     * 删除单元表单
     */
    function remove_check($id) {
        $('#check_' + $id).remove();
    }


    /**
     * 当每层楼房间数变化时触发
     * @param  {[type]} ){                     room_num [description]
     * @return {[type]}     [description]
     */
    $('input[name="room_num"]').on('input onpropertychange', function() {
        room_num = $(this).val();
        $('.room_scroll').html('');
        $('.room_page').html('');
        if (room_num > 0) {
            var roomHtml = '';
            var pageHtml = ''
             $('#fromPicdiv').html('');
            for (var i = 1; i <= room_num; i++) {
                roomHtml += '<div class="group" id="room_' + i + '">套房' + i + '</div>';
                pageHtml += '<div class="room_set" id="page_' + i + '"> ' + UnitInfohtml.replace(/%s/g, i) + '</div>';
                $('#fromPicdiv').append(fromHtml.replace(/%s/g, i));
            }
            $('.room_scroll').html(roomHtml);
            $('.room_page').html(pageHtml);

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
        } else {
            $('.room_page').html(UnitInfohtml);
        }
    });



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