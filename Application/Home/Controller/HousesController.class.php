<?php
/**
 * 楼盘管理控制器  
 *
 * 描述：       楼盘管理
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/1311:12 AM
 * 版权所有:    中房通(www.zfangw.net)
 */
namespace Home\Controller;

class HousesController extends HomeController {

    public function index()
    {
        $id     =   1;
        $data = D('houses')->find($id);
        if(empty($data)){
            $data['title'] = '未设置名称';
            D('houses')->add($data);
        }
        $this->assign('data',$data);
        $this->display();
    }


    public function edit()
    {
        checkORredirect( is_auth(AUTH_HOUSE_MANAGE));
        if(IS_POST){
            $id = 1;
            $data['id']                 = $id;
            $data['title']              = I('title');
            $data['description']        = I('description');
            $data['address']            = I('address');
            $data['openingtime']        = I('openingtime');
            $data['openingtime_remark'] = I('openingtime_remark');
            $data['launchtime']         = I('launchtime');
            $data['launchtime_remark']  = I('launchtime_remark');
            $data['areacovered']        = I('areacovered');
            $data['plotratio']          = I('plotratio');
            $data['greeningrate']       = I('greeningrate');
            $data['mcompany']           = I('mcompany');
            $data['developer']          = I('developer');
            $data['salepermit']         = I('salepermit');
            $data['salesaddress']       = I('salesaddress');
            if(D('houses')->save($data) !== false){
                $dataM['title'] = $data['title'];
                //M('main','zf_','mysql://root:f06a624474@localhost:3306/project')->where(array('db_name'=>changeDB()))->save($dataM);
                M('main','zf_','mysql://root:123456@localhost:3306/project')->where(array('db_name'=>changeDB()))->save($dataM);
                session('title',$data['title']);
                $this->success('修改成功！',U('index'));
            }else{
                $this->error('修改失败');
            }
            return;
        }else{
            $id     =  1;
            $attribute = get_model_attribute(12);
            $data = D('houses')->find($id);
            foreach ($attribute as $value) {
                $fields = $value;
            }
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->assign('id',$id);
            $this->display();
        }
    }
}

