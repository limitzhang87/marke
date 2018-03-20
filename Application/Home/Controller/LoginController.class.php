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
use User\Api\UserApi;

/**
 * 登录控制器
 * 包括用户中心，用户登录及注册
 */
class LoginController extends HomeController {


	protected function _initialize(){
		/* 改变数据库 */
		changeDB();

        if (ismobile()) {//移动端
        	//设置默认默认主题为 Mobile
        	C('DEFAULT_THEME','mobile');
        }else{
        	//C('DEFAULT_THEME','mobile');//测试
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
            if(I('type') == 'login'){
				$phone    = I('phone');
				$password = I('password');
				$db_name = I('houses');
				session('db_name', $db_name);
				changeDB();
				if(D('user')->login($phone, $password)){
					$res['error'] = 0;
				}
            }else{
                $res['error'] = 1;
        		$res['msg'] = '非法登录';
            }
            $this->ajaxReturn($res);
            return ;
        }
       	checkORredirect(!is_login());//如果已经登录，怎不用显示登录界面
        $this->display('login');
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
			 * 1. 跟主网站的验证码判断是否正确
			 * 2. 在主网站中更新项目信息
			 * 3. 在住网站中添加用户信息
			 * 4. 在本身数据库中进行注册
			 */
			/* 1. 跟主网站的验证码判断是否正确 */
			$where['code'] = trim($code);
			$where['status'] = 0;
			$res = D()->table('project.zf_main')->where($where)->find();
			if(!$res){
				$this->error('系列号错误');
			}
			/* 2. 在主网站中更新项目信息 */
			$res['phone'] = $phone;
			$res['nick_name'] = $nick_name;
			$res['status'] = 1;
			D()->table('project.zf_main')->save($res);
			/* 3. 在住网站中添加用户信息 */
			addUserall($res['id'],$phone);
			/* 4.在本身数据库中进行注册 */
			$hosuesD['title'] = $res['title'];
			M()->execute("truncate table " . $res['db_name'] . '.zf_houses');
			D('houses')->table($res['db_name'] . '.zf_houses')->add($hosuesD);


			$datau['phone']         = $phone;
			$datau['nick_name']     = $nick_name;
			$datau['password']      = think_ucenter_md5($password);
			$datau['is_super']      = 1;
			$datau['is_activation'] = 1;
			$datau['head_img']      = './Public/Mobile/images/icon/head_img_m.png';
			$datau['created_time']  = time();
			$datau['updated_time']  = time();
			$datau['sex']           = 0;

			M()->execute("truncate table " . $res['db_name'] . '.zf_user');
			$uid =D('user')->table($res['db_name'] . '.zf_user')->add($datau);
			if(!$uid){
				$this->error('注册失败！');
			}else{
				$this->createGroup($res['db_name']);//超级会员完成注册，添加默认的会员组
				$this->success('注册成功！');
			}
		} else { //显示注册表单
			$this->display();
		}
	}
	/* 注册页面 */
	public function register_new(){
        // if(!C('USER_ALLOW_REGISTER')){
        //     $this->error('注册已关闭');
        // }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			// if(!check_verify($verify)){
			// 	$this->error('验证码输入错误！');
			// }

			$houses_title = I('houses_title');
			$phone        = I('phone');
			$nick_name    = I('nick_name');
			$password     = I('password');
			/**
			 * 注册流程
			 * 	1. 首先判断手机号码是否已经注册过
			 */
			//1. 判断用户的手机是否注册过
			$whereu['phone'] = $phone;
			//$whereu['is_super'] = 1;
			$user = D('user')->where($whereu)->find();
			if(!empty($user)){
				$this->error('该手机号已经注册！');
			}
			$datau['houses_title'] = $houses_title;
			$datau['phone'] = $phone;
			$datau['nick_name'] = $nick_name;
			$datau['password'] = $password;
			if(D('user_register')->create($datau)){
				$uid = D('user_register')->add();
				if(!$uid){
					$this->error('注册失败！'. D('user_register')->getError());
				}else{
					$this->success('注册成功');
				}
			}else{
				$this->error('注册失败！' . D('user_register')->getError());
				return ;
			}
		} else { //显示注册表单
			$this->display();
		}
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
	 * 获取楼盘名称
	 * @return [type] [description]
	 */
	public function getHouse()
	{
		if (IS_AJAX) {
			$phone = I('phone');
			/* 如果项目放到别的服务器上面，这个模型需要重新设置链接条件*/
			$list = D()
					->table('project.zf_userall as u')
					->join('project.zf_main as m on u.m_id = m.id')
					->where('u.phone=' . $phone)
					->field('m.title,m.db_name')
					->select();
			$this->success($list);
		}
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
    protected function createGroup($db_name)
    {
    	$data = C('DEFAULT_GROUP');
        $groupData =array();
        $GMData = array();
        M()->execute("truncate table " . $db_name . '.zf_group');
        M()->execute("truncate table " . $db_name . '.zf_group_menu');
        foreach ($data as $vo) {
        	$groupData = array();
			$groupData['name']        = $vo['name'];
			$groupData['bg_color']    = $vo['bg_color'];
			$groupData['remark']      = $vo['remark'];
			$groupData['menu_sort']   = $vo['menu_sort'];
			$groupData['bottom_sort'] = $vo['bottom_sort'];
			$id = D('group')->table($db_name . '.zf_group')->add($groupData);
			foreach ($vo['group_menu'] as $value) {
				$tmp = array();
				$tmp['g_id']      = $id;
				$tmp['m_id']      = $value['m_id'];
				$tmp['is_bottom'] = $value['is_bottom'];
				$tmp['m_auth']    = $value['m_auth'];
				$GMData[] = $tmp;
			}
        }
        if(D('group_menu')->table($db_name . '.zf_group_menu')->addAll($GMData)){
        	return true;
        }else{
        	return false;
        }
    }

}
