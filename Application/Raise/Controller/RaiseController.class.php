<?php
/**
 * 认筹控制器
 *
 * 描述：       公告
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/9/27 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Raise\Controller;

class RaiseController extends HomeController {

    public function index()
    {
        if(!is_auth(AUTH_RAISE_MANAGE)){
            $this->redirect('lists');
        }
        $info = D('houses_info')->find();
        $this->assign('info',$info);
        $this->assign('_title','商城管理');
        $this->display();
    }

    public function bulletinList()
    {
        $type = I('type') ? 1 : 0;
        $page = I('page') > 0 ? I('page') : 1;
        $list = D('raise_bulletin')
                ->limit('10')
                ->page($page)
                ->where(array('type'=>$type))
                ->order('created_time desc')
                ->select();
        $total = D('raise_bulletin')
                ->count();
        $this->assign('totalpage',intval($total/10)+1);
        $this->assign('_list', $list);
        $title = $type ? '商城公告列表' : '商城信息列表';
        $this->assign('_title',$title);
        $this->assign('_type' . $type,'page_on');
        $this->assign('type',$type);
        $this->assign('empty','<center>没有更多数据</center>');
         $this->assign('_right_url', U('Index/index'));
        $this->assign('_right_type', 'background: url(\'./Public/Mobile/images/icon/r_index2_icon.png\') no-repeat;');
        $this->display();
    }

    /**
     * 公告详情
     * @return [type] [description]
     */
    public function bulletinInfo()
    {
        $id = I('id');
        checkORredirect($id, 'Raise/index');
        D('raise_bulletin')->where('id=' . $id)->setInc('view');
        $info = D('raise_bulletin')->find($id);
        $info['pictures'] = ($info['pictures'] == '' || $info['pictures'] == 0 )?'': explode(',', $info['pictures']);
        $info['file']     = ($info['file'] == '' || $info['file'] == 0 )? '': explode(',', $info['file']);

        $this->assign('info', $info);
        $this->assign('_right_url',U('bulletinList',array('type'=>$info['type'])));
        $this->assign('_right_type', 'background: url(\'./Public/Mobile/images/icon/r_index2_icon.png\') no-repeat;');
        $this->display();
    }
}
