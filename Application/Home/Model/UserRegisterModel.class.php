<?php
namespace Home\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class UserRegisterModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('password','think_ucenter_md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
        array('register_time','time',1,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );

    /*自动验证*/
    protected $_validate = array(
        array('phone', 'unique', '该手机号码的用户已经存在，不能在继续注册！',1,'unique'),
    );

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function login($phone, $password){
        /* 检测是否在当前应用注册 */
        $data['phone'] = $phone;
        $data['password'] = think_ucenter_md5($password);
        //think_ucenter_md5($password, UC_AUTH_KEY)
        $user = $this->field('id,phone,nick_name,houses_title')->where($data)->find();
        if(!$user){ //未注册
            $this->error = '密码错误';
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);

        //记录行为
        action_log('user_login', 'user', $uid, $uid);
        return true;
    }

        /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        session('user_temporary', $user);
    }
}
