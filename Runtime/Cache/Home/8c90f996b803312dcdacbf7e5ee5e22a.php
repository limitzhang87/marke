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
    
    <link href="/marke/Public/Mobile/css/report.css" rel="stylesheet">
    <link rel="stylesheet" href="/marke/Public/static/swiper/css/swiper.min.css">
    <style>
    html, body {
      position: relative;
      height: 100%;
    }
    body {
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color:#000;
      margin: 0;
      padding: 0;
    }
    .button{
        width: auto !important;
    }
    .swiper-container {
      width: 100%;
      height: 100%;
      overflow: visible; 
    }

    .swiper-container1 {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 10;
    }
    .swiper-slide {
      text-align: center;
      font-size: 1rem !important;
      background: #fff;
      width: auto !important;
      margin-right: 5px !important;
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
    }
    .swiper-slide:last-child{
        width: 10px !important;
    }
  </style>
    <div style="height: 4rem;z-index: 50;white-space: nowrap;">
        <div id="filterbox" style="margin-left: 5px;">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if(is_array($_filter)): $i = 0; $__LIST__ = $_filter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="filter swiper-slide" id="<?php echo ($vo["type"]); ?>" style="display:inline-block;" data-type="<?php echo ($vo["type"]); ?>">
                        <div class="dropdown-backdrop"></div>
                        <div class="button"  data-value="<?php echo ($vo['data'][0]['value']); ?>"><?php echo ($vo['data'][0]['title']); ?></div>
                        <ul class="dropdown-menu <?php echo ($vo["type"]); ?>">
                            <?php if(is_array($vo['data'])): $i = 0; $__LIST__ = $vo['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li role="presentation">
                                <a tabindex="-1" href="#" data-value='<?php echo ($val["value"]); ?>'><?php echo ($val["title"]); ?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="swiper-slide" style="margin-top: 5px;">
                        <input type="text" style="width: 8rem;"  name="date1" class="date"> - <input type="text" style="width: 8rem;" name="date2" class="date">
                        <button class="button" style="width: 6.5rem;margin: 0 5px 0 5px;line-height: 1.8rem;" onclick="dateSearch();">日期查询</button>
                    </div>
                    <div class="swiper-slide" style="width: 2rem !important;">
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- 数据列表 -->
    <div style="margin-left: 10px;display: -webkit-box;">
        <select name="search_key">
            <option value="name">客户姓名</option>
            <option value="phone">手机号码</option>
            <option value="in_province">是否省内</option>
            <option value="is_over">是否完成</option>
        </select>
        <input type="text" name="kw" style="width: 8rem;">
        <button class="button"  style="width: 6.5rem;margin: 5px 5px 0 5px;line-height: 1.8rem;"  id="searchbutton">重置</button>
    </div>
    <center style="font-size: 1.3rem;color: #AAAAAA;margin:5px 10px;border: solid #ABABAB;border-width: 1px;border-radius: 5px;">
        <div id="total" style="color: red;" ></div>
    </center>
    <div class="data-table" id="tabledata">
    </div>
    <div class="pageShow">
    </div>
    <div id="statistics1">
    </div>
    <center id="download"><button style="border: none;" class="status_raise" onclick="downloadExcel('<?php echo ($_title); ?>')">下载当前数据到excel</button></center>

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

    <link href="/marke/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/marke/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/marke/Public/Mobile/js/filter.js"></script>
    <script type="text/javascript" src="/marke/Public/Mobile/js/bborder.js"></script>
    <script src="./marke/Public/static/swiper/js/swiper.min.js"></script>
    <script type="text/javascript">
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
        var swiper = new Swiper('.swiper-container', {
          slidesPerView: 3,
          spaceBetween: 30,
          freeMode: true,
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
        });
    </script>
    <script type="text/javascript">
        fields     = '<?php echo ($fields); ?>';
        unfields   = '<?php echo ($unfields); ?>';
        search_key = '<?php echo ((isset($search_key) && ($search_key !== ""))?($search_key):"*"); ?>';
        kw         = '<?php echo ($kw); ?>';
        sfields    = '<?php echo ($sfields); ?>';
        order      = '<?php echo ($order); ?>';
        page       = 1;
        where      = '<?php echo ($where); ?>';
        field      = '<?php echo ($field); ?>';
        uid        = '<?php echo ($uid); ?>';
        status     = '<?php echo ($status); ?>';
        $('input[name="kw"]').on('input propertychange',function(){
            kw = $.trim($(this).val());
            if(kw == ''){
                $('#searchbutton').html('重置');
            }else{
                $('#searchbutton').html('搜索');
            }
        })
        $('#searchbutton').click(function(){
            search_key = $('select[name="search_key"]').val();
            kw = $('input[name="kw"]').val();
            kw = $.trim(kw);
            if(kw == ''){
                if(confirm('是否重置搜索条件')){
                    fields     = '<?php echo ($fields); ?>';
                    unfields   = '<?php echo ($unfields); ?>';
                    search_key = '<?php echo ($search_key); ?>';
                    kw         = '<?php echo ($kw); ?>';
                    sfields    = '<?php echo ($sfields); ?>';
                    order      = '<?php echo ($order); ?>';
                    page       = 1;
                    where      = '<?php echo ($where); ?>';
                    getList();
                }
                return;
            }
            if(search_key == 'phone' && kw.length >= 11){
                alert('抱歉，手机长度不能超过11个字符');
                return ;
            }
            if(search_key == 'in_province' || search_key == 'is_over'){
                if(kw == '是'){
                    kw = 1;
                }else if(kw == '否'){
                    kw = 0;
                }else{
                    alert('抱歉，请输入“是”或“否”');
                    return;
                }
            }
            getList();
        })

        /*定义AJAX获取数据的函数名称*/
        var funName = 'getList';
        $(function(){
            window[funName]();
        })
        $('#filterbox').mousedown(function(e){
            var old = e.pageX;
            $('#filterbox').mousemove(function(ee){
                //console.log(e.pageX + ", " + e.pageY);
                var x = ee.pageX;
                var d = x - old;
                var left = $('#filterbox').css('left');

                var array = left.split('px');
                var now = array[0];
                $('#filterbox').css('left',  (parseInt(d/10) + parseInt(now)) + 'px' );
            });
        });

        $('#filterbox').mouseup(function(){
            $('#filterbox').unbind("mousemove"); //移除click
            var left = $('#filterbox').css('left');
            var array = left.split('px');
            var now = array[0];
            if(parseInt(now)>0){
                $('#filterbox').css('left',  '0px' );
            }

        });
    </script>



	<!-- /底部 -->
</body>
</html>