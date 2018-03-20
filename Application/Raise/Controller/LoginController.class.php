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

namespace Raise\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class LoginController extends Controller {

    protected function _initialize(){
    	$this->setDB();
    	$config = api('Config/lists');
        C($config); //添加配置

        if (ismobile()) {//移动端
        	//设置默认默认主题为 Mobile
        	C('DEFAULT_THEME','mobile');
        }else{
        	//C('DEFAULT_THEME','mobile');//测试
        }

    }

	public function index()
	{
		$this->assign('id',I('id'));
        $this->assign('houses', I('houses'));

        $this->assign('agreement',D('houses_info')->field('agreement')->find() );
        $this->display();
	}

	public function login($value='')
	{
		if(IS_AJAX){
			$houses = I('houses');
			if(session('db_name') != $houses){
				$this->error('系统出错！请重新扫描二维码登录！');
			}
			$where['id'] = I('id');
			//$where['cus_phone'] = I('cus_phone');
			if($info = D('raise')->where($where)->find()){
				if($info['cus_phone'] == I('cus_phone')){
					session('raise',$info);
					$this->success('登录成功！');
				}else{
					$this->error('请使用自己的认筹号码和二维码登录!');
				}
			}else{
				$this->error('此手机未认筹注册!');
			}
		}
	}


	/* 退出登录 */
	public function logout(){
		if(session('raise')){
			session('raise',null);
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
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
