<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>选择楼盘</title>
    <link href="/marke/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/marke/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
    <link rel="stylesheet" href="/marke/Public/Admin/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/marke/Public/Admin/css/font-awesome/css/font-awesome-ie7.min.css">
    <script type="text/javascript" src="/marke/Public/static/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/marke/Public/Admin/js/jquery.mousewheel.js"></script>
    <script type="text/javascript">
    (function() {
        var ThinkPHP = window.Think = {
            "ROOT": "/marke", //当前网站地址
            "APP": "/marke/index.php?s=", //当前项目地址
            "PUBLIC": "/marke/Public", //项目公共目录地址
            "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/marke/Public/static/js/think.js"></script>
    <script type="text/javascript" src="/marke/Public/Admin/js/common.js"></script>
</head>

<body style=" padding: 0px 0 0 0px;">
    <!-- 标题 -->
    <div class="">
    </div>
    <?php if(is_array($province_rs)): $i = 0; $__LIST__ = $province_rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo addons_url('HousesDialog://HousesDialog/HousesSelect',array('category_id'=>I('category_id',0),'city'=>$v['id']));?>"><?php echo ($v["name"]); ?>&nbsp;&nbsp;</a><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php if(is_array($city_rs)): $i = 0; $__LIST__ = $city_rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo addons_url('HousesDialog://HousesDialog/HousesSelect',array('category_id'=>I('category_id',0),'city'=>$v['id']));?>"><?php echo ($v["name"]); ?>&nbsp;&nbsp;</a><?php endforeach; endif; else: echo "" ;endif; ?>
    <br/>
    <!-- 按钮工具栏 -->
    <div class="cf">
        <div class="fl">
        </div>
        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <div class="drop-down">
                    <span id="sch-sort-txt" class="sort-txt" data="<?php echo ($status); ?>"><?php if(get_status_title($get_data['status']) == ''): ?>所有<?php else: echo get_status_title($get_data['status']); endif; ?></span>
                    <i class="arrow arrow-down"></i>
                    <ul id="sub-sch-menu" class="nav-list hidden">
                        <li><a href="javascript:;" value="">所有</a></li>
                        <li><a href="javascript:;" value="1">正常</a></li>
                        <li><a href="javascript:;" value="0">禁用</a></li>
                        <li><a href="javascript:;" value="2">待审核</a></li>
                    </ul>
                </div>
                <input type="text" name="title" class="search-input" value="<?php echo ($get_data["title"]); ?>" placeholder="请输入标题文档">
                <a class="sch-btn" href="javascript:;" id="search" url="<?php echo addons_url('HousesDialog://HousesDialog/HousesSelect',array('category_id'=>I('category_id',0)));?>"><i class="btn-search"></i></a>
            </div>
        </div>
    </div>
    <!-- 数据表格 -->
    <div class="data-table">
        <table>
            <!-- 表头 -->
            <thead>
                <tr>
                    <th class="row-selected row-selected">
                    </th>
                    <th>编号</th>
                    <th>楼盘名称</th>
                    <th>城市</th>
                    <th>最后更新</th>
                    <th>状态</th>
                    <th>浏览</th>
                </tr>
            </thead>
            <div style="display:none">
                <input type='text' value="<?php echo ($select_type); ?>" id='select_type' />
            </div>
            <!-- 列表 -->
            <tbody>
                <?php
 $arr=explode(',',$houses_id); ?>
                <?php if(is_array($list["contents"])): $i = 0; $__LIST__ = $list["contents"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <?php
 for($i=0;$i<count($arr);$i++){ if($data['id']==$arr[$i]){ echo "<input class='ids' type='checkbox' value='".$arr[$i]."' name='ids[]' title='".$data['title']."' checked='checked'></td>"; break; } } if($i==count($arr)){ echo "<input class='ids' type='checkbox' value='".$data['id']."' name='ids[]' title='".$data['title']."'></td>"; } ?>
                            <!-- <input class="ids" type="checkbox" value="<?php echo ($data["id"]); ?>" name="ids[]" title="<?php echo ($data["title"]); ?>" <?php if($data["id"] == $houses_id): ?>checked="checked"<?php endif; ?> ></td> -->
                        <td><?php echo ($data["id"]); ?></td>
                        <td><?php echo ($data["title"]); ?></td>
                        <td><a href="<?php echo addons_url('HousesDialog://HousesDialog/HousesSelect',array('category_id'=>I('category_id',0),'city'=>$data['city']));?>"><?php echo ($data["city_name"]); ?></a></td>
                        <td><?php echo (date('Y-m-d H:i:s',$data["update_time"])); ?></td>
                        <td><?php echo (get_status_title($data["status"])); ?></td>
                        <td><?php echo ($data["view"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
    <!-- 分页 -->
    <div class="page">
        <?php echo ($_page); ?>
    </div>
    <button id="submit" class="btn submit-btn ajax-post hidden" target-form="form-horizontal" type="submit">确定</button>
    <a class="btn btn-return" href="" id="back">返 回</a>
    <script src="/marke/Public/static/plugins/artDialog/lib/sea.js"></script>
    <script>
    seajs.config({
        alias: {
            "jquery": "jquery-1.10.2.js"
        }
    });
    </script>
    <script>
    //搜索功能
    $("#search").click(function() {
        var url = $(this).attr('url');
        var status = $("#sch-sort-txt").attr("data");
        var query = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g, '');
        query = query.replace(/^&/g, '');
        if (status != '') {
            query = 'status=' + status + "&" + query;
        }
        if (url.indexOf('?') > 0) {
            url += '&' + query;
        } else {
            url += '?' + query;
        }
        window.location.href = url;
    });

    /* 状态搜索子菜单 */
    $(".search-form").find(".drop-down").hover(function() {
        $("#sub-sch-menu").removeClass("hidden");
    }, function() {
        $("#sub-sch-menu").addClass("hidden");
    });
    $("#sub-sch-menu li").find("a").each(function() {
        $(this).click(function() {
            var text = $(this).text();
            $("#sch-sort-txt").text(text).attr("data", $(this).attr("value"));
            $("#sub-sch-menu").addClass("hidden");
        })
    });

    //回车自动提交
    $('.search-form').find('input').keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search").click();
        }
    });
    </script>
    <script>
    window.console = window.console || {
        log: function() {}
    }
    seajs.use(['jquery'], function($) {

        $(function() {
            try {
                var dialog = top.dialog.get(window);
            } catch (e) {
                $('body').append(
                    '<p><strong>Error:</strong> 跨域无法无法操作 iframe 对象</p>' + '<p>chrome 浏览器本地会认为跨域，请使用 http 方式访问当前页面</p>'
                );
                return;
            };
            $("input[type='checkbox']").click(function() {
                if ($("input#select_type").val() == 2) {

                } else if ({
                        $mult
                    } != 1) {


                    if ($(this).prop("checked") == true) {
                        $("input[type='checkbox']").prop("checked", false);
                        $(this).prop("checked", true);
                    }

                }
            });
            dialog.title('楼盘选择');
            //dialog.width(800);
            dialog.height($(document).height());
            dialog.reset(); // 重置对话框位置
            var id_array = new Array();
            var title_array = new Array();
            $('#submit').on('click', function() {
                $('input[class="ids"]').each(function() {
                    if ($(this).prop("checked") == true) {
                        id_array.push($(this).val());
                        title_array.push($(this).attr('title'));
                    }
                });
                dialog.close(id_array.toString() + '|' + title_array.toString()); // 关闭（隐藏）对话框
                dialog.remove(); // 主动销毁对话框
                return false;
            });

            $('#back').on('click', function() {
                dialog.close(); // 关闭（隐藏）对话框
                dialog.remove(); // 主动销毁对话框
                return false;
            });


        });

    });
    </script>
</body>

</html>