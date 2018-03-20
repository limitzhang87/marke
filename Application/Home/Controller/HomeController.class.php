<?php
/**
 * 前台基类控制器
 *
 * 描述：      基类
 * 所属项目:   marke
 * 开发者:     张继贤
 * 创建时间:   2017/8/11 11:12 AM
 * 版权所有:   中房通(www.zfangw.cn)
 */

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}


    protected function _initialize(){
        /* 切换数据库 */
        changeDB();
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }

        $this->assign('houses',getDB());
        if (ismobile()) {//移动端
        	//设置默认默认主题为 Mobile
        	C('DEFAULT_THEME','mobile');
        }else{
        	//C('DEFAULT_THEME','mobile');//测试
        }

        $this->login();
        $this->assign('_title',  getHouses('title'));

        $bottom = getBottom();
        $this->assign('_bottom', $bottom);
        $this->assign('_bottom_w', floor(100/(count($bottom)+2)) . '%'  );

        $this->assign('_right_url', U('Index/index'));
        $this->assign('_right_type', 'background: url(\'./Public/Mobile/images/icon/r_index2_icon.png\') no-repeat;');


        $group = session('group');
        if($group['bg_color']=='' || empty($group['bg_color'])){
            $group['bg_color'] = 'rgb(255, 60, 0)';
        }
        $this->assign('bg_color',$group['bg_color']);

        $uid = session('user_auth.uid');
        $this->assign('uid',$uid);

        /**
         * 权限设置，在后台中查找查看并添加
         */
        define('AUTH_ROOM_LS',1);//房间锁定和成交的权限
        define('AUTH_ROOM_CHECK',3);//房间审核的权限
        define('AUTH_ROOM_MARKETINCON',4);//房间销控的权限
        define('AUTH_ROOM_MANAGE',5);//房源管理的权限

        define('AUTH_GROUP_MANAGE',6);//分组管理
        define('AUTH_BULL_MANAGE',7);//公告管理权限

        define('AUTH_REPORT_MANAGE',8);//报表查看

        define('AUTH_USER_MANAGE', 10);//用户管理
        define('AUTH_HOUSE_MANAGE',11);//楼盘信息管理
        define('AUTH_HOUSESIMG_UPLOAD',12);//图片上传
        define('AUTH_HOUSESNEW_MANAGE',13);//认筹添加

        define('AUTH_RAISE_ADD',14);//认筹添加
        define('AUTH_RAISE_MANAGE',15);//认筹管理审核

        define('AUTH_CUSTOMER_ADD',16);//合同添加
        define('AUTH_CUSTOMER_MANAGE',17);//合同管理

        define('AUTH_TRACK_ADD',18);//客户跟踪添加
        define('AUTH_TRACK_MANAGE',19);//客户跟踪管理

        define('AUTH_BBORDER_ADD',20);//报备订单添加
        define('AUTH_BBORDER_MANAGE',21);//报备订单调度
        define('AUTH_BBORDER_RECEICE', 22);//接待

    }


	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		//is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));

        //首先判断用户是否已经登录，如果没有就获取cookie登录，如果不行就转到登录界面
        is_login() || remmember_login() || is_temporary()|| $this->redirect('Login/login');
	}

}
