<?php
namespace Home\Controller;

use Home;
use Admin\Controller\PushController;

/**
 * 图片上传控制器
 *
 * 描述：		图片批量上传
 * 所属项目: 	zfangw
 * 开发者: 		张继贤
 * 创建时间: 	2017/7/3 12:49 PM
 * 版权所有: 	中房通(www.zfangw.cn)
 */


class UploadPicController extends HomeController {

    /**
     * 自己写的上传组件
     * @return [type] [description]
     */
    public function upload_img()
    {
        if(IS_AJAX){
            if($_FILES['fileToUpload']['tmp_name'] != ''){
                $upload = new \Think\Upload();//新建上传类
                $upload->maxSize = 20971520;//设置附件大小 20M
                $upload->exts = array('bmp','jpg','jpeg','png');;//exts 数组形式设置上传文件类型
                $upload->rootPath = './';//rootPath 设置文件保存的根目录为项目根目录
                $upload->savePath = '/Picture/'; //savaPath 设置文件的保存目录
                $info = $upload->upload();
                if(!$info){
                    $this->error('上传失败'.$upload->getError());
                }else{
                    $pic_path= './Uploads'.  $info['fileToUpload']['savepath'].$info['fileToUpload']['savename'];
                }
                //$id = D('picture')->add();
                $this->success($pic_path);
            }else{
                $this->error('图片上传失败');
            }
        }
    }

    /**
     * 上传图片(调用框架自带的上传组件，返回图片ID)
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPicture(){
        //TODO: 用户登录检测
        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器
        //$this->error($info);
        if($info){
            $this->success($info);
        }else{
            $this->error('上传失败！(上传图片过大)');
        }
        if($info['picToUpload'] == null){
            $this->success($info['fileToUpload'] );
        }else{
            $this->success($info['picToUpload'] );
        }
    }


    /**
     * 删除图片
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function del_Img()
    {
        if(IS_AJAX){
            $id = I('id');
            if($id == ''){
                $this->error('删除失败！');
            }
            $pic = D('picture')->field('path')->find($id);
            if(D('picture')->delete($id)){
                $a = unlink('.' . trim($pic['path']));
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


    public function eleditUpload()
    {
         //TODO: 用户登录检测
        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器

        //dump($info);die;
        // $this->error($info);
        if($info){
            $data['status'] = 1;
            $data['url'] = '.'.$info['file']['path'];
            $this->ajaxReturn($data);
        }else{
            echo 2;
            $this->error('上传失败！');
        }
    }
}
