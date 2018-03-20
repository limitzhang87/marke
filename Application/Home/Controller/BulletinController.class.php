<?php
/**
 * 公告控制器
 *
 * 描述：      公告
 * 所属项目:    marke
 * 开发者:     张继贤
 * 创建时间:    2017/8/10 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;

class BulletinController extends HomeController {

    /**
     * 公告首页
     * @return [type] [description]
     */
    public function index()
    {
        $page = I('page') > 0 ? I('page') : 1;

        $list = D('bulletin')
                ->limit('10')
                ->page($page)
                ->order('created_time desc')
                ->select();
        $total = D('bulletin')
                ->count();
        $this->assign('totalpage',intval($total/10)+1);
        $this->assign('_list', $list);
        $this->display();
    }

    /**
     * 添加公告
     */
    public function add()
    {
        checkORredirect(is_super());
        if(IS_POST){
            $data['title']     = I('title');
            $data['content']   = I('content');
            $data['pictures']  = I('pictures');
            $data['file']      = I('file');
            $data['created_time'] = time();
            if(D('bulletin')->add($data)){
                $this->redirect('Bulletin/index');
            }
            return;
        }

        $this->assign('_title', '添加公告');
        $this->display();
    }

    /**
     * 公告详情
     * @return [type] [description]
     */
    public function info()
    {
        $id = I('id');
        checkORredirect($id, 'Bulletin/index');
        D('bulletin')->where('id=' . $id)->setInc('view');
        $info = D('bulletin')->find($id);
        $info['pictures'] = ($info['pictures'] == '' || $info['pictures'] == 0 )?'': explode(',', $info['pictures']);
        $info['file']     = ($info['file'] == '' || $info['file'] == 0 )? '': explode(',', $info['file']);

        $this->assign('info', $info);
        $this->display();
    }

    public function edit()
    {
        $id = I('id');
        checkORredirect($id, 'Bulletin/index');
        if(IS_POST){
            $data['id']           = I('id');
            $data['title']        = I('title');
            $data['content']      = I('content');
            $data['pictures']     = I('pictures');
            $data['file']         = I('file');
            $data['created_time'] = time();

            if(D('bulletin')->save($data)){

                //找出删除掉了图片和文件id
                $oldPids = array_diff(explode(',', I('old_pictures')), explode(',', $data['pictures']));
                $oldFids = array_diff(explode(',', I('old_file')), explode(',', $data['file']));
                //删除图片和文件
                if($oldPids[0] != ''){
                    $whereP['id'] = array('in',$oldPids);
                    $pifDelete =  D('picture')->field('path')->where($whereP)->select();
                    foreach ($pifDelete as $pic) {
                        $path = '.' .$pic['path'];
                         unlink(trim($path));
                    }
                }
                if($oldFids[0] != ''){
                    $whereF['id'] = array('in',$oldFids);
                    $fileDelete =  D('file')->field('savepath,savename')->where($whereF)->select();
                    foreach ($fileDelete as $file) {
                        $path = './Uploads/Download/' . $file['savepath'] . $file['savename'] ;
                        unlink(trim($path));
                    }
                }

                $this->success('修改成功',U('Bulletin/info',array('id'=>$data['id'])));
            }else{
                $this->error('修改失败！');
            }


        }else{
            D('bulletin')->where('id=' . $id)->setInc('view');
            $info = D('bulletin')->find($id);
            $info['picturesA'] = ($info['pictures'] == '' || $info['pictures'] == 0 )?'': explode(',', $info['pictures']);
            $info['fileA']     = ($info['file'] == '' || $info['file'] == 0 )? '': explode(',', $info['file']);
            $this->assign('info', $info);
            $this->display();
        }
    }
}
