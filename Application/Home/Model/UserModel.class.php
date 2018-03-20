<?php
namespace Home\Model;
use Think\Model;
use Home\Model\BaseModel;

/**
 * 文档基础模型
 */
class UserModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('password','think_ucenter_md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
        array('head_img','./Public/Mobile/images/icon/head_img_m.png'), // 默认头像地址
        array('created_time','time',1,'function'), // 对update_time字段在更新的时候写入当前时间戳
        array('updated_time','time',3,'function'), // 对update_time字段在更新的时候写入当前时间戳
        array('sex','0'),
        //array('is_activation','0'),
        array('status','1')
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
        $user = $this->field('id as uid,phone,nick_name,head_img,is_super,sex,is_activation,is_activation,status')->where($data)->find();
        if(!$user){ //未注册
            $this->error = '密码错误';
            return false;
        }elseif ($user['status'] != '1') {
            $this->error = '该用户已被禁用';
            return false;
        }

        $this->remember($data);
        /* 登录用户 */
        $this->autoLogin($user);

        //记录行为
        //ction_log('user_login', 'user', $uid, $uid);
        return true;
    }

    //自动登录
    public function remember_login()
    {
        /* 检测是否在当前应用注册 */
        $data = cookie('user_login');
        $db_name = cookie('db_name');
        if($data == null || $db_name == null){
            return false;
        }
        //think_ucenter_md5($password, UC_AUTH_KEY)
        session('db_name',$db_name);
        $user = D()->table($db_name .'.zf_user')->field('id as uid,phone,nick_name,head_img,is_super,sex,is_activation,is_activation,status')->where($data)->find();
        if(!$user){ //未注册
            $this->error = '密码错误';
            return false;
        }elseif ($user['status'] != '1') {
            $this->error = '该用户已被禁用';
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);
        //记录行为
        //action_log('user_login', 'user', $uid, $uid);
        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session(null);
        cookie(null);
    }
    //记住密码
    private function remember($data){
        $remember  = I('remember');
        $db_name = session('db_name');
        if($remember && $db_name){//记住密码
            cookie('user_login',$data,array('expire'=>86400) );//保存账户密码cookie
            cookie('db_name',$db_name,array('expire'=>86400) );//保存账户密码cookie
        }
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        if($user['head_img'] == '' || empty($user['head_img'])){
            if($user['sex'] == 2){
                $user['head_img'] = './Public/Mobile/images/icon/head_img_w.png';
            }else{
                $user['head_img'] = './Public/Mobile/images/icon/head_img_m.png';
            }
        }
        session('user_auth', $user);
        session('user_auth_sign', data_auth_sign($user));
        /**
         * 将菜单和底部信息存入session
         */
        if($user['is_super'] == '1'){
            /* 超级会员，从配置项中获取 */
            /* 读取站点配置 */
            $config = api('Config/lists');
            C($config); //添加配置
            $whereM['id']      = array('in', implode(',',  C('SUPER_MENU')));
            $whereM['status'] = 1;
            $menuList =  C('SUPER_MENU');
            $whereB['bn.id'] = array('in', implode(',',  C('SUPER_BOTTOM')));
            $whereB['ml.status'] = 1;
            $bottomLlist = C('SUPER_BOTTOM');

            $morder = '';
            $morder = ' FIELD(id';
            foreach ($menuList as $key => $value) {//Æ´½ÓÅÅÐò·½Ê½
               $morder .=', ' . $value;
            }
            $morder .= ')';
            $menu   = D('menu_list')->where($whereM)->order($morder)->select();

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
            if($Mids == null){
                $Mids = '';
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
    }

}
