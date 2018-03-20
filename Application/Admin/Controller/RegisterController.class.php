<?php
/**
 * 后台审核管理客户注册控制器
 *
 * 描述：      后台审核管理客户注册控制器
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/10/10 15:40
 * 版权所有:    中房通(www.zfangw.net)
 */

namespace Admin\Controller;


class RegisterController extends AdminController {

    /**
     * 待审核的用户信息
     * @return [type] [description]
     */
    public function index()
    {
        $map = array('is_check'=>0);
        $list = $this->lists('user_register',$map);

        $this->assign('_list', $list);
        //dump($list);die;
        $this->meta_title = '注册审核';
        $this->display();
    }

     /**
     * 已经审核了
     * @return [type] [description]
     */
    public function newlist()
    {
        $map = array('is_check'=>1);
        $list = $this->lists('user_register',$map);

        $this->assign('_list', $list);
        //dump($list);die;
        $this->meta_title = '注册审核';
        $this->display();
    }



    /**
     * 审核，绑定系列号，生成楼盘
     * @return [type] [description]
     */
    public function bind()
    {
        // if(IS_POST){
        //     $list = I('ids');
        // }else{
        //     $list[] = I('id');
        // }
        if(IS_POST){
            /**
             * 审核步骤
             * 1. 为其新建一个新的楼盘，楼盘中只有楼盘标题数据，返回楼盘ID
             * 2. 将系列号填写到数据库spuer_code中，并绑定楼盘
             * 3. 首先客户的信息修改完整，包裹is_check,check_time,houses_id
             */
            $id           = I('id');
            $code         = I('code');
            $houses_title = I('houses_title');
            if($id == ''|| $code == ''){
                $this->error('审核失败，请刷新重试！1');
            }

            $dataH['title'] = $houses_title;
            $houses_id = D('houses')->add($dataH);
            if(!$houses_id){
                $this->error('审核失败，请刷新重试！2');
            }

            $dataS['code']         = $code;
            $dataS['houses_id']    = $houses_id;
            $dataS['houses_title'] = $houses_title;
            $dataS['status']       = 0;

            $dataR['id']         = $id;
            $dataR['is_check']   = 1;
            $dataR['houses_id']  = $houses_id;
            $dataR['code']       = $code;
            $dataR['check_time'] = time();
            if(D('super_code')->add($dataS) && D('user_register')->save($dataR)){
                $this->success('审核成功！',U('Register/index'));
            }else{
                $this->error('审核失败，请刷新重试！');
            }
            return;
        }
        $id = I('id');
        $info= D('user_register')->find($id);

        $this->assign('info',$info);
        $this->meta_title = '楼盘绑定';
        $this->display();
    }


    /**
     * 生成临时的系列号，还不能使用
     * @return [type] [description]
     */
    public function createCode()
    {
        if(IS_AJAX){
            if( I('type') != 'create' ){
                $this->error('系列号生成失败！');
            }
            $code = 'zfw' . date('Ymd') . time() . rand(0,9);
            $this->success($code);
        }
    }

    /**
     * 创建超级会员并绑定系列号
     */
    public function add()
    {
        if (IS_POST){
            $data['code']          = I('code');
            $data['houses_title']  = I('houses_title');
            $data['sld']           = I('sld') . '.zfangw.net';
            $data['db_name']           = I('sld');
            $data['is_check']      = 1;
            $data['register_time'] = time();
            $data['check_time']    = time();
            if(D('user_register')->add($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
            return ;
        }
        $this->display();
    }
}
