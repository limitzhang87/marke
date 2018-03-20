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
use User\Api\UserApi;

/**
 * 登录控制器
 * 包括用户中心，用户登录及注册
 */
class LoginController extends HomeController {


	protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }

        if (ismobile()) {//移动端
        	//设置默认默认主题为 Mobile
        	C('DEFAULT_THEME','mobile');
        }else{
        	//C('DEFAULT_THEME','mobile');//测试
        }
    }

	/* 注册页面 */
	public function register(){
        // if(!C('USER_ALLOW_REGISTER')){
        //     $this->error('注册已关闭');
        // }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			// if(!check_verify($verify)){
			// 	$this->error('验证码输入错误！');
			// }

			$code      = I('code');
			$phone     = I('phone');
			$nick_name = I('nick_name');
			$password  = I('password');
			/**
			 * 注册流程
			 * 	1. 首先判断邀请码是否可用；
			 * 	2. 判断用户的手机是否注册过
			 * 	3. 注册新用户，设置为超级会员，返回用户id;
			 * 	4. 更新邀请码的状态
			 */
			//1. 首先判断邀请码是否可用；
			$wheres['code'] = $code;
			$wheres['status'] = 0;//还没有注册过
			$wheres['houses_id'] = array('gt',0);//已经绑定楼盘
			$super = D('super_code')->where($wheres)->field('id,houses_id')->find();
			if(empty($super)){
				$this->error('错误的邀请码！');
			}
			unset($wheres);

			//2. 判断用户的手机是否注册过
			$whereu['phone'] = $phone;
			//$whereu['is_super'] = 1;
			$user = D('user')->where($whereu)->find();
			if(!empty($user)){
				$this->error('该手机号已经注册！');
			}
			//3. 注册新用户，设置为超级会员，返回用户id;
			$datau['phone'] = $phone;
			$datau['nick_name'] = $nick_name;
			$datau['password'] = $password;
			$datau['is_super'] = 1;
			$datau['is_activation'] = 1;
			if(D('user')->create($datau)){
				$uid = D('user')->add();
				if(!$uid){
					$this->error('注册失败！');
				}
			}else{
				$this->error('注册失败！');
				return ;
			}
			unset($datau);
			//4. 更新邀请码的状态
			$datas['id'] = $super['id'];
			$datas['act_time'] = time();
			$datas['uid'] = $uid;
			$datas['status'] = 1;


			if(D('super_code')->save($datas)){
				$this->createGroup($super['houses_id']);//超级会员完成注册，添加默认的会员组
				$this->success('注册成功！');
			}else{
				$this->error('注册失败！');
			}
		} else { //显示注册表单
			$this->display();
		}
	}


	/**
	 * 登陆界面
	 * @return [type] [description]
	 */
	public function login()
	{
		if(IS_AJAX){
            // $verifynum = I('verifynum');
            // $Verify = new \Think\Verify();
            //if($Verify->check($verifynum)){
            $res['error'] = 1;
            $res['msg'] = '';
            if(1){
                if(I('type') == 'login'){
					$phone    = I('phone');
					$password = I('password');
					if(D('user')->login($phone, $password)){
						$res['error'] = 0;
					}else{
						$res['error'] = 1;
            			$res['msg'] = D('user')->getError();
					}
                }else{
                    $res['error'] = 1;
            		$res['msg'] = '非法登录';
                }
            }else{
                $res['error'] = 1;
            	$res['msg'] = '2';
            }
            $this->ajaxReturn($res);
            return ;
        }
       	checkORredirect(!is_login());//如果已经登录，怎不用显示登录界面
        $this->display('login');
	}

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			D('user')->logout();
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
		}
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
			case -9:  $error = '手机格式不正确！'; break;
			case -10: $error = '手机被禁止注册！'; break;
			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}


    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login') );
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');

            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与确认密码不一致');
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid, $password, $data);
            if($res['status']){
                $this->success('修改密码成功！');
            }else{
                $this->error($res['info']);
            }
        }else{
            $this->display();
        }
    }

    /**
     * 超级会员初次注册的时候，为其创建几个分组
     * @return [type] [description]
     */
    protected function createGroup($houses_id)
    {
    	$data = C('DEFAULT_GROUP');
        $groupData =array();
        $GMData = array();
        foreach ($data as $vo) {
        	$groupData = array();
			$groupData['houses_id']   = $houses_id;
			$groupData['name']        = $vo['name'];
			$groupData['bg_color']    = $vo['bg_color'];
			$groupData['remark']      = $vo['remark'];
			$groupData['menu_sort']   = $vo['menu_sort'];
			$groupData['bottom_sort'] = $vo['bottom_sort'];

			$id = D('group')->add($groupData);
			foreach ($vo['group_menu'] as $value) {
				$tmp = array();
				$tmp['g_id']      = $id;
				$tmp['m_id']      = $value['m_id'];
				$tmp['is_bottom'] = $value['is_bottom'];
				$tmp['m_auth']    = $value['m_auth'];
				$GMData[] = $tmp;
			}
        }
        if(D('group_menu')->addAll($GMData)){
        	return true;
        }else{
        	return false;
        }

    }


}
