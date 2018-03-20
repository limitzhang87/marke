<?php
/**
 * 登录控制器
 *
 * 描述：		用户登录
 * 所属项目:	marke
 * 开发者:		张继贤
 * 创建时间:	2017/8/9 11:12 AM
 * 版权所有:	中房通(www.zfangw.cn)
 */
namespace Home\Controller;

/**
 * 登录控制器
 * 包括用户中心，用户登录及注册
 */
class MenuController extends HomeController {

	public function _initialize()
	{
		
	}
	public function index()
	{
		echo 1;
	}

	public function get_menu()
	{
		$user = D('user')->find(1);
        dump($user);
		/**
         * 将菜单和底部信息存入session
         */
        if($user['is_super'] == '1'){
            /* 超级会员，从配置项中获取 */
            $whereM['id']      = array('in', implode(',',  C('SUPER_MENU')));
            $whereM['status'] = 1;
            $menuList =  C('SUPER_MENU');
            $whereB['bn.id'] = array('in', implode(',',  C('SUPER_BOTTOM')));
            $whereB['ml.status'] = 1;
            $bottomLlist = C('SUPER_BOTTOM');

            $morder = '';
            $border = ' FIELD(id';
            foreach ($menuList as $key => $value) {
               $border .=', ' . $value;
            }
            $border .= ')';
            $menu   = D('menu_list')->where($whereM)->order($whereM)->select();
            // FIELD(`id`, 2, 1)
            $border = ' FIELD(bn.id';
            foreach ($bottomLlist as $key => $value) {
               $border .=', ' . $value;
            }
            $border .= ')';
            $bottom  = D()->table('zf_bottom_nav as bn')
                        ->where($whereB)
                        ->limit(4)
                        ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                        ->field('bn.id,bn.title,bn.icon,ml.path')
                        ->order($border)
                        ->select();

            for ($i=0; $i < count($menu); $i++) {
                $menu[$i]['icon'] = get_cover($menu[$i]['icon']);
            }
            for ($i=0; $i < count($bottom); $i++) {
                $bottom[$i]['icon'] = get_cover($bottom[$i]['icon']);
            }
            session('menu',$menu);
            session('bottom', $bottom);
            session('group', NULL);
        }else{
            /*普通会员，通过会员组获取*/
            /**
             * 1. 通过会员获取会员组。
             * 2. 通过会员组获取菜单.
             * 3. 提取有底部的菜单ID
             */
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
                $orderM = 'ml.id asc';
            }else{
                $orderM = 'FIELD(ml.id,' . $group['menu_sort']. ')';
            }
            $menu =  D()
                    ->table('zf_menu_list as ml')
                    ->join('zf_group_menu as gm on ml.id = gm.m_id')
                    ->field('ml.id,ml.title,ml.path,ml.icon,gm.is_bottom')
                    ->where($whereM)
                    ->order($orderM)
                    ->select();
            foreach ($menu as $vo) {
                if($vo['is_bottom'] == '1'){
                    $Mids[] = $vo['id'];
                }
            }

            $whereB['bn.m_id'] = array('in',$Mids);
            $whereB['bn.status'] = 1;
            if( $group['bottom_sort'] == '' ){
                $orderB = 'bn.id asc';
            }else{
                 $orderB = 'FIELD(bn.id,' . $group['bottom_sort']. ')';
            }
            $bottom = D()
                    ->table('zf_bottom_nav as bn')
                    ->where($whereB)
                    ->limit(4)
                    ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                    ->field('bn.id,bn.title,bn.icon,ml.path')
                    ->order($orderB)
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
            session('menu',$menu);
            session('bottom', $bottom);
            session('group', $group);
        }

        dump($menu);
	}

}
