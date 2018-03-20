<?php
/**
 * 业务控制器
 *
 * 描述：       业务
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/8/10 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;
use Think\Controller;

class TemporaryController extends Controller {
	public function _initialize()
	{
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

        $user = session('user_temporary');
        if (empty($user)) {
            redirect(U('Login/login'));
        }
	}

    public function index()
    {
        $info = session('user_temporary');
        $info = D('user_register')->where($info)->find();
        $this->assign('info', $info);
        $this->assign('_title', '中房通');
        $this->display();
    }

    /**
     * 注册人员通过短信获取系列号
     * @return [type] [description]
     */
    public function getCode()
    {
        /**
         * 将系列号发送给用户
         */
        $info = D('user_register')->find(I('id'));
        $this->success($info );
    }

    /**
     * 会员输入系列号完成激活
     * @return [type] [description]
     */
    public function activation()
    {
        if(IS_AJAX){
            $id = I('id');
            $code = I('code');
            /**
             * 激活帐号
             * 1. 根据id和系列号判断这条user_register是否存在
             * 2. 根据客户的数据在user表中创建一条用户数据
             * 3. 将客户的id更新好super_code中
             * 4. 取消session,跳转到登录界面
             */

            /* 1. 根据id和系列号判断这条user_register是否存在 */
            $where['id'] = $id;
            $where['code'] = $code;
            $user = D('user_register')->where($where)->find();
            if(!$user){
                $this->error('系列号错误！');
            }
            unset($where);
            /* 2. 根据客户的数据在user表中创建一条用户数据 */
            $data['phone'] = $user['phone'];
            $data['password'] = $user['password'];
            $data['nick_name'] =$user['nick_name'];
            $data['is_super'] = 1;
            $data['created_time'] = $user['register_time'];
            $data['head_img'] = './Public/Mobile/images/icon/head_img_m.png';
            if(D('user')->where('phone=' . $data['phone'])->count()){
                $this->error('该手机号码已注册过！');
            }
            $uid = D('user')->add($data);
            if(!$uid){
                $this->error('激活失败！');
            }

            /* 3. 将客户的id更新好super_code中 */
            $where['code'] = $code;
            $super_code = D('super_code')->where($where)->field('id')->find();
            if(!$super_code ){
                $this->error('激活失败！');
            }
            unset($data);
            $data['id'] = $super_code['id'];
            $data['status'] = 1;
            $data['act_time'] = time();
            $data['uid'] = $uid;
            if(!D('super_code')->save($data)){
                $this->error('激活失败！');
            }
            $this->createGroup();//超级会员完成注册，添加默认的会员组
            /* 4. 取消session,跳转到登录界面 */
            session('user_temporary',null);
            $this->success('激活成功');
        }
    }

    /**
     * 超级会员初次注册的时候，为其创建几个分组
     * @return [type] [description]
     */
    protected function createGroup()
    {
        $data = C('DEFAULT_GROUP');
        $groupData =array();
        $GMData = array();
        foreach ($data as $vo) {
            $groupData = array();
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
