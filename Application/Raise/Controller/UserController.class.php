<?php
/**
 * 用户控制器
 *
 * 描述：      基类
 * 所属项目:   marke
 * 开发者:     张继贤
 * 创建时间:   2017/8/11 11:12 AM
 * 版权所有:   中房通(www.zfangw.cn)
 */

namespace Raise\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class UserController extends HomeController {



    public function index()
    {
        // /dump(session('raise'));
        $info = session('raise');
        $where['id'] = $info['id'];
        $where['phone'] = $info['phone'];
        $info = D('raise')->where($where)->find();
        session('raise',$info);
        if($info['r_id'] != '' || $info['r_id'] != 0){
            $info['room'] = D()
                            ->table('zf_room as r')
                            ->join('zf_sameroom as sr on r.s_id = sr.id')
                            ->join('zf_unit as u on r.u_id = u.id')
                            ->join('zf_building as b on u.b_id = b.id')
                            ->field('r.id,r.room_number,r.floor,r.unit_price,r.usable_price,r.remark,r.status,u.u_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.orientation,b.b_name')
                            ->where('r.id=' . $info['r_id'])
                            ->find();
        }else{
            $info['room'] = null;
        }
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 我的收藏
     */
    public function collect()
    {
    	$raise = session('raise');
        $where['rcr.raise_id'] = $raise['id'];
        $list = D('raise_collect_room')
                ->table('zf_raise_collect_room as rcr')
                ->join('zf_room as r on rcr.r_id = r.id')
                ->join('zf_sameroom as sr on r.s_id = sr.id')
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->field('r.id,r.room_number,r.floor,r.unit_price,r.usable_price,r.remark,r.status,u.u_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.orientation,b.b_name')
                ->where($where)
                ->limit(10)
                ->select();
        $this->assign('list', $list);
        $this->assign('empty' ,'<center>尚无收藏的房号，赶紧去首页收藏吧！</center>');
        $this->display();
    }
}
