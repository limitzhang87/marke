<?php

namespace Addons\ImageSlider;
use Common\Controller\Addon;

/**
 * 图片轮播插件
 * @author birdy
 */

    class ImageSliderAddon extends Addon{

        public $info = array(
            'name'=>'ImageSlider',
            'title'=>'图片轮播',
            'description'=>'图片轮播',
            'status'=>1,
            'author'=>'yidian',
            'version'=>'0.1'
        );

        public function install(){
            /* 先判断插件需要的钩子是否存在 */
            $this->existHook($this->info['name'], $this->info['name'], $this->info['description']);
            return true;
        }

        public function uninstall(){
            //删除钩子
            $this->deleteHook($this->info['name']);
            return true;
        }
        
        //实现的ImageSlider钩子方法
        public function ImageSlider($param){
            $config = $this->getConfig();
            if($config['status']){
                $images = array();
                if($config['images']){
                    $images = M("Picture")->field('id,path')->where("id in ({$config['images']})")->select();
                }
                $this->assign('urls', explode("\r\n",$config['url']));
                $this->assign('images', $images);
                $this->assign('config', $config);
                $this->display($config['type']);
            }
        }
    }