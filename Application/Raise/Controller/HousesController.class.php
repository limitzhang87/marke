<?php
/**
 * 楼盘管理控制器  
 *
 * 描述：       楼盘管理
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/1311:12 AM
 * 版权所有:    中房通(www.zfangw.net)
 */
namespace Raise\Controller;

class HousesController extends HomeController {

    public function index()
    {
        $id     =   1;
        $data = D('houses')->find($id);
        if(empty($data)){
            $data['title'] = '未设置名称';
            D('houses')->add($data);
        }
        $this->assign('data',$data);
        $this->display();
    }
}

