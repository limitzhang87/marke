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
    public function sendCode($value='')
    {

        $res = sendCode('18189702281');

        dump($res);
    }

    public function verifyCode()
    {
    	$res = verifyCode('18189702281','6651');
    	dump($res);
        /**
         * 正确格式
         * array(1) {
			  ["code"] => int(200)
			}
         * 错误格式
         * array(3) {
			  ["code"] => int(413)
			  ["msg"] => string(10) "verify err"
			  ["obj"] => int(1)
			}
         */
    }
}
