<?php
/**
 * 邀请码序列号控制器
 *
 * 描述：      邀请码序列号控制器
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/8/23 15:40
 * 版权所有:    中房通(www.zfangw.net)
 */

/**
 * 2017-10-12   该功能暂停使用
 */
namespace Admin\Controller;


class SuperCodeController extends AdminController {

    /**
     * 已完成注册邀请码列表
     * @return [type] [description]
     */
    public function index()
    {
        $map = array('status'=>1,'houses_id'=>array('gt',0));
        $list = $this->lists('super_code',$map);

        $this->assign('_list', $list);
        //dump($list);die;
        $this->meta_title = '邀请码';
        $this->display();
    }

    /**
     * 已经绑定楼盘的邀请码列表
     * @return [type] [description]
     */
    public function house()
    {
        $map = array('status'=>0,'houses_id'=>array('gt',0),'uid'=>0);
        $list = $this->lists('super_code',$map,'','','id,code,status,houses_id,houses_title');

        $this->assign('_list', $list);
        //dump($list);die;
        $this->meta_title = '邀请码';
        $this->display();
    }

     /**
     * 还未添加楼盘的邀请码列表
     * @return [type] [description]
     */
    public function newlist()
    {
        $map = array('status'=>0,'houses_id'=>0);
        $list = $this->lists('super_code',$map,'','','id,code,status');
        //int_to_string($list);

        $this->assign('_list', $list);
        //dump($list);die;
        $this->meta_title = '邀请码';
        $this->display();
    }

    /**
     * 邀请码生成
     * @return [type] [description]
     */
    public function createCode()
    {
        if(IS_POST){
            $num = intval(I('num'));
            if($num <= 0){
                $this->error('输入错误！');
            }
            if($num >= 100){
                 $this->error('数量过大，请重新输入！');
            }
            $last = D('super_code')->max('code');
            $last = intval($last);
            $data = array();
            for ($i = 1; $i <= $num; $i++) {
                $data[]['code'] = str_pad($last + $i, 6, '0', STR_PAD_LEFT) ;
            }

            if(empty($data)){
                 $this->error('添加失败！');
            }else{
                if(D('super_code')->addAll($data)){
                     $this->success('添加邀请码成功！',U('SuperCode/newlist'));
                }else{
                    $this->error('添加失败！');
                }
            }
        }else{
            $this->meta_title = '邀请码';
            $this->display();
        }
    }

    /**
     * [bind description]
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
            $data['id'] = I('id');
            $data['houses_id'] = I('houses_id');
            $data['houses_title'] = I('houses_title');

            if($data['id'] == '' || $data['houses_id'] =="" ){
                $this->error('绑定失败！');
            }
            if(D('super_code')->save($data)){
                $this->success('绑定成功！',U('newlist'));
            }else{
                $this->error('绑定失败！');
            }
            return ;
        }
        $id = I('id');
        $list[] = D('super_code')->find($id);
        $this->assign('_list',$list);
        $this->display();
    }
}
