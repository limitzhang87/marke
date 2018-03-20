<?php
/**
 * 楼盘相册
 *
 * 描述：       管理楼盘相册
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/25 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Raise\Controller;

class HousesImgController extends HomeController {

    public function index()
    {
        $page = I('page')? 1:I('page');

        $list = D()
                ->table('zf_houses_img hi')
                ->where($where)
                ->join('zf_picture as p on hi.cover_id=p.id')
                ->limit(10)
                ->page($page)
                ->field('p.id,p.path')
                ->select();
        $this->assign('list', $list);
        $config['url'] =  $_SERVER['HTTP_HOST'] . U('Share/houses_img',array('houses'=>session('db_name'),'id'=>$id));
        //'http://www.zfangw.net/index.php?s=Home/share/ownership_pic_show' . '/id/' .$id;
        $config['title'] = getHouses('title') . '楼盘图片';
        $config['desc'] = $user['nick_name'] .'为你分享了'. getHouses('title') . '楼盘图片';
        $config['img'] = 'http://www.zfangw.net' . $path;
        $config['img_title'] =  getHouses('title') . '楼盘图片';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->display();
    }
}
