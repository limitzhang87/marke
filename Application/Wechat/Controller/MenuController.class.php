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
namespace Wechat\Controller;
use Think\Controller;
/**
 * 登录控制器
 * 包括用户中心，用户登录及注册
 */
class MenuController extends Controller {

	public function _initialize()
	{
		/* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置
	}

	private $res = array('code'=>0,'msg'=>null,'data'=>null);
	public function get_menu()
	{
		$menu =  null;session('menu');
		if($menu == null){
			$user = D('user')->find(1);
			/**
	         * 将菜单和底部信息存入session
	         */
	        if($user['is_super'] == '1'){
	            /* 超级会员，从配置项中获取 */
	            $whereM['id']      = array('in', implode(',',  C('SUPER_MENU')));
	            $whereM['status'] = 1;
	            $menuList =  C('SUPER_MENU');

	            $morder = ' FIELD(id';
	            foreach ($menuList as $key => $value) {//Æ´½ÓÅÅÐò·½Ê½
	               $morder .=', ' . $value;
	            }
	            $morder .= ')';
	            $menu   = D('menu_list')->where($whereM)->order($morder)->field('title,path,icon')->select();
	            for ($i=0; $i < count($menu); $i++) {
	                $menu[$i]['icon'] = get_cover($menu[$i]['icon']);
	                $menu[$i]['path'] = U($menu[$i]['path'] );
	            }
	        }else{
	            /*普通会员，通过会员组获取*/
	            /**
	             * 1. 通过会员获取会员组。
	             * 2. 通过会员组获取菜单.
	             * 3. 提取有底部的菜单ID
	             */
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
	            for ($i=0; $i < count($menu); $i++) {
	                $menu[$i]['icon'] = get_cover($menu[$i]['icon']);
	            }
	        }
	        session('menu',$menu);
		}
		$this->res['data'] = $menu;
		$this->ajaxReturn($this->res);
	}



	public function get_bottom()
	{
		$bottom = session('bottom');
		if($bottom == null){
			$user = D('user')->find(1);
			/**
	         * 将菜单和底部信息存入session
	         */
	        if($user['is_super'] == '1'){
	            /* 超级会员，从配置项中获取 */
	            $whereB['bn.id'] = array('in', implode(',',  C('SUPER_BOTTOM')));
	            $whereB['ml.status'] = 1;
	            $bottomLlist = C('SUPER_BOTTOM');

	            $border = ' FIELD(bn.id';
	            foreach ($bottomLlist as $key => $value) {
	               $border .=', ' . $value;
	            }
	            $border .= ')';
	            $bottom  = D()->table('zf_bottom_nav as bn')
	                        ->where($whereB)
	                        ->limit(4)
	                        ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
	                        ->field('bn.title,bn.icon,ml.path')
	                        ->order($border)
	                        ->select();

	            for ($i=0; $i < count($bottom); $i++) {
	                $bottom[$i]['icon'] = get_cover($bottom[$i]['icon']);
	                $bottom[$i]['path'] = U($bottom[$i]['path']);
	            }
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
	            for ($i=0; $i < count($bottom); $i++) {
	                $bottom[$i]['icon'] = get_cover($bottom[$i]['icon']);
	            }
	        }
	        session('bottom');
		}
		$this->res['data'] = $bottom;
		$this->ajaxReturn($this->res);
	}
}
