<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => '>PMXRj*tApdF^rOuE8:S~<`$q6f.=H4)-V9K{Qc[', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    //'DB_NAME'   => 'project', // 数据库名
    'DB_NAME'   => 'marke', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123456',  // 密码 服务器密码//f06a624474
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'zf_', // 数据库表前缀

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),

    //'DB_DSN' =>'mysql://zhang:123456@120.24.92.182:3306/wandacheng#utf8',

    'SMS'   => array(
        'AppKey'       => '95282a483c5446c1b0a5b1c4629cf73e',
        'AppSecret'    => '43b7898ee996',
        'templateid_1' =>'3120057',
    ),
);
