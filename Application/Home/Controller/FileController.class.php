<?php

/**
 * 文件上传控制器
 *
 * 描述：		文件上传
 * 所属项目: 	zfangw
 * 开发者: 		张继贤
 * 创建时间: 	2017/9/12 12:49 PM
 * 版权所有: 	中房通(www.zfangw.cn)
 */

namespace Home\Controller;

/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */

class FileController extends HomeController {
	/* 文件上传 */
	public function upload(){
		$return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
		/* 调用文件上传组件上传文件 */
		$File = D('File');
		$file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
		$info = $File->upload(
			$_FILES,
			C('DOWNLOAD_UPLOAD'),
			C('DOWNLOAD_UPLOAD_DRIVER'),
			C("UPLOAD_{$file_driver}_CONFIG")
		);

		/* 记录附件信息 */
		// if($info){
		// 	$return['data'] = think_encrypt(json_encode($info['download']));
		// } else {
		// 	$return['status'] = 0;
		// 	$return['info']   = $File->getError();
		// }
		$this->success($info['fileToUpload']);
		/* 返回JSON数据 */
		//$this->ajaxReturn($return);
	}

	/* 下载文件 */
	public function download($id = null){
		if(empty($id) || !is_numeric($id)){
			$this->error('参数错误！');
		}

		$logic = D('file');
		if(!$logic->download('./Uploads/Download/',$id)){
			$this->error($logic->getError());
		}
	}


	/**
     * 删除文件
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function del_File()
    {
        if(IS_AJAX){
            $id = I('id');
            if($id == ''){
                $this->error('删除失败！');
            }
            $pic = D('file')->field('savepath,savename')->find($id);
            // /Uploads/Picture/2017-09-12/59b759deb7aeb.jpg
            $path = '/Uploads/Download/' .$pic['savepath'] . $pic['savename'];
            if(D('file')->delete($id)){
                $a = unlink('.' . trim($path));
                $this->success($a);
            }else{
                $this->error('删除失败！');
            }
        }else{
            $this->direct('Index/index');
            echo 1;
            dump(unlink('./Uploads/Picture/2017-08-23/599cfc8a1b839.jpg'));
        }
    }
}
