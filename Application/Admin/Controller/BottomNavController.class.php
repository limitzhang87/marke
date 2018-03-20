<?php
/**
 * 行为日志控制器
 *
 * 描述：      后台菜单控制器
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/7/21 15:40
 * 版权所有:    中房通(www.zfangw.net)
 */

namespace Admin\Controller;


class BottomNavController extends AdminController {

    /**
     * 菜单列表也
     * @return [type] [description]
     */
    public function index(){

        $title       =   I('title');
        $map['bn.status']  =   array("egt","0");
        if(is_numeric($title)){
            $map['bn.id|bn.title']=   array(intval($title),array('like','%'.$title.'%'),'_multi'=>true);
        }else{
            $map['bn.title']    =   array('like', '%'.(string)$title.'%');
        }
        $p = I('p') ? I('p') : 0;
        //$list   = $this->lists('menu_list', $map,'id desc');
        $list = D()->table('zf_bottom_nav as bn')
                    ->where($map)->limit($p . ',' . (C('LIST_ROWS') > 0 ?C('LIST_ROWS') :10))
                    ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                    ->field('bn.id,bn.title,bn.icon,bn.status,ml.path')
                    ->order('id desc')
                    ->select();
        $this->assign('_list', $list);
        $this->meta_title = '底部公共栏列表';
        $this->display();
    }




    public function del($model = '7', $ids=null){
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');

        $ids = array_unique((array)I('ids',0));

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }

        $Model = M(get_table_name($model['id']));
        $map = array('id' => array('in', $ids) );
        if($Model->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }


    /**
     * 从菜单列表跳转到修改页面
     * @param  string  $model 模型ID
     * @param  integer $id    ID
     * @return [type]         [description]
     * @author ZHANG 
     */
    public function set($model = '8', $id = 0){
        $m_id = I('m_id');
        $m_id || $this->error('没有选择菜单！');
        //获取模型信息
        $table = $model;
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息
            //$Model  =   $this->checkAttr($Model,$model['id']);
            $data['m_id']   = I('m_id');
            $data['title']  = I('title');
            $data['icon']   = I('icon');
            $data['id']     = I('id');
            $data['status'] = I('status');

            //没有ID，第一次存储
            if($data['id'] == ''  || empty($data['id'])){
                if($Model->add($data)){
                    $this->success('保存'.$model['title'].'成功！', U('MenuList/index'));
                } else {
                    $this->error($Model->getError());
                }
                return ;
            }

            if($Model->save($data)){
                $this->success('保存'.$model['title'].'成功！', U('MenuList/index'));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields     = get_model_attribute($model['id']);
            //获取数据
            $data       = M(get_table_name($model['id']))->where('m_id='.$m_id)->find();
            //$data || $this->error('数据不存在！');
            $data['m_id'] = $m_id;
            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->meta_title = '编辑'.$model['title'];
            $this->display($model['template_edit']?$model['template_edit']:'');
        }
    }


    /**
     * 从底部列表跳转到修改页面
     * @param  string  $model 模型ID
     * @param  integer $id    ID
     * @return [type]         [description]
     * @author ZHANG 
     */
    public function edit($model = '8', $id = 0){
        //获取模型信息
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息 
            
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create() && ( $Model->save() == false || $Model->save() == 0 ) ){
                $this->success('保存'.$model['title'].'成功！', U('index'));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields     = get_model_attribute($model['id']);

            //获取数据
            $data       = M(get_table_name($model['id']))->find($id);
            $data || $this->error('数据不存在！');

            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->meta_title = '编辑'.$model['title'];
            $this->display($model['template_edit']?$model['template_edit']:'');
        }
    }

        /**
     * 改变状态
     */
    public function changeStatus(){
        $model  = 'bottom_nav';
        $ids    = I('request.ids');
        $status = I('get.status');

        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map['id'] = array('in',$ids);
        switch ($status){
            case -1 :
                $this->delete($model, $map, array('success'=>'删除成功','error'=>'删除失败'));
                break;
            case 0  :
                $this->forbid($model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
                break;
            case 1  :
                $this->resume($model, $map, array('success'=>'启用成功','error'=>'启用失败'));
                break;
            default :
                $this->error('参数错误');
                break;
        }
    }


   protected function checkAttr($Model,$model_id){
        $fields     =   get_model_attribute($model_id,false);
        $validate   =   $auto   =   array();
        foreach($fields as $key=>$attr){
            if($attr['is_must']){// 必填字段
                $validate[]  =  array($attr['name'],'require',$attr['title'].'必须!');
            }
            // 自动验证规则
            if(!empty($attr['validate_rule'])) {
                $validate[]  =  array($attr['name'],$attr['validate_rule'],$attr['error_info']?$attr['error_info']:$attr['title'].'验证错误',0,$attr['validate_type'],$attr['validate_time']);
            }
            // 自动完成规则
            if(!empty($attr['auto_rule'])) {
                $auto[]  =  array($attr['name'],$attr['auto_rule'],$attr['auto_time'],$attr['auto_type']);
            }elseif('checkbox'==$attr['type']){ // 多选型
                $auto[] =   array($attr['name'],'arr2str',3,'function');
            }elseif('datetime' == $attr['type']){ // 日期型
                $auto[] =   array($attr['name'],'strtotime',3,'function');
            }
        }
        return $Model->validate($validate)->auto($auto);
    }

}
