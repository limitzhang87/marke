<?php

namespace Addons\UploadFiles;
use Common\Controller\Addon;

/**
 * 文件上传插件
 * @author rk
 */

    class UploadFilesAddon extends Addon{

        public $info = array(
            'name'=>'UploadFiles',
            'title'=>'多附件上传',
            'description'=>'多附件上传',
            'status'=>1,
            'author'=>'rk',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的UploadFiles钩子方法
        public function UploadFiles($param){
			//var_dump($param);
            if (empty($param['value'])) {
                $param['value'] = json_encode(array());
            }
            $this->assign('param', $param);
            if($param['type']=='view'){//如果只是展示附件的
            	$this->display('view');
            }else{
            	$this->display('index');
            }
            
        }

    }