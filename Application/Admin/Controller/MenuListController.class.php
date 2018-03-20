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


class MenuListController extends AdminController {

    /**
     * 菜单列表也
     * @return [type] [description]
     */
    public function index(){

        $title       =   I('title');

        $map['ml.status']  =   array("egt","0");
        if(is_numeric($title)){
            $map['ml.id|ml.title']=   array(intval($title),array('like','%'.$title.'%'),'_multi'=>true);
        }else{
            $map['ml.title']    =   array('like', '%'.(string)$title.'%');
        }
        $p = I('p') ? I('p') : 0;
        //$list   = $this->lists('menu_list', $map,'id desc');
        $list = D('menu_list')->table('zf_menu_list as ml')
                    ->where($map)
                    ->join('zf_bottom_nav  as bn on ml.id = bn.m_id','LEFT')
                    ->field('ml.id,ml.title,ml.path,ml.icon,ml.status,bn.status as bstatus')
                    ->order('id desc')
                    ->relation(true)
                    ->select();
        $this->assign('_list', $list);
        $this->meta_title = '菜单列表';
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

    public function edit($model = '7', $id = 0){
        //获取模型信息
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息 
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create() && $Model->save()){
                $this->success('保存'.$model['title'].'成功！', U('index?model='.$model['name']));
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

    public function add($model = '7'){
        //获取模型信息
        $model = M('Model')->where(array('status' => 1))->find($model);
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息 
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create() && $Model->add()){
                $this->success('添加'.$model['title'].'成功！', U('index'));
            } else {
                $this->error($Model->getError());
            }
        } else {

            $fields = get_model_attribute($model['id']);

            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->meta_title = '新增'.$model['title'];
            $this->display($model['template_add']?$model['template_add']:'');
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


    /**
     * 改变状态
     */
    public function changeStatus(){
        $model  = 'menu_list';
        $ids    = I('request.ids');
        $status = I('get.status');

        if(empty($ids)){
            $this->error('请选择   要操作的数据');
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


    /**
     * 菜单权限
     * @author zhang
     * @return [type] [description]
     */
    public function menu_auth()
    {
        $data['m_id']  =  I('m_id');
        if(IS_AJAX){
            if( I('id') == '' || empty(I('id'))){
                $num = 0;
            }else{
                 $num = count(I('id'));
            }
            $tonum = count(I('title'));
            for($i = 0; $i<$num;$i++){
                $data_save[$i]['id']      = I('id')[$i];
                $data_save[$i]['title']   = I('title')[$i];
                $data_save[$i]['is_auth'] = I('is_auth')[$i];
            }
            $i = 0;
            for($j = $num;$j<$tonum; $j++){
                if(I('title')[$j] != ''){
                    $data_add[$i]['title']   = I('title')[$j];
                    $data_add[$i]['is_auth'] = I('is_auth')[$j];
                    $data_add[$i]['m_id']    = $data['m_id'];
                    $i++;
                }
            }
            if(!empty($data_save) || $data_save != ''){
                $result = D('menu_auth')->saveAll($data_save);
                if($result == false && $result  != 0){
                    $this->error('权限设置失败！1');
                }
            }

            if(!empty($data_add) || $data_add != ''){
                if(!D('menu_auth')->addAll($data_add)){
                    $this->error('权限设置失败！2');
                }
            }

            $this->success('权限设置成功！', U('MenuList/index'));
        }
        $title = D('menu_list')->field('title')->find($m_id);
        $title = $title['title'];
        $list = D('menu_auth')->where($data)->select();
        $this->assign('m_id',  $data['m_id']);
        $this->assign('list', $list);
        $this->assign('title',$title);
        $this->meta_title = '编辑' . $title. '权限';
        $this->display();
    }

    public function del_auth()
    {
        if(IS_AJAX){
            $id = I('id');
            if(D('menu_auth')->delete($id)){
                $this->ajaxReturn(1);
            }else{
                 $this->ajaxReturn(0);
            }
        }
    }


    public function text()
    {
        $data_save[0]['id'] = 1;
        $data_save[0]['title'] = '编辑';
        $data_save[0]['is_auth'] = 1;
        $data_save[1]['id'] = 2;
        $data_save[1]['title'] = '修改22';
        $data_save[1]['is_auth'] = 1;
    }
}
