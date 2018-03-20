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
namespace Wechat\Controller;

class HousesController extends HomeController {
    protected $connection = 'mysql://zhang:123456@120.24.92.182:3306/zf';

    public function index()
    {
        $id     =   getHouse();
        $houses = M('Document','zf_', $this->connection)->field('title,description,cover_id')->find($id);
        // $sql = 'select address,housefeature,renovation,hcategory,areacovered,plotratio,greeningrate,openingtime,launchtime,mcompany,housetype,developer,salepermit,salesaddress,projectweb,content from zf_document_download where id=' . $id;

        $res = M('document_download','zf_',$this->connection)->field('address,housefeature,renovation,hcategory,areacovered,plotratio,greeningrate,openingtime,openingtime_remark,launchtime,launchtime_remark,mcompany,housetype,developer,salepermit,salesaddress,content')->find($id);
        $data = array_merge($houses, $res);
        //$data.housefeature|get_checkbox="HOUSE_HOUSEFEATURE",###
        //dump( get_checkbox('HOUSE_HOUSEFEATURE',$data['housefeature']) );die;
        $this->assign('data',$data);
        $this->display();
    }


    public function edit()
    {
        checkORredirect( is_auth(AUTH_HOUSE_MANAGE));
        if(IS_POST){
            $id = I('id');
            if($id != getHouse()){
                $this->error('修改出错！');
            }
            $data1['id'] = $id;
            $data1['title']       = I('title');
            $data1['description'] = I('description');

            $data2['id'] = getHouse();
            $data2['address']            = I('address');
            $data2['openingtime']        = I('openingtime');
            $data2['openingtime_remark'] = I('openingtime_remark');
            $data2['launchtime']         = I('launchtime');
            $data2['launchtime_remark']  = I('launchtime_remark');
            $data2['areacovered']        = I('areacovered');
            $data2['plotratio']          = I('plotratio');
            $data2['greeningrate']       = I('greeningrate');
            $data2['mcompany']           = I('mcompany');
            $data2['developer']          = I('developer');
            $data2['salepermit']         = I('salepermit');
            $data2['salesaddress']       = I('salesaddress');
            $data2['housefeature']       = I('housefeature');
            $data2['renovation']         = I('renovation');
            $data2['hcategory']          = I('hcategory');
            $data2['housetype']          = I('housetype');
            foreach ($data2 as $key => $vo) {
                if(is_array($vo)){
                    $data2[$key] = implode(',', $vo);
                }
            }
            if( M('Document','zf_', $this->connection)->save($data1) !== false &&  M('document_download','zf_', $this->connection)->save($data2) !== false){
                $this->success('修改成功！',U('index'));
            }else{
                $this->error('修改失败');
            }
            return;
        }else{
            $field = 'address,openingtime,openingtime_remark,launchtime,launchtime_remark,areacovered,plotratio,greeningrate,mcompany,developer,salepermit,salesaddress,housefeature,renovation,hcategory,housetype';
            $where1['model_id'] = 1;
            $where1['name'] = array('in', 'title,description');
            $field1  = M('attribute','zf_', $this->connection)->where($where1)->select();

            $where2['model_id'] = 3;
            $where2['name'] = array('in', $field);
            $temp = explode(',',$field);
            for ($i = 0; $i < count($temp); $i++) {
                $temp[$i] = '"' . $temp[$i] . '"';
            }
            $order = implode(',',$temp);
            $field2 = M('attribute','zf_', $this->connection)->where($where2)->order('FIELD(`name`,'.$order.')')->select();
            $fields = array_merge($field1,$field2);
            $id     =   getHouse();
            $data1  = M('Document','zf_', $this->connection)->field('title,description')->find($id);
            $data2  = M('document_download','zf_', $this->connection)->field($field)->find($id);
            $data = array_merge($data1,$data2);
            //dump($fields);dump($data);die;
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->assign('id',$id);
            $this->display();
        }
    }
}

