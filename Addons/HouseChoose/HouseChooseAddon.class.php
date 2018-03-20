<?php

namespace Addons\HouseChoose;
use Common\Controller\Addon;

/**
 * 楼盘多选插件
 * @author RK
 */

    class HouseChooseAddon extends Addon{

        public $info = array(
            'name'=>'HouseChoose',
            'title'=>'楼盘多选',
            'description'=>'楼盘多选，拖动增减',
            'status'=>1,
            'author'=>'RK',
            'version'=>'0.1'
        );

        public function install(){
            if ($this->existHook("HouseChooseBar")) {
                $this->updateHookAddons("HouseChooseBar", "HouseChoose");
            }else {
                $this->addHook("HouseChooseBar", "'HouseChoose'", "后台钩子");
            }
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的HouseChooseBar钩子方法
        public function HouseChooseBar($param){
			
		  if(!empty($param['houses_id'])){
		 	$on_data = str2arr($param['houses_id']);
			$on_map['id']  = array("in",$on_data);
			$document=M('document');
			$houses_title=$document->where($on_map)->field('title,id')->select();	
			$this->assign("title", array_combine(array_column($houses_title,'id'),array_column($houses_title,'title')));
		  };

					
		  $this->assign("addon_path", $this->addon_path);
		  $this->assign("param", $param);
			//var_dump( arr2str(array_column($houses_title,'title'),"<br />"));
            $this->display("widget");
        }
		
        /**
         * 获取钩子详情
         * @param string $hook 钩子名称
         * @return array
         */
        public function getHooks ($hook) {
            $hook_mod = M('Hooks');
            $where['name'] = $hook;
            return $hook_mod->where($where)->find();
        }
        /**
         * 判断钩子是否存在
         * @param string $hook 钩子名称
         * @return boolean
         */
        public function existHook ($hook) {
            $hooks = $this->getHooks($hook);
            return !empty($hooks);
        }
        /**
         * 删除钩子
         * @param string $hook 钩子名称
         */
       public function deleteHook($hook){
           $hook_mod = M('hooks');
           $where = array(
               'name' => $hook,
           );
           $hook_mod->where($where)->delete();
       }

       /**
        * 新增钩子
        * @param string $hook   钩子名称
        * @param string $addons 插件名称
        * @param string $msg    钩子简介
        */
        public function addHook($hook, $addons = '', $msg = ''){
            $hook_mod = M('hooks');
            $data['name']        = $hook;
            $data['description'] = $msg;
            $data['type']        = 1;
            $data['update_time'] = NOW_TIME;
            $data['addons']      = $addons;
			var_dump($data);
            if( false !== $hook_mod->create($data) ){
                $hook_mod->add();
            }
        }
		//数据转换算法
			private function str2arr($str, $glue = ','){
				return explode($glue, $str);
			}
			private function arr2str($arr, $glue = ','){
						return implode($glue, $arr);
					}

        /**
         * 更新钩子的插件字段
         * @param type $hook
         * @param type $addons
         * @return boolean
         */
        public function updateHookAddons ($hook, $addons = '') {
            $hooks = $this->getHooks($hook);
            if (in_array($addons, explode(",", $hooks['addons']))) {
                return true;
            }

            $data['id']          = $hooks['id'];
            $data['update_time'] = NOW_TIME;
            $data['addons']      = empty($hooks['addons']) ? $addons : $hooks['addons'] . "," .$addons;
            $hook_mod = M('Hooks');
            $hook_mod->save($data);
        }
    }