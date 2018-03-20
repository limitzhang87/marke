<?php

namespace Addons\weather;
use Common\Controller\Addon;

/**
 * 天气插件
 * @author wzx
 */

    class weatherAddon extends Addon{

        public $info = array(
            'name'=>'weather',
            'title'=>'天气',
            'description'=>'天气插件',
            'status'=>1,
            'author'=>'wzx',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的AdminIndex钩子方法
        public function AdminIndex($param){
            $config = $this->getConfig();
            $this->assign('addons_config', $config);
            if($config['display'])
                $this->display('widget');
        }
    }