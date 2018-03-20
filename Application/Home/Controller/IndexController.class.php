<?php
/**
 * 行为日志控制器
 *
 * 描述：      用户登录
 * 所属项目:    marke
 * 开发者:     张继贤
 * 创建时间:    2017/7/24 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
        //超级会员获取楼盘ID
        $temp = getMenu();
        for($i = 0;$i< count($temp); $i++){
            $menu[floor($i/8)][] = $temp[$i];
        }
        $this->assign('_menu', $menu);
        $this->display();
    }

    public function index2()
    {
    	$this->display();
    }

    public function demo()
    {
        $id = I('id');
        if($id == ''){
            $this->display('demo');
        }else{
            $this->display('demo_' . $id);
        }
    }





    public function text()
    {
        /**
         * 1. 通过会员获取会员组。
         * 2. 通过会员组获取菜单
         */
        $user = session('user_auth');
        $where['gu.uid'] = $user['uid'];
            $group = D()
                    ->table('zf_group as g')
                    ->join('zf_group_user as gu on g.id = gu.g_id')
                    ->field('g.*')
                    ->where($where)
                    ->find();
            $whereM['gm.g_id'] = $group['id'];
            $whereM['ml.status'] = 1;
            if( $group['menu_sort'] == '' ){
                $orderM = 'ml.id desc';
            }else{
                 $orderM = 'FIELD(ml.id,' . $group['menu_sort']. ')';
            }
            $menu =  D()
                    ->table('zf_menu_list as ml')
                    ->join('zf_group_menu as gm on ml.id = gm.m_id')
                    ->field('ml.id,ml.title,ml.path,ml.icon,gm.is_bottom')
                    ->where($whereM)
                    //->order($orderM)
                    ->select();

            foreach ($menu as $vo) {
                if($vo['is_bottom'] == '1'){
                    $Mids[] = $vo['id'];
                }
            }

            $whereB['bn.m_id'] = array('in',$Mids);
            $whereB['bn.status'] = 1;
            $orderB = 'FIELD(bn.id,' . $group['bottom_sort']. ')';
            $bottom = D()
                    ->table('zf_bottom_nav as bn')
                    ->where($whereB)
                    ->limit(4)
                    ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                    ->field('bn.id,bn.title,bn.icon,ml.path')
                    ->order('ml.id')
                    ->select();
            // dump($group);
            // dump($menu);
            // dump($bottom);
            for ($i=0; $i < count($menu); $i++) {
                $menu[$i]['icon'] = get_cover($menu[$i]['icon']);
            }
            for ($i=0; $i < count($bottom); $i++) {
                $bottom[$i]['icon'] = get_cover($bottom[$i]['icon']);
            }
            // session('menu',$menu);
            // session('bottom', $bottom);
            // session('group', $group);
        //dump($group);
        dump($menu);
        dump($bottom);
        //dump(session('user_auth'));
        // session('menu',$menu);
        // session('bottom', $bottom);
        // session('group', $group);
    }

}