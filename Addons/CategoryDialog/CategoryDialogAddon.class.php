<?php

namespace Addons\CategoryDialog;
use Common\Controller\Addon;

/**
 * 楼盘弹出搜索页面插件
 * @author 崔
 */

    class CategoryDialogAddon extends Addon{

        public $info = array(
            'name'=>'CategoryDialog',
            'title'=>'分类弹出选择页面',
            'description'=>'分类弹出选择页面',
            'status'=>1,
            'author'=>'崔',
            'version'=>'0.1'
        );

        public function install(){
        	/* 先判断插件需要的钩子是否存在 */
        	$this->getisHook('Category_select', $this->info['name'], $this->info['description']);
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
        //实现的钩子方法
        public function Category_select($param){
	        if(isset($param['Category_id'])){
	            $map['id'] = array('eq', $param['Category_id']);    
	            $data= M('Category')->field('title')->where($map)->find();
	            $this->assign('Category_title', $data['title']);
	        }
        	$this->assign('param', $param);
        	if($param['type']==2){
        		$this->display('CategoryPost');
        	}else if($param['type']==3){
        		$this->display('CategoryHome');
        	}else{
        		$this->display('CategoryDialog');
        	}
        	
        }

    }