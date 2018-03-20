<?php
/**
 * 楼盘动态
 *
 * 描述：       楼盘动态
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/25 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Raise\Controller;

class HousesNewController extends HomeController {

    public function index()
    {
        $page = I('page')? 1:I('page');

        $list = D('houses_new')->where($where)->limit(10)->page($page)->field('id,title,created_time,view')->select();
        $this->assign('list', $list);
        $this->display();
    }

    public function info()
    {
        $id = I('id');
        $info = D('houses_new')->find($id);
        $info['content'] = htmlspecialchars_decode($info['content']);
         D('houses_new')->where('id=' . $id)->setInc('view');
        $this->assign('info', $info);
        $this->display();
    }
}
