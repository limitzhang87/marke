<?php

namespace Addons\Collection;
use Common\Controller\Addon;

/**
 * 采集插件
 * @author 崔
 */

    class CollectionAddon extends Addon{

        public $info = array(
            'name'=>'Collection',
            'title'=>'采集',
            'description'=>'采集',
            'status'=>1,
            'author'=>'崔',
            'version'=>'0.1'
        );

        public $admin_list = array(
            'model'=>'collectionNode',		//要查的表
			'fields'=>'*',			//要查的字段
			'map'=>'',				//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order'=>'sort desc,nodeid desc',		//排序,
			'listKey'=>array( 		//这里定义的是除了id序号外的表格里字段显示的表头名
				'title'=>'标题',
				'url'=>'URL',
				'updatetime'=>'采集时间'
			),
        );

        public $custom_adminlist = "caiji.html";
        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的Collection钩子方法
        public function Collection($param){

        }

    }