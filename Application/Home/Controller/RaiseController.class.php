<?php
/**
 * 认购控制器
 *
 * 描述：       公告
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/27 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;

class RaiseController extends HomeController {

    public function index()
    {
        if(!is_auth(AUTH_RAISE_MANAGE)){
            $this->redirect('lists');
        }
        $info = D('houses_info')->find();
        $this->assign('info',$info);
        $this->assign('_title','商城管理');
        $this->display();
    }

    /**
     * 商城详情
     * @return [type] [description]
     */
    public function houses_info()
    {
        if(IS_POST){
            $data = I('data');
            $data['start_time'] = strtotime($data['start_time']);
            if(!$data['start_time']){
                $this->error('请填写正确是开盘时间！');
                return;
            }
            if($data['id'] == ''){/*id 为空，增加*/
                unset($data['id']);
                if(D('houses_info')->add($data)){
                    $this->success('修改成功',U('index'));
                }else{
                    $this->error('修改失败');
                }
            }else{/*id不为空，修改*/
                if(D('houses_info')->save($data) !== false){
                    $this->success('修改成功',U('index'));
                }else{
                    $this->error('修改失败');
                }
            }
            return ;
        }
        $info = D('houses_info')->find();
        if($info['start_time'] == '' || $info['start_time'] ==  0 ){
            $info['start_time'] = strtotime('+5 day');
        }
        $this->assign('info',$info);
        $this->assign('_right_url', U('lists'));
        $this->display();
    }

    /**
     * 商城列表
     * @return [type] [description]
     */
    public function lists()
    {
        $page = I('page') ? I('page') : 1;
        if(I('kw')){
            $map['cus_name']   = array('like', '%'.I('kw').'%');
            $map['cus_phone']  = array('like','%'.I('kw').'%');
            $map['_logic']     ='or';
            $where['_complex'] = $map;
            $this->assign('kw',I('kw'));
        }

        //只能是本人或者是管理者获取数据
        if(!is_auth('AUTH_RAISE_MANAGE')){
            $where['uid'] = is_login();
        }

        $list = D('raise')->where($where)->field('id,cus_phone,cus_name,status,user_name,user_phone,created_time,raise_over')->limit(10)->page($page)->order('status asc,raise_over asc,created_time desc')->select();
        $count = D('raise')->where($where)->count();
        $this->assign('totalpage',intval($count/10)+1);
        $this->assign('list',$list);
        $this->assign('_title','认购列表');
        $this->display();
    }


    /**
     * 添加订单
     */
    public function add()
    {
        checkORredirect(is_auth(AUTH_RAISE_ADD));
        if(IS_POST){
            $data = I('raise');
            if(!$data){
                $this->error('添加失败！');
                return;
            }
            $where['cus_phone'] = $data['cus_phone'];
            if( D('raise')->where($where)->find()){
                $this->error('抱歉，该手机号码已经在本楼盘认购过');
                return;
            }

            $data['created_time'] = time();
            $data['uid'] = is_login();
            if(is_auth(AUTH_RAISE_MANAGE)){
                $data['status'] = 1;
                $data['check_id'] =  is_login();
            }
            if($id = D('raise')->add($data)){
                $this->success('添加成功',U('Raise/info',array('id'=>$id)));
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $this->assign('user', session('user_auth'));
        $this->assign('_title','添加认购');
        $this->assign('_right_url', U('lists'));
        $this->display();
    }

    /**
     * 订单详情
     * @return [type] [description]
     */
    public function info()
    {
        $id = I('id');
        checkORredirect($id);
        $info = D('raise')->find($id);

        //只能是本人或者是管理者获取数据
        if(!is_auth('AUTH_RAISE_MANAGE') &&session('user_auth.uid') != $info['uid']){
             $this->error('抱歉，您不是该客户的记录者！');
        }
        if($info['r_id'] != '' || $info['r_id'] != 0){
            $info['room'] = D()
                            ->table('zf_room as r')
                            ->join('zf_sameroom as sr on r.s_id = sr.id')
                            ->join('zf_unit as u on r.u_id = u.id')
                            ->join('zf_building as b on u.b_id = b.id')
                            ->field('r.id,r.room_number,r.floor,r.unit_price,r.usable_price,r.remark,r.status,u.u_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.orientation,b.b_name')
                            ->where('r.id=' . $info['r_id'])
                            ->find();
        }else{
            $info['room'] = null;
        }
        $this->assign('info',$info);
        $this->assign('url', U('Raise/Login/index',array('houses'=>C('db_name'),'id'=>$info['id'])));
        $this->assign('_title','认购详情');
        $this->assign('_right_url', U('lists'));
        $this->display();
    }

    /**
     * 审核
     * @return [type] [description]
     */
    public function check()
    {
        checkORredirect(is_auth(AUTH_RAISE_MANAGE));
        $id = I('id');
        checkORredirect($id);
        $data['id'] = $id;
        $data['status'] = 1;
        $data['check_id'] = is_login();
        if(D('raise')->save($data) !== false ){
            $this->success(1);
        }else{
            $this->error(1);
        }
    }


    /**
     * 发布消息或者公告
     */
    public function addBulletin()
    {
        $type = I('type');
        if(!$type){
            $type = 0;
        }else{
            $type = 1;
        }
        if(IS_POST){
            $data = I('post.');
            $data['created_time'] = time();
            if(D('raise_bulletin')->add($data)){
                $this->success('发布成功！',U('bulletinList',array('type'=>$type) ));
            }else{
                $this->error('发布失败！请重试');
            }
        }else{
            $title = $type == 1 ? '发布商城公告':'发布商城信息';
            $this->assign('_title',$title);
            $this->assign('_right_url',U('index'));
            $this->assign('type',$type);
            $this->display();
        }
    }

    public function editBulletin()
    {
        $id = I('id');
        checkORredirect($id, 'Raise/index');
        if(IS_POST){
            $data['id']           = I('id');
            $data['title']        = I('title');
            $data['content']      = I('content');
            $data['pictures']     = I('pictures');
            $data['file']         = I('file');
            $data['created_time'] = time();
            if(D('raise_bulletin')->save($data)){

                //找出删除掉了图片和文件id
                $oldPids = array_diff(explode(',', I('old_pictures')), explode(',', $data['pictures']));
                $oldFids = array_diff(explode(',', I('old_file')), explode(',', $data['file']));
                //删除图片和文件
                if($oldPids[0] != ''){
                    $whereP['id'] = array('in',$oldPids);
                    $pifDelete =  D('picture')->field('path')->where($whereP)->select();
                    foreach ($pifDelete as $pic) {
                        $path = '.' .$pic['path'];
                         unlink(trim($path));
                    }
                }
                if($oldFids[0] != ''){
                    $whereF['id'] = array('in',$oldFids);
                    $fileDelete =  D('file')->field('savepath,savename')->where($whereF)->select();
                    foreach ($fileDelete as $file) {
                        $path = './Uploads/Download/' . $file['savepath'] . $file['savename'] ;
                        unlink(trim($path));
                    }
                }
                $this->success('修改成功',U('bulletinInfo',array('id'=>$data['id'])));
            }else{
                $this->error('修改失败！');
            }
        }else{
            D('raise_bulletin')->where('id=' . $id)->setInc('view');
            $info = D('raise_bulletin')->find($id);
            $info['picturesA'] = ($info['pictures'] == '' || $info['pictures'] == 0 )?'': explode(',', $info['pictures']);
            $info['fileA']     = ($info['file'] == '' || $info['file'] == 0 )? '': explode(',', $info['file']);
            $this->assign('info', $info);
            $this->assign('_right_url',U('index'));
            $this->display();
        }
    }

    public function bulletinList()
    {
        $type = I('type') ? 1 : 0;
        $page = I('page') > 0 ? I('page') : 1;
        $list = D('raise_bulletin')
                ->limit('10')
                ->page($page)
                ->where(array('type'=>$type))
                ->order('created_time desc')
                ->select();
        $total = D('raise_bulletin')
                ->count();
        $this->assign('totalpage',intval($total/10)+1);
        $this->assign('_list', $list);
        $title = $type ? '商城公告列表' : '商城信息列表';
        $this->assign('_title',$title);
        $this->assign('_type' . $type,'page_on');
        $this->assign('type',$type);
        $this->assign('empty','<center>没有更多数据</center>');
        $this->display();
    }

    /**
     * 公告详情
     * @return [type] [description]
     */
    public function bulletinInfo()
    {
        $id = I('id');
        checkORredirect($id, 'Raise/index');
        D('raise_bulletin')->where('id=' . $id)->setInc('view');
        $info = D('raise_bulletin')->find($id);
        $info['pictures'] = ($info['pictures'] == '' || $info['pictures'] == 0 )?'': explode(',', $info['pictures']);
        $info['file']     = ($info['file'] == '' || $info['file'] == 0 )? '': explode(',', $info['file']);

        $this->assign('info', $info);
        $this->assign('_right_url',U('bulletinList',array('type'=>$info['type'])));
        $this->display();
    }

}
