<?php

namespace Addons\UploadImages;
use Common\Controller\Addon;

/**
 * 文件上传插件
 * @author lhb
 */

    class UploadImagesAddon extends Addon{

        public $info = array(
            'name'=>'UploadImages',
            'title'=>'多图上传',
            'description'=>'多图上传',
            'status'=>1,
            'author'=>'lhb',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的UploadFiles钩子方法
        public function UploadImages($param){
            if (empty($param['value'])) {
                $param['value'] = json_encode(array());
            }
            $this->assign('param', $param);
            if($param['type']=='view'){//如果只是展示图片的
            	$this->display('view');
            }else{
            	$this->display('index');
            }
            
        }

    }