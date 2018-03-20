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
namespace Home\Controller;
use Think\Controller;

class ShareController extends Controller {
    protected $houses = '';
    public function _initialize()
    {
        $houses = I('get.houses');
        if(!$houses){
            echo '<meta charset="UTF-8">链接失效！';
            die;
        }
        $this->houses = $houses;
        session('db_name', $houses);
        changeDB();

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
        $config['url'] = $_SERVER['HTTP_HOST'] . U('Share/ownership_pic_show',array('houses'=>$this->houses,'id'=>$id));
        $config['title'] = '户型图';
        $config['desc'] = '为你分享了置业计划表';
        $config['img'] =  $_SERVER['HTTP_HOST'] . $info['path'];
        $config['img_title'] =  '户型图';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->assign('path',$info['path']);
        $this->display('share_pic');
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
        //$config['url'] = 'http://www.zfangw.net/index.php?s=Home/Share/houses_thumb/houses/'.$this->houses.'/id/' .$id;
        $config['url'] = $_SERVER['HTTP_HOST'] . U('Share/houses_thumb',array('houses'=>$this->houses,'id'=>$id));
        $config['title'] = '户型图';
        $config['desc'] = '为你分享了户型图';
        $config['img'] =  $_SERVER['HTTP_HOST'] . $path;
        $config['img_title'] =  '户型图';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->assign('path',$path);
        $this->display('share_pic');
    }

    public function houses_img()
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
        $this->assign('_title','楼盘图片');
        $this->meta_title = '楼盘图片';
        /**
         * url:'http://www.zfangw.net/index.php?s=Home/share/ownership_pic_show/id/{$id}',
        title:'置业计划',
        desc:'置业计划',
        img:'http://www.zfangw.net{$info.path}',
        img_title:'置业计划',
        from:'中房通'
         */
        //$config['url'] = 'http://www.zfangw.net/index.php?s=Home/share/houses_img/houses/'.$this->houses.'/id/' .$id;
        $config['url'] = $_SERVER['HTTP_HOST'] . U('Share/houses_img',array('houses'=>$this->houses,'id'=>$id));
        $config['title'] = '楼盘图片';
        $config['desc'] = '为你分享了楼盘图片';
        $config['img'] =  $_SERVER['HTTP_HOST'] . $path;
        $config['img_title'] =  '楼盘图片';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->assign('path',$path);
        $this->display('share_pic');
    }

}
