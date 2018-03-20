<?php
/**
 * 认筹系统控制器
 *
 * 描述：      基类
 * 所属项目:   marke
 * 开发者:     张继贤
 * 创建时间:   2017/8/11 11:12 AM
 * 版权所有:   中房通(www.zfangw.cn)
 */

namespace Raise\Controller;
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
        $this->setDB();


        // if(!C('WEB_SITE_CLOSE')){
        //     $this->error('站点已经关闭，请稍后访问~');
        // }

        if (ismobile()) {//移动端
        	//设置默认默认主题为 Mobile
        	C('DEFAULT_THEME','mobile');
        }else{
        	//C('DEFAULT_THEME','mobile');//测试
        }

        $this->login();
        $this->assign('_title','商城');


        $info = D('houses_info')->find();
        $start_time = $info['start_time'];
        define(START_TIME,intval($start_time));
        $this->assign('start_time',$start_time);
    }


	/* 用户登录检测 */
	protected function login(){
        $user = session('raise');
        if (empty($user)) {
            $this->redirect('Login/index', array('id' => I('id'),'houses'=> I('houses') ));
            die;
        }
    }

    /**
     * 认筹系统选择数据库
     */
    private function setDB()
    {
        $houses = I('get.houses');
        if($houses){
            session('db_name', $houses);
        }
        $db_name = session('db_name');
        if(!$db_name){
            echo '抱歉！链接失效，请重新扫描二维码登录！';
            die;
        }
        C('db_name', $db_name);
    }

}
