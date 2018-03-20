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
namespace Wechat\Controller;

class ChatController extends HomeController {

    /**
     * 公告首页
     * @return [type] [description]
     */
    public function index()
    {
        $this->assign('user', json_encode(session('user_auth')) );
        $this->display();
    }


    /**
     * AJAX 获取聊天记录
     * @return [type] [description]
     */
    public function getChatList()
    {
        $data['houses_id'] = getHouse(1);
        if(I('type') == '1'){//取比这个时间还早的10条记录
            $data['send_time'] = array('lt',I('firstTime'));
            $limit = I('limit');
        }else{
            $data['send_time'] = array('gt',I('lastTime'));
            $limit = null;
        }
        $list = D()
                ->table('zf_chat as c')
                ->where($data)
                ->join('zf_user as u on c.uid = u.id')
                ->limit($limit)
                ->field('c.*,u.nick_name,u.head_img,u.phone')
                ->order('send_time desc')
                ->select();
        $this->success(array_reverse($list));
    }


    /**
     * 发表聊天
     * @return [type] [description]
     */
    public function send()
    {
        checkORredirect(IS_AJAX);
        $data['content']   = I('content');
        $data['houses_id'] = getHouse(1);
        $data['uid']       = is_login();
        $data['send_time'] = $this->msectime();
        if(D('chat')->add($data)){
            $this->success($data);
        }else{
            $this->error('发送失败！');
        }
    }

    public function text()
    {
        $data['houses_id'] = getHouse(1);
        $list = D()
                ->table('zf_chat as c')
                ->where($data)
                ->join('zf_user as u on c.uid = u.id')
                ->limit(10)
                ->field('c.*,u.nick_name,u.head_img,u.phone')
                ->order('send_time asc')
                ->select();
        dump($list);
    }

    //返回当前的毫秒时间戳
    protected function msectime() {
        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }
}
