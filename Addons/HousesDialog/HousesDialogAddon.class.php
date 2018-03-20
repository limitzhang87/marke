<?php

namespace Addons\HousesDialog;
use Common\Controller\Addon;

/**
 * 楼盘弹出搜索页面插件
 * @author 崔
 */

    class HousesDialogAddon extends Addon{

        public $info = array(
            'name'=>'HousesDialog',
            'title'=>'楼盘弹出搜索页面',
            'description'=>'楼盘弹出搜索页面',
            'status'=>1,
            'author'=>'崔',
            'version'=>'0.1'
        );

        /**
         * 安装钩子
         * @return [type] [description]
         */
        public function install(){
        	/* 先判断插件需要的钩子是否存在 */
        	$this->getisHook('Houses_select', $this->info['name'], $this->info['description']);
            return true;
        }
        //获取插件所需的钩子是否存在
        public function getisHook($str, $addons, $msg=''){
        	$hook_mod = M('Hooks');
        	$where['name'] = $str;
        	$gethook = $hook_mod->where($where)->find();
        	if(!$gethook || empty($gethook) || !is_array($gethook)){
        		$data['name'] = $str;
        		$data['description'] = $msg;
        		$data['type'] = 1;
        		$data['update_time'] = NOW_TIME;
        		$data['addons'] = $addons;
        		if( false !== $hook_mod->create($data) ){
        			$hook_mod->add();
        		}
        	}
        }
        public function uninstall(){
            return true;
        }
        //实现的Hoses_select钩子方法
        public function Houses_select($param){
 			$title="";
	        if(isset($param['houses_id'])){
	        	if($param['select_type']==2){
	        		$arr=explode(',',$param['houses_id']);
	        		for($i=0;$i<count($arr);$i++){
	        			$map['id'] = array('eq', $arr[$i]);
	        			//$data= M('document')->field('title')->where($map)->find();
                        $data= D()->db(1,"mysql://zhang:123456@120.24.92.182:3306/zfw")->table('zf_document')->field('title')->where($map)->find();          //
	        			$title=$title." ".$data['title'];
	        		}
	        	}else{
	        		$map['id'] = array('eq', $param['houses_id']);
	        		//$data= M('document')->field('title')->where($map)->find();
                    $data= D()->db(1,"mysql://zhang:123456@120.24.92.182:3306/zfw")->table('zf_document')->field('title')->where($map)->find();
	        		$title=$title.$data['title'];
	        	}
	        }
            
	        $this->assign('houses_title', $title);
        	$this->assign('param', $param);
        	$this->display('HousesDialog');
        }

    }