<?php 
/**
 * 房号控制器
 *
 * 描述：       用户登录
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/7/24 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */

namespace Raise\Controller;

class RoomController extends HomeController {

    /**
     * 获取栋号
     * @return [type] [description]
     */
    public function getBuilding()
    {
        if(IS_AJAX){
            if( I('status') == '1'){
                $where['status']    = I('status');
                $building  = D('building')->where($where)->order('id asc')->select();
            }else{
                $whereSQL = ' (b.status = -1 or ( b.status=1 and u.status=-1 )) ';//查找那些栋状态是在售，但是其下面的单元有待售的楼
                $building  = D('building')
                            ->table('zf_building b')
                            ->join('zf_unit as u on b.id=u.b_id','LEFT')
                            ->where($where)
                            ->where($whereSQL)
                            ->order('b.id asc')
                            ->field('b.*')
                            ->group('b.id')
                            ->select();
            }
            if(empty($building)){
                $this->error('没有房源信息');
            }else{
                $this->success($building);
            }
        }else{
            $this->redirect('Index/index');
        }
    }

    /**
     *  根据栋号获取单元
     * @return [type] [description]
     */
    public function getUnit()
    {

        if(IS_AJAX){
            $b_id = I('b_id');
            if($b_id == '' || empty($b_id)){
                $this->error('系统出错，请退出去重新登录！');
            }
            $where['b_id'] = $b_id;
            $where['status']    = I('status');
            $unit   = D('unit')->where($where)->order('u_order')->select();
            if(empty($unit)){
                $this->error('没有房源信息');
            }else{
                $this->success($unit);
            }
        }else{
            $this->redirect('Index/index');
        }
    }

    /**
     * 根据单元获取房号
     * @return [type] [description]
     */
    public function getRoom()
    {
        if(IS_AJAX){
            $u_id = I('u_id');

            if($u_id == '' || empty($u_id)){
                $this->error('系统出错，请退出去重新登录！');
            }
            $where['r.u_id'] = $u_id;
            $where['u.status'] = I('status');
            $where['r.status'] = 0;
            $room   = D()
                    ->table('zf_room r')
                    ->join('zf_unit as u on r.u_id=u.id')
                    ->join('zf_user as user on r.lastop_uid=user.id','left')
                    ->where($where)
                    ->field('r.id,r.u_id,r.floor,r.is_check,r.status,r.room_number,user.nick_name')
                    ->order('floor,room_number,is_check')
                    ->select();
            for ($i=0; $i < count($room); $i++) {
                $room[$i]['statusCSS'] = getRoomStatus($room[$i]['status'],$room[$i]['is_check']);//根据房号的状态，获取对应的CSS样式
                $roomL[ $room[$i]['floor'] ][] = $room[$i];//将所有的房号按照楼层分组
            }
            if(empty($roomL)){
                $this->error('没有房源信息');
            }else{
                $this->success($roomL);
            }
        }else{
            $this->redirect('Index/index');
        }
    }

    /**
     * 房间信息
     * 根据不同的房间不同的状态，和会员不同的权限来设置页面显示按钮
     * @return [type] [description]
     */
    public function room_info()
    {
        /**
         * 获取房号的所有信息
         */
        $id = I('id');
        $room = D()
                ->table('zf_room as r')
                ->where('r.id=' . $id)
                ->join('zf_sameroom as sr on r.s_id = sr.id')
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->field('r.*,sr.r_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.thumb,sr.orientation,u.u_name,u.u_order,u.status as u_status,b.b_name')
                ->find();
        if(empty($room)){
            $this->error('房源信息显示错误！');
        }

        $room['total_price'] = number_format($room['unit_price']*$room['area']/10000.0, 2);

        $room['thumb'] = explode(',', $room['thumb']);
        if($room['thumb'][0] == '' ){
            $room['thumb'] = NULL;
        }
        $room['address'] = getHouses('address');

        $raise = session('raise');
        $raise = D('raise')->find($raise['id']);
        session('raise',$raise);
        $button = array();//存储页面中要显示的按钮
        $tip = array();//页面的一些提示内容

        $where['raise_id'] = $raise['id'];
        $where['r_id'] = $id;
        $num = D('raise_collect_room')->where($where)->count();
        if($num == 1){
            $button[] = $this->getButton('取消收藏','uncollect', 'status_error');
        }else{
            $button[] = $this->getButton('收藏','collect', 'status_success');
        }

        if($room['u_status'] == '1'){/* 单元状态 */
            if($room['status'] == 0){/* 房间状态 */
                if($raise['status']  == 1){
                    if(time()  >= START_TIME ){
                        if($raise['r_id'] == '' || $raise['r_id'] == 0){
                            $button[] = $this->getButton('抢房','buy', 'status_error');
                        }else{
                            $tip[] = '抱歉，您已经购房，不能在继续选购！';
                        }

                    }
                }else{
                    $tip[] = '抱歉,您的认筹还没有通过认证，请联系置业顾问认证';
                }
            }else if ($room['status'] == 3 && $room['raise_id'] == $raise['id']){
                $button[] = $this->getButton('退房','check_out','status_over');
                $tip[] = '您已经购得此房！';
                if($room['is_check'] == 1){
                    $tip[] = '已完成合同的签约！';
                }else{
                    $tip[] = '请尽快联系置业顾问进行合同签约。';
                }
            }else{
                $tip[] = '抱歉,该房已售！';
            }
        }else{
            $tip[]  = '该房未售';
        }
        $this->assign('room', $room);
        $this->assign('button', $button);
        $this->assign('tip', $tip);
        $this->assign('width',100/count($button)-5);
        $this->assign('_id', $id );
        $user = session('user_auth');
        $config['url'] = 'http://www.zfangw.net/index.php?s=Home/share/houses_thumb' . '/id/' .$id;
        $config['title'] = getHouses('title') . '户型图';
        $config['desc'] = $user['nick_name'] .'为你分享了'. getHouses('title') . '户型图';
        $config['img'] = 'http://www.zfangw.net' . $path;
        $config['img_title'] =  getHouses('title') . '户型图';
        $config['from'] = '海南中房通网络科技有限公司';
        $this->assign('config',json_encode($config));
        $this->display();
    }

    protected function getButton($title, $method, $color)
    {
        $button['title'] = $title;
        $button['method'] = $method;
        $button['color'] = $color;
        return $button;
    }

    /**
     * 房间操作，修改房间状态
     * @return [type] [description]
     */
    public function changeStatus()
    {
        if(IS_AJAX){

            // $method = I('method');
            // $hosues_id = getHouse(1);
            // $uid = is_login();
            // $id = I('id');
            /**
             * 在执行任何操作之前，都要判断该房号的状态是否符合要求
             */
            $method = I('method');
            switch ($method) {
                case 'collect':
                    /**
                     * 收藏房号，判断是否已经收场了10分房号
                     */
                    $raise = session('raise');
                    $where['raise_id'] = $raise['id'];
                    $isFULL = D('raise_collect_room')->where($where)->count();

                    if($isFULL >= 10){
                        $this->error('抱歉，最多只能收藏10个房号！');
                        die;
                    }
                    $data['raise_id'] = $where['raise_id'];
                    $data['r_id'] = I('id');
                    if(D('raise_collect_room')->add($data)){
                        $this->success('收藏成功！');
                    }else{
                        $this->error('收藏失败！');
                    }
                    break;
                case 'uncollect':
                    $raise = session('raise');
                    $where['raise_id'] = $raise['id'];
                    $where['r_id'] = I('id');
                    if($where['r_id'] == '' || $where['raise_id'] == ''){
                        $this->error('抱歉，取消收藏失败！');
                    }
                    if(D('raise_collect_room')->where($where)->delete()){
                        $this->success('取消收藏成功！');
                    }else{
                        $this->error('抱歉，取消收藏失败！');
                    }
                    break;
                case 'buy':
                    /**
                     * 抢房
                     */
                    $raise = session('raise');
                    $add['raise_id'] = $raise['id'];
                    $add['r_id'] = I('id');

                    $data['raise_id'] =  $raise['id'];
                    $data['raise_time'] = time();
                    $data['status'] = 3;
                    $whereRoom['status'] = 0;
                    $whereRoom['id'] = I('id');
                    if($raise['r_id'] != 1){
                        if( D('room')->where($whereRoom)->save($data)){
                            $raise['r_id'] = $whereRoom['id'];
                            $raise['buy_time'] = time();
                            if(D('raise')->save($raise)){
                                session('raise', $raise);
                                $this->success('抢房成功！');
                            }else{
                                $data['raise_id'] = 0;
                                $data['raise_time'] = 0;
                                $data['status'] = 0;
                                D('room')->where($whereRoom)->save($data);
                                $this->error('抱歉，抢房失败！');
                            }
                        }else{
                            $this->error('抱歉，抢房失败！');
                        }
                    }else{
                        $this->error('抱歉，您已经抢过房！');
                    }

                    break;
                default:
                    // code...
                    break;
            }
            $this->error('抱歉！操作失败！');
        }else{
            $this->redirect('Index/index');
        }
    }


}
 ?>