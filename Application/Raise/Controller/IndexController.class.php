<?php
/**
 * 认筹基类控制器
 *
 * 描述：      基类
 * 所属项目:   marke
 * 开发者:     张继贤
 * 创建时间:   2017/9/27 11:12 AM
 * 版权所有:   中房通(www.zfangw.cn)
 */

namespace Raise\Controller;
use Think\Controller;

/**
 * 认筹公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class IndexController extends HomeController {



    public function index()
    {
        $this->display();
    }

}
