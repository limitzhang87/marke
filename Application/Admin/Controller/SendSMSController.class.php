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
use \Think\Controller;

class SendSMSController extends Controller {

    public function index()
    {
        echo 1;
    }
    public function send($value='')
    {
        $SMS = Vendor('PHPSMS');
        dump($SMS);
    }
}
