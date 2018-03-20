<?php

namespace Addons\Comment\Controller;
use Home\Controller\AddonsController;

class CommentController extends AddonsController{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 后台编辑评论
     * @return void
     */
    public function edit() {
        if (!is_administrator()) {
            $this->error('非管理员用户');
        }
        $Comment = D('Addons://Comment/AddonComment');
        if ($Comment->edit()) {
            $result = array('status' => 1, 'info' => $Comment->Success(), 'data' => '');
            $this->ajaxReturn($result);
        }
        else {
            $this->error($Comment->Error());
        }
    }

    /**
     * 后台搜索评论列表
     * @return void
     */
    public function searchDocument() {
        if (!is_administrator()) {
            $this->error('非管理员用户');
        }
        $Comment = D('Addons://Comment/AddonComment');
        $result = $Comment->searchDocument();
        $ajaxData = array('status' => 1, 'info' => '', 'data' => '');
        if ($result && count($result) > 0) {
            $ajaxData['info'] = '搜索到文档';
            $ajaxData['data'] = $result;
        }
        else {
            $ajaxData['status'] = 0;
            $ajaxData['info'] = '没有搜索到文档';
            $ajaxData['data'] = array();
        }
        $this->ajaxReturn($ajaxData);
    }

    /**
     * 后台文档标题
     * @return void
     */
    public function getDocumentsTitle() {
        if (!is_administrator()) {
            $this->error('非管理员用户');
        }
        $result = array('status' => 0, 'info' => '', 'data' => '');
        $ids = I('post.ids', null);   // 文档ID集合
        if ($ids === null) {
            $result['info'] = '请求文档标题失败[INVALID_DOCUMENTS_IDS]';
            $this->ajaxReturn($result);
            exit();
        }
        $ids = explode(',', $ids);
        $documents_title = array();
        $Document = M('Document');
        foreach ($ids as $id) {
            if ($id == '') continue;
            if (!preg_match('/^\d{1,}$/', $id)) {
                $result['info'] = '请求文档标题失败[INVALID_DOCUMENT_ID:'.$id.']';
                $this->ajaxReturn($result);
                exit();
            }
            if (!isset($documents_title[$id])) {
                if ($info = $Document->field('id, title, status')->where(array('id'=> $id))->find()) {
                    $documents_title[$id] = $info['title'] . ($info['status'] != 1 ? '[未发布]' : '');
                }
                else {
                    $result['info'] = '请求文档标题失败[HAS_NO_DOCUMENT:'.$id.']';
                    $this->ajaxReturn($result);
                    exit();
                }
            }
        }
        $result['status'] = 1;
        $result['info'] = '请求成功';
        $result['data'] = $documents_title;
        $this->ajaxReturn($result);
    }

    /**
     * 前台提交评论方法
     * @return void
     */
    public function submit() {
        $result = array('status' => 1, 'info' => '', 'data' => '');

        // 检查ip可用性
        $CommentIplist = D('Addons://Comment/AddonCommentIplist');
        if (!$CommentIplist->isValid()) {
            $result['status'] = 0;
            $result['info'] = $CommentIplist->Error();
            $CommentIplist->updateIpLastTime();
            $this->ajaxReturn($result);
            return;
        }

        $Comment = D('Addons://Comment/AddonComment');
        $conid=$Comment->submit();
        if ($conid) {
            $result['info'] = '提交成功';
            $result['id'] = $conid;
        }
        else {
            $result['status'] = 0;
            $result['info'] = $Comment->Error();
        }
        $CommentIplist->updateIpLastTime();
		$this->ajaxReturn($result);
    }

    /**
     * 后台评论列表快速切换状态
     * @return void
     */
    public function status() {
        if (!is_administrator()) {
            $this->error('非管理员用户');
        }
        $result = array('status'=> 1, 'info'=> '', 'data'=> '');
        $Comment = D('Addons://Comment/AddonComment');
        if ($Comment->status()) {
            $result['info'] = '成功改变状态';
        }
        else {
            $result['status'] = 0;
            $result['info'] = $Comment->Error();
        }
        $this->ajaxReturn($result);
    }

    /**
     * 显示验证码
     * @return void
     */
    public function verifyCode() {
        $Verify = new \Think\Verify();
        $Verify->entry();
    }

}