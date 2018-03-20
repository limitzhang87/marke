<?php

namespace Addons\UploadImg;
use Common\Controller\Addon;

/**
 * 文件上传插件
 * @author lhb
 */

    class UploadImgAddon extends Addon{

        public $info = array(
            'name'=>'UploadImg',
            'title'=>'户型图上传',
            'description'=>'户型图上传',
            'status'=>1,
            'author'=>'elvis',
            'version'=>'0.2'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的UploadFiles钩子方法
        public function UploadImg($param){
            if (empty($param['value'])) {
                $param['value'] = json_encode(array());
            }
            $this->assign('param', $param);
            $this->display('index');
        }

    }