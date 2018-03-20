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

class BusinessController extends HomeController {

    protected function _initialize(){
        parent::_initialize();
        //房间状态
        define('ROOM_STATUS_NSOLE',0);//未售
        define('ROOM_STATUS_SUBMIT',9);//已售
        define('ROOM_STATUS_LOCK',1);//锁定
        define('ROOM_STATUS_MARKETINCON',2);//销控
    }

    public function index()
    {
        $this->redirect('Business/lock');
    }

    /**
     * 锁定
     * @return [type] [description]
     */
    public function lock()
    {
        //checkORredirect(is_auth(AUTH_ROOM_LS),'Index/index');//判断当权用户是有拥审核权限

        if(I('page')){
            $page  = I('page');
        }else{
            $page = 1;
        }


        $where['r.status'] = ROOM_STATUS_LOCK;
        $where['r.lock_uid'] = is_login();

        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as user on r.lock_check_uid = user.id','LEFT')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,r.lock_time,u.u_order,b.b_name,user.nick_name as check_name')
                ->page($page)
                ->limit(8)
                ->order('r.lock_time desc')
                ->select();
        $count = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')

                ->count();
        $this->assign('_list',$room);
        $this->assign('on','lock');
        $this->assign('totalpage', intval($count/8)+1);
        $this->display();
    }


    /**
     * 提交
     * @return [type] [description]
     */
    public function submit()
    {
        if(I('page')){
            $page  = I('page');
        }else{
            $page = 1;
        }


        $where['r.status'] = ROOM_STATUS_SUBMIT;
        //$where['r.submit_uid'] = is_login();

        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as user on r.submit_check_uid = user.id','LEFT')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,r.submit_time,u.u_order,b.b_name,user.nick_name as check_name')
                ->page($page)
                ->limit(8)
                ->order('r.submit_time desc')
                ->select();
        $count = D()
                ->table('zf_room as r')
                ->where($where)
                ->count();
        $this->assign('_list',$room);
        $this->assign('on','submit');
        $this->assign('totalpage', intval($count/8)+1);
        $this->display();
    }


    /**
     * 我的锁定审核
     * @return [type] [description]
     */
    public function myLCheck()
    {
        checkORredirect(is_auth(AUTH_ROOM_CHECK));//判断当权用户是有拥审核权限
        // $where['r.status'] = array('in' , ROOM_STATUS_LOCK. ',' . ROOM_STATUS_SUBMIT);
        // $where['r.is_check'] = 0;
        $where['r.status'] = array('in' , ROOM_STATUS_LOCK. ',' . ROOM_STATUS_SUBMIT);
        $where['r.lock_check_uid'] = is_login();
        $page = I('page') ? I('page') : 1;
        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as userL on r.lock_uid=userL.id','LEFT')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,u.u_order,b.b_name,userL.nick_name')
                ->page($page)
                ->limit(8)
                ->select();
        $count = D()
                ->table('zf_room as r')
                ->where($where)
                ->count();
        $this->assign('_list',$room);
        $this->assign('on','myLCheck');
        $this->assign('totalpage', intval($count/8)+1);
        $this->display('myCheck');
    }

    /**
     * 我的成交审核
     * @return [type] [description]
     */
    public function mySCheck()
    {
        checkORredirect(is_auth(AUTH_ROOM_CHECK));//判断当权用户是有拥审核权限
        // $where['r.status'] = array('in' , ROOM_STATUS_LOCK. ',' . ROOM_STATUS_SUBMIT);
        // $where['r.is_check'] = 0;
        $where['r.status'] = array('in' , ROOM_STATUS_LOCK. ',' . ROOM_STATUS_SUBMIT);
        $where['r.submit_check_uid'] = is_login();
        $page = I('page') ? I('page') : 1;
        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as userL on r.submit_uid=userL.id','LEFT')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,u.u_order,b.b_name,userL.nick_name')
                ->page($page)
                ->limit(8)
                ->select();
        $count = D()
                ->table('zf_room as r')
                ->where($where)
                ->count();
        $this->assign('_list',$room);
        $this->assign('on','mySCheck');
        $this->assign('totalpage', intval($count/8)+1);
        $this->display('myCheck');
    }
    /**
     * 等待审核
     * @return [type] [description]
     */
    public function tocheck()
    {
        checkORredirect(is_auth(AUTH_ROOM_CHECK));//判断当权用户是有拥审核权限
        $where['r.status'] = array('in' , ROOM_STATUS_LOCK. ',' . ROOM_STATUS_SUBMIT);
        $where['r.is_check'] = 0;
        $page = I('page') ? I('page') : 1;
        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as user on r.lastop_uid = user.id')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,u.u_order,b.b_name,user.nick_name')
                ->page($page)
                ->limit(10)
                ->order('id desc')
                ->select();
        $count = D()
                ->table('zf_room as r')
                ->where($where)
                ->count();
        $this->assign('_list',$room);
        $this->assign('on','tocheck');
        $this->assign('totalpage', intval($count/8)+1);
        $this->display();
    }


    /**
     * AJAX获取数据
     * @return [type] [description]
     */
    public function getList()
    {
        // /checkORredirect(IS_AJAX);//判断当权用户是有拥审核权限
        // $where['operationer'] = is_login();
        // $where['status'] = I('status');
        // $list = D('room')->where($where)->select();


        if(I('Noperationer') != '1'){
            //不需要需要查找操作人,审核专用
            $where['r.operationer'] = is_login();
        }
        if(I('page')){
            $page  = I('page');
        }else{
            $page = 1;
        }

        if(I('status') != '' || !empty(I('status'))){
            $where['r.status'] = array('in',I('status'));
        }
        if(I('is_check')!= '' )  {
             $where['r.is_check'] = I('is_check') ;
        }
        //$where['r.is_check'] == 0;
        //$this->success($where);

        $room = D()
                ->table('zf_room as r')
                ->where($where)
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as user on r.operationer = user.id')
                ->field('r.id,r.room_number,r.status,r.is_check,u.u_name,u.u_order,b.b_name')
                ->page($page)
                ->limit(10)
                ->order('r.op_time desc')
                ->select();
        if(empty($room)){
            $this->error($room);
        }else{
            $this->success($room);
        }
    }
}
