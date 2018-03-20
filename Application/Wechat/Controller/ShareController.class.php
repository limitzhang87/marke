<?php
/**
 * 分享控制器控制器
 *
 * 描述：      置业计划
 * 所属项目:    marke
 * 开发者:     张继贤
 * 创建时间:    2017/8/10 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Wechat\Controller;
use Think\Controller;

class ShareController extends Controller {
    public function _initialize()
    {
        // /* 读取站点配置 */
        // $config = api('Config/lists');
        // C($config); //添加配置

        // if(!C('WEB_SITE_CLOSE')){
        //     $this->error('站点已经关闭，请稍后访问~');
        // }

        if (ismobile()) {//移动端
            //设置默认默认主题为 Mobile
            C('DEFAULT_THEME','mobile');
        }else{
            //C('DEFAULT_THEME','mobile');//测试
        }
    }


    public function index()
    {
        echo 1;
    }
    /**
     * 显示置业计划表图片，
     * 当用于生成一张图片之后跳转到置业计划图片详情页，用户可以分享
     * @return [type] [description]
     */
    public function ownership_pic_show()
    {
        $id = I('id');
        if($id == '' || empty($id)){
            $this->error('未找到图片');
        }

        $info = D('ownership_pic')->find($id);

        if( !$info || empty($info) ){
            $this->error('未找到图片');
        }

        $this->assign('id',$id );
        $this->assign('_title','置业计划');
        $this->meta_title = '置业计划';
        $seo['title'] = '置业计划书';
        $seo['keywords'] = '置业计划书';
        $seo['description'] = '为你分享了置业计划图';
        $this->assign('seo',$seo);
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * 分享户型图
     * @return [type] [description]
     */
    public function houses_thumb()
    {
        $id = I('id');
        if($id == '' || empty($id)){
            $this->error('未找到图片');
        }
        $path = get_cover($id);
        if( !$path || empty($path) ){
            $this->error('未找到图片');
        }
        $this->assign('id',$id );
        $this->assign('_title','户型图');
        $this->meta_title = '户型图';
        /**
         * url:'http://www.zfangw.net/index.php?s=Home/share/ownership_pic_show/id/{$id}',
        title:'置业计划',
        desc:'置业计划',
        img:'http://www.zfangw.net{$info.path}',
        img_title:'置业计划',
        from:'中房通'
         */
        $config['url'] = 'http://www.zfangw.net/index.php?s=Home/share/houses_thumb/id/' .$id;
        $config['title'] = '户型图';
        $config['desc'] = '为你分享了户型图';
        $config['img'] = 'http://www.zfangw.net' . $path;
        $config['img_title'] =  '户型图';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->assign('path',$path);
        $this->display('share_pic');
    }


}
