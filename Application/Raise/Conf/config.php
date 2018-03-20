<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.thinkphp.cn>
// +----------------------------------------------------------------------

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array(

    'SHOW_PAGE_TRACE' =>false, //关闭页面执行信息trace
    // 预先加载的标签库
    'TAGLIB_PRE_LOAD'     =>    'OT\\TagLib\\Article,OT\\TagLib\\Think',
        
    /* 主题设置 */
    'DEFAULT_THEME' =>  'default',  // 默认模板主题名称

    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX' => 'onethink_', // 缓存前缀
    'DATA_CACHE_TYPE'   => 'File', // 数据缓存类型

    /* 文件上传相关配置 */
    'DOWNLOAD_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Download/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //下载模型上传配置（文件上传类配置）

    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
            'mimes'    => '', //允许上传的文件MiMe类型
            'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
            'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
            'autoSub'  => true, //自动子目录保存文件
            'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath' => './Uploads/Picture/', //保存根路径
            'savePath' => '', //保存路径
            'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            'saveExt'  => '', //文件保存后缀，空则使用原后缀
            'replace'  => false, //存在同名是否覆盖
            'hash'     => true, //是否生成hash编码
            'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    
    /* 编辑器图片上传相关配置 */
    'EDITOR_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Editor/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ),

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',

        '__MIMG__'    => __ROOT__ . '/Public/Mobile/images',
        '__MCSS__'    => __ROOT__ . '/Public/Mobile/css',
        '__MJS__'     => __ROOT__ . '/Public/Mobile/js',
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'onethink_home', //session前缀
    'COOKIE_PREFIX'  => 'onethink_home_', // Cookie前缀 避免冲突

    /**
     * 附件相关配置
     * 附件是规划在插件中的，所以附件的配置暂时写到这里
     * 后期会移动到数据库进行管理
     */
    'ATTACHMENT_DEFAULT' => array(
        'is_upload'     => true,
        'allow_type'    => '0,1,2', //允许的附件类型 (0-目录，1-外链，2-文件)
        'driver'        => 'Local', //上传驱动
        'driver_config' => null, //驱动配置
    ), //附件默认配置

    'ATTACHMENT_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Attachment/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //附件上传配置（文件上传类配置）

    'DEFAULT_GROUP' => array(
        '置业顾问' => array(
            'name'        => '置业顾问',
            'bg_color'    => '#1ff4e4',
            'remark'      => '',
            'menu_sort'   => '3,10,4,9,8,12',
            'bottom_sort' => '4,3',
            'group_menu'  => array(
                '房源列表' => array(
                    'm_id' => '3',
                    'is_bottom' =>'',
                    'm_auth' => '1',
                ),
                '我的业务' => array(
                    'm_id' => '10',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '置业计划' => array(
                    'm_id' => '4',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '内部群' => array(
                    'm_id' => '9',
                    'is_bottom' =>'',
                    'm_auth' => '',
                ),
                '公告' => array(
                    'm_id' => '8',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '个人中心' => array(
                    'm_id' => '12',
                    'is_bottom' =>'',//默认是底部了
                    'm_auth' => '',
                ),
            ),
        ),

        '案场管理' => array(
            'name'        => '案场管理',
            'bg_color'    => '#1ff4e4',
            'remark'      => '',
            'menu_sort'   => '3,10,13,4,7,9,11,12',
            'bottom_sort' => '4,3',
            'group_menu'  => array(
                '房源列表' => array(
                    'm_id' => '3',
                    'is_bottom' =>'',
                    'm_auth' => '1,3',
                ),
                '我的业务' => array(
                    'm_id' => '10',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '分销管理' => array(
                    'm_id' => '13',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '置业计划' => array(
                    'm_id' => '4',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '公告管理' => array(
                    'm_id' => '7',
                    'is_bottom' =>'1',
                    'm_auth' => '5',
                ),
                '内部群' => array(
                    'm_id' => '9',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '统计报表' => array(
                    'm_id' => '11',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '个人中心' => array(
                    'm_id' => '12',
                    'is_bottom' =>'',
                    'm_auth' => '',
                ),
            ),
        ),

        '分销系统' => array(
            'name'        => '分销系统',
            'bg_color'    => '#1ff4e4',
            'remark'      => '',
            'menu_sort'   => '3,10,5,4,14,12',
            'bottom_sort' => '',
            'group_menu'  => array(
                '房源列表' => array(
                    'm_id' => '3',
                    'is_bottom' =>'',
                    'm_auth' => '1',
                ),
                '客户报备' => array(
                    'm_id' => '10',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '楼盘信息' => array(
                    'm_id' => '5',
                    'is_bottom' =>'',
                    'm_auth' => '',
                ),
                '置业计划' => array(
                    'm_id' => '4',
                    'is_bottom' =>'',
                    'm_auth' => '',
                ),
                '分销公告' => array(
                    'm_id' => '14',
                    'is_bottom' =>'1',
                    'm_auth' => '',
                ),
                '个人中心' => array(
                    'm_id' => '12',
                    'is_bottom' =>'',
                    'm_auth' => '',
                ),
            ),
        ),

    ),
);
