<?php

namespace Addons\SyncLogin\Controller;
use Think\Hook;
use Userhome\Api\UserApi as UserApi;

use Home\Controller\AddonsController;


require_once(dirname(dirname(__FILE__))."/ThinkSDK/ThinkOauth.class.php");


class BaseController extends AddonsController{

    //登录地址
    public function login(){
        $type= I('get.type');
        empty($type) && $this->error('参数错误');
        //加载ThinkOauth类并实例化一个对象
        $sns  = \ThinkOauth::getInstance($type);
        //跳转到授权页面
        redirect($sns->getRequestCodeURL());
    }

    //登陆后回调地址
    public function callback(){
        $code =  I('get.code');
        $type= I('get.type');
        $login_user_type= I('get.login_user_type');
        $sns  = \ThinkOauth::getInstance($type);
		
        //腾讯微博需传递的额外参数
        $extend = null;
        if($type == 'tencent'){
            $extend = array('openid' => I('get.openid'), 'openkey' =>  I('get.openkey'));
        }

         $token = $sns->getAccessToken($code , $extend);
        $user_info = D('Addons://SyncLogin/SyncLogin')->$type($token); //获取传递回来的用户信息

       // $user_info = Array ( 'type' =>'QQ','name' => 'Lainergie113344','nick' => 'Lainergie223355','head' => 'http://q.qlogo.cn/qqapp/101302572/54FD9D74CEF31E593330022788A10C3C/100','sex' => '0' );
       // $token = Array ( 'access_token' => '097F707A07A37DDE7828AF29B2E50E43','expires_in' => '7776000','refresh_token' => '7BF8BFAECB11C368E9996962904D355B','openid' => '54FD9D74CEF31E593330022788A10C3C' );
      
        $condition = array(
            'openid' => $token['openid'],
            'type' => $type,
            'status' => 1,
        );
        $user_info_sync_login = D('sync_login')->where($condition)->find(); // 根据openid等参数查找同步登录表中的用户信息
        if($user_info_sync_login) {//曾经绑定过
            $user_info_user_center = D('uc_member')->find($user_info_sync_login ['uid']); 
			//根据UID查找Ucenter中是否有此用户
            if($user_info_user_center){
                $syncdata ['access_token'] = $token['access_token'];
                $syncdata ['refresh_token'] = $token['refresh_token'];
                D('sync_login')->where( array('uid' =>$user_info_user_center ['id'] ) )->save($syncdata); //更新Token
              //  $Member = D('uc_member');    
                if($this->login_user($user_info_user_center['uid'])){ //登录用户
              //  if( $Member->login($user_info_user_center['uid']) ){    
                  //  $this->assign('jumpUrl', U('Index/index'));
               //     $this->success('同步登录成功');  
                    $this->success('登录成功！',U('Usercenter/Index/information'));
                }
				else{
                    $this->error($Member->getError());
                }
            }
			else{
                $condition = array(
                    'openid' => $token['openid'],
                    'type' => $type
                );
                D('sync_login')->where($condition)->delete();
            }
        } else { //没绑定过，去注册
            $this->assign ( 'user', $user_info );
            $this->assign ( 'token', $token );
            $this->assign ( 'login_user_type', $login_user_type );
            $User = new UserApi;
            $now_time=time();
            $username=$user_info['name'].$now_time;
            $nickname=$user_info['nick'].$now_time;
            $password="123456";
            $email=$user_info['nick'].$now_time.'@zfangw.cn';
            $phone='';
          //  $this->redirect('Usercenter/user/register', array('token' => $token), 3, '页面跳转中...');EXIT;

           // $uid = $User->register($username, $nickname, $password);
           // $uid = $User->register($username, $nickname, $password, $email,$login_user_type,$login_user_type,$phone);
            
            $data = array(
            		'username' => $username,
            		'password' => think_ucenter_md5($password, UC_AUTH_KEY),
            		'email' => $email,
            		'status' => 1,
            		'user_import'=>$login_user_type,
            		'register_import'=>$login_user_type,
            );

            /* 添加用户 */

            		
            	$result = D('UcMember')->registerMember($nickname);
            
            	if ($result > 0) {
            		$data['id'] = $result;
            		$uid =  M('UchomeMember')->add($data);
            		
            		// $this->setDefaultGroup($uid);//设置默认用户组
            		$uid=$uid ? $uid : 0; //0-未知错误，大于0-注册成功
            	} 
            	
         
            if(0 < $uid){
            				//TODO: 发送验证邮件
            			  $data['uid'] = $uid;
                          $data['openid'] = $token['openid'];
                          $data['type'] = $type;
                          $data['status'] = 1;
                          $data['access_token'] = $token['access_token'];
                          M('sync_login')->add($data);
            				 /* 登录用户 */
            			//	$Member = D('Member');
            				if($this->login_user($uid)){ //登录用户
            					//TODO:跳转到登录前页面
            					$this->success('登录成功！',U('Usercenter/Index/information'));
            				}
            } else { //注册失败，跳转注册
            				$this->redirect('Usercenter/user/register', array('token' => $token), 3, '页面跳转中...');EXIT;
            				//echo $uid.$token['access_token'];
           }

      
            exit;


        }
    }
    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function login_user($uid, $remember = false)
    {
    	/* 检测是否在当前应用注册 */
    	$user = M('UcMember')->field(true)->find($uid);
    	if (1 != $user['status']) {
    		$this->error = '用户未激活或已禁用！'; //应用级别禁用
    		return false;
    	}
    	/* 登录用户 */
    	$this->autoLogin($user, $remember);
    
    
    	//记录行为
    	action_log('user_login', 'member', $uid, $uid);
    	return true;
    }
    
    /**
     * 注销当前用户
     * @return void
     */
    public function logout()
    {
    	session('user_auth', null);
    	session('user_auth_sign', null);
    	cookie('OX_LOGGED_USER', NULL);
    }
    
    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user, $remember = false)
    {
    	/* 更新登录信息 */
    	$data = array(
    			'uid' => $user['uid'],
    			'login' => array('exp', '`login`+1'),
    			'last_login_time' => NOW_TIME,
    			'last_login_ip' => get_client_ip(1),
    	);
    	M('UcMember')->save($data);
    
    	/* 记录登录SESSION和COOKIES */
//     	$auth = array(
//     			'uid' => $user['uid'],
//     			'username' => get_username($user['uid']),
//     			'last_login_time' => $user['last_login_time'],
//     	);
    	$uid=$user['uid'];
    	$username=M('uchome_member')->table("zf_uchome_member uch")->join('zf_uc_member uc ON uc.uid=uch.id')->where("uch.id='$uid'")->field('uc.nickname,uch.user_import,uc.user_type,uc.user_flag,register_import')->find();
    	
    	$auth = array(
    			'uid' => $user['uid'],
    			'nickname' => $username['nickname'],
    			'username'=>get_username($user['uid']),
    			'last_login_time' => $user['last_login_time'],
    			'user_import'=>$username['user_import'],
    			'user_type'=>$user['user_type'],
    			'user_flag'=>$username['user_flag'],
    			'register_import'=>$username['register_import'],
    	);
    	session('user_auth', $auth);
    	session('user_auth_sign', data_auth_sign($auth));
    	session("register_import",$username['register_import']);
    	if ($remember) {
    		$token = build_auth_key();
    		$user1 = D('user_token')->where('uid=' . $user['uid'])->find();
    		$data['token'] = $token;
    		$data['time'] = time();;
    		if ($user1 == null) {
    			$data['uid'] = $user['uid'];
    			D('user_token')->add($data);
    		} else {
    			D('user_token')->where('uid=' . $user['uid'])->save($data);
    		}
    	}
    
    	if (!$this->getCookieUid() && $remember) {
    		$expire = 3600 * 24 * 7;
    		cookie('OX_LOGGED_USER', $this->jiami($this->change() . ".{$user['uid']}.{$token}"), $expire);
    
    	}
    }
    
    public function need_login()
    {
    
    	if ($uid = $this->getCookieUid()) {
    		$this->login($uid);
    		return true;
    	}
    }
    
    public function getCookieUid()
    {
    	static $cookie_uid = null;
    	if (isset($cookie_uid) && $cookie_uid !== null) {
    		return $cookie_uid;
    	}
    	$cookie = cookie('OX_LOGGED_USER');
    	$cookie = explode(".", $this->jiemi($cookie));
    	$map['uid'] = $cookie[1];
    	$user = D('user_token')->where($map)->find();
    	$cookie_uid = ($cookie[0] != $this->change()) || ($cookie[2] != $user['token']) ? false : $cookie[1];
    	$cookie_uid = $user['time'] - time() >= 3600 * 24 * 7 ? false : $cookie_uid;
    	return $cookie_uid;
    }
    
    
    /**
     * 加密函数
     * @param string $txt 需加密的字符串
     * @param string $key 加密密钥，默认读取SECURE_CODE配置
     * @return string 加密后的字符串
     */
    public function jiami($txt, $key = null)
    {
    	empty($key) && $key = $this->change();
    
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    	$nh = rand(0, 64);
    	$ch = $chars[$nh];
    	$mdKey = md5($key . $ch);
    	$mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    	$txt = base64_encode($txt);
    	$tmp = '';
    	$i = 0;
    	$j = 0;
    	$k = 0;
    	for ($i = 0; $i < strlen($txt); $i++) {
    		$k = $k == strlen($mdKey) ? 0 : $k;
    		$j = ($nh + strpos($chars, $txt [$i]) + ord($mdKey[$k++])) % 64;
    		$tmp .= $chars[$j];
    	}
    	return $ch . $tmp;
    }
    /**
     * 解密函数
     * @param string $txt 待解密的字符串
     * @param string $key 解密密钥，默认读取SECURE_CODE配置
     * @return string 解密后的字符串
     */
    public function jiemi($txt, $key = null)
    {
    	empty($key) && $key = $this->change();
    
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    	$ch = $txt[0];
    	$nh = strpos($chars, $ch);
    	$mdKey = md5($key . $ch);
    	$mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    	$txt = substr($txt, 1);
    	$tmp = '';
    	$i = 0;
    	$j = 0;
    	$k = 0;
    	for ($i = 0; $i < strlen($txt); $i++) {
    		$k = $k == strlen($mdKey) ? 0 : $k;
    		$j = strpos($chars, $txt[$i]) - $nh - ord($mdKey[$k++]);
    		while ($j < 0) {
    			$j += 64;
    		}
    		$tmp .= $chars[$j];
    	}
    
    	return base64_decode($tmp);
    }
    private function change()
    {
    	preg_match_all('/\w/', C('DATA_AUTH_KEY'), $sss);
    	$str1 = '';
    	foreach ($sss[0] as $v) {
    		$str1 .= $v;
    	}
    	return $str1;
    }
    
    /**
     * 同步登陆时添加用户信息
     * @param $uid
     * @param $info
     * @return mixed
     * autor:xjw129xjt
     */
    public function addSyncData($uid, $info)
    {
    
    	$data1['nickname'] = mb_substr($info['nick'], 0, 11, 'utf-8');
    	//去除特殊字符。
    	$data1['nickname'] = preg_replace('/[^A-Za-z0-9_\x80-\xff\s\']/', '', $data1['nickname']);
    	empty($data1['nickname']) && $data1['nickname'] = $this->rand_nickname();
    	$data1['nickname'] .= '_' . $this->rand_nickname();
    	$data1['sex'] = $info['sex'];
    	$data = $this->create($data1);
    	$data['uid'] = $uid;
    	$res = $this->add($data);
    	return $res;
    }
    
    public function rand_nickname()
    {
    	$nickname = $this->create_rand(4);
    	if ($this->where(array('nickname' => $nickname))->select()) {
    		$this->rand_nickname();
    	} else {
    		return $nickname;
    	}
    }
    
    function create_rand($length = 8)
    {
    	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    	$password = '';
    	for ($i = 0; $i < $length; $i++) {
    		$password .= $chars[mt_rand(0, strlen($chars) - 1)];
    	}
    	return $password;
    }

}