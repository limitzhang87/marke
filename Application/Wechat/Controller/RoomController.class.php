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

namespace Wechat\Controller;

class RoomController extends HomeController {
	protected function _initialize(){
        parent::_initialize();
        //房间状态
        define('ROOM_STATUS_NSOLE',0);//未售
        define('ROOM_STATUS_LOCK',1);//锁定
        define('ROOM_STATUS_MARKETINCON',2);//销控
        define('ROOM_STATUS_SUBMIT',9);//已售
        //房间操作类型
        define('ROOM_OP_LOCK',1);//锁定
        define('ROOM_OP_UNLOCK',2);//解锁
        define('ROOM_OP_LOCKCHECK',3);//锁定审核
        define('ROOM_OP_SUBMIT',4);//成交
        define('ROOM_OP_UNSUBMIT',5);//取消成交
        define('ROOM_OP_SUBMITCHECK',6);//成交审核
        define('ROOM_OP_MARKETINCON',7);//销控
        define('ROOM_OP_UNMARKETINCON',8);//取消销控

        define('REPORT_LOCK',1); //提交审核通过
        define('REPORT_SUBMIT',2);//成交审核通过

    }
    //房源首页
    public function index(){
        $this->display();
    }


    /**
     * 楼盘信息设置
     * @return [type] [description] 
     */
    public function house_info_set()
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_POST){
            $data['b_name'] = I('b_name');
            $data['unit_num'] = I('unit_num');
            $houses_id = getHouse();
            $data_b = array();
            foreach ($data['b_name'] as $k => $v) {
                if( $data['unit_num'][$k] == ''){//这一步是去除之前存在的
                    continue;
                }
                $data_b[$k]['houses_id'] = $houses_id;
                $data_b[$k]['b_name'] = $v;
                $data_b[$k]['unit_num'] = $data['unit_num'][$k];
                $is_w = array();
                for ($i=0; $i <  $data['unit_num'][$k]; $i++) { 
                    $is_w[] = 0;
                }
                $data_b[$k]['is_w'] = implode(',', $is_w);
            }
            if(empty($data_b)){
                $this->error('保存失败！');
            }
            if(D('building')->addAll($data_b)){
                $this->redirect('Room/house_info_set');
            }else{
                $this->error('保存失败！');
            }
        }else{
            $list = D('building')->field('id,b_name,unit_num')->where('houses_id=' . getHouse())->order('id asc')->select();
            $this->assign('_list', $list);
            $this->display();
        }
    }

    /**
     * 删除某个栋号，以及下面的单元
     * @return [type] [description]
     */
    public function del_building()
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_AJAX){
            $id = I('id');
            if($id == '' || empty($id)){
                $this->error('删除失败！');
            }
            if(D('building')->delete($id) ){
                $unit = D('unit')->where('b_id=' . $id)->field('id')->select();
                if(!empty($unit)){
                    foreach ($unit as $vo) {
                       $uids[] = $vo['id'];
                    }
                    $uids = implode(',', $uids);

                    try {
                        $where['id'] = array('in',$uids);
                        D('unit')->where($where)->delete();

                        $whereUS['u_id'] = array('in',$uids);
                        D('us')->where($whereUS)->delete();

                    } catch (Exception $e) {
                        $this->success('删除成功');
                    }
                }else{
                    $this->success('删除成功');
                }
            }else{
                $this->error('删除失败！');
            }
        }else{
            $this->redirect('Index/index');
        }
    }

    /**
     * 修改栋名称
     * @return [type] [description]
     */
    public function edit_building()
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_AJAX){
            $data['id'] = I('id');
            $data['b_name']=I('b_name');
            if(D('building')->save($data) !== false){
                $this->success(1);
            }else{
                $this->error(1);
            }
        }
    }

    /**
     * 栋号和单元列表页面
     * 根据房号列表去搜索
     * @return [type] [description]
     */
    public function building_list()
    {
        is_auth(AUTH_ROOM_MANAGE);
        $houses_id = getHouse();
        $list = D('building')
            ->field('id,b_name,unit_num,is_w,status')
            ->where('houses_id=' . $houses_id)
            ->order('id asc')
            ->select();
        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['is_w'] = explode(',', $list[$i]['is_w']);
            $temp = D('unit')
                                ->field('id,u_name,status,u_order')
                                ->where('b_id=' .  $list[$i]['id'])
                                ->order('u_order asc')
                                ->limit(count($list[$i]['is_w']))
                                ->select();
            $list[$i]['unit']  = array_reduce($temp, 'editUnit');
        }
        //dump($list);die;
        $this->assign('_list',$list);
        $this->display();
    }


    /**
     * AJAX获取栋号和单元列表
     * @return [type] [description]
     */
    public function get_building_list()
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_AJAX){
            $houses_id = I('houses_id');
            $list = D('building')->field('id,b_name,unit_num,is_w')->where('houses_id=' . $houses_id)->order('id asc')->select();
            if($list){
                $res['error'] = 0;
                $res['list'] = $list;
            }else{
                $res['error'] = 1;
            }
            $this->ajaxReturn($res);
        }
    }

    /**
     * 修改栋号和单元的可售状态
     * @return [type]        [description]
     */
    public function changeBUStatus($value='')
    {
        if(IS_AJAX){
            /**
             * 修改一栋楼的状态为可售的时候，其下面的单元也要全部为可售
             * 修改一栋楼的状态为不可售的时候，其下面的单元也要全部为不可售
             *
             * 修改一个单元为可售的时候，其栋也要为可售，
             * 修改一个单元为不可售的时候，栋不变
             */
            $type = I('type');
            $id = I('id');
            $status = I('status');
            if($type == 'b'){
                $data['id'] = $id;
                $data['status'] = $status;
                D('building')->save($data);
                $dataU['status'] = $status;
                D('unit')->where('b_id='.$id)->save($dataU);
            }else{
                $dataU['id'] = $id;
                $dataU['status'] = $status;
                D('unit')->save($dataU);

                if($status == '1'){
                    $dataB['id'] = I('b_id');
                    $dataB['status'] = 1;
                    D('building')->save($dataB);
                }
            }
            $this->success('成功');
        }
    }

    /**
     * 单元信息编辑
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function unit_set($value='')
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_POST){
            /*start 组装单元数据*/
            $houses_id = getHouse(1);
            $unit_data[0]['houses_id']   = $houses_id;
            $unit_data[0]['b_id']        = I('b_id');
            $unit_data[0]['u_order']     = I('u_order');
            $unit_data[0]['u_name']      = I('u_name');
            $unit_data[0]['room_num']    = I('room_num');
            $unit_data[0]['floor_start'] = I('floor_start');
            $unit_data[0]['floor_over']  = I('floor_over');

            foreach (I('other_b_id') as $key => $vo) {
                //$vo = '1-2-A';
                $b_i = explode('-', $vo);
                $unit_data[$key+1]['houses_id']   = $houses_id;
                $unit_data[$key+1]['b_id']        = $b_i[0];
                $unit_data[$key+1]['u_order']     = $b_i[1];
                $unit_data[$key+1]['u_name']      = I('u_name-' . $b_i[0] . '_' . $b_i[1]);
                $unit_data[$key+1]['room_num']    = I('room_num');
                $unit_data[$key+1]['floor_start'] = I('floor_start-' . $b_i[0] . '_' . $b_i[1]);
                $unit_data[$key+1]['floor_over']  = I('floor_over-' . $b_i[0] . '_' . $b_i[1]);
            }

            for ($i = 0; $i < count($unit_data); $i++) {
                if($unit_data[$i]['floor_start'] > $unit_data[$i]['floor_over']){
                    $temp = $unit_data[$i]['floor_start'];
                    $unit_data[$i]['floor_start'] = $unit_data[$i]['floor_over'];
                    $unit_data[$i]['floor_over'] = $temp;
                }
            }

            $UNIT = D('unit');
            $UNIT->startTrans();
            if($u_ids[0] = $UNIT ->addAll($unit_data)){
            }else{
                $UNIT->rollback();
                $this->error('添加失败');
            }
            $UNIT->commit();
            unset($UNIT);
            /*end 组装单元数据*/

            //获取单元表插入后的ID
            for ($i=1; $i < count($unit_data); $i++) {
                $u_ids[$i]  = $u_ids[$i-1]+1;
            }

            /**
             * building表的组装和修改
             * @var array
             */
            $is_wList = array();
            for ($i=0; $i < count($unit_data); $i++) {
                $is_wList[$unit_data[$i]['b_id']][$i]['w'] = $u_ids[$i];
                $is_wList[$unit_data[$i]['b_id']][$i]['u_order'] = $unit_data[$i]['u_order'];
            }

            foreach ($is_wList as $key => $value) {
                $building_data[$key] = D('building')->find($key);
                $is_w = explode(',',$building_data[$key]['is_w']);
                foreach ($value as $k => $v) {
                    $is_w[$v['u_order']] = $v['w'];
                }
                $building_data[$key]['is_w'] = implode(',', $is_w);
            }
            if(D('building')->saveAll($building_data)){
                unset($building_data);
            }else{
                $this->error('添加失败');
            }

            /**
             * sameroom表的组装和插入
             * @var [type]
             */
            $r_name          = I('r_name');
            $unit_price      = I('unit_price');
            $bt_price        = I('bt_price');
            $usable_price    = I('usable_price');
            $usable_tw_price = I('usable_tw_price');
            $area            = I('area');
            $usable_area     = I('usable_area');
            $total_price     = I('total_price');
            $apartment       = I('apartment');
            $hall            = I('hall');
            $kitchen         = I('kitchen');
            $toilet          = I('toilet');
            $orientation     = I('orientation');
            $thumb           = I('thumb');

            for($i = 0; $i< count($r_name); $i++){
                $sameroom_data[$i]['houses_id']       = $houses_id;
                $sameroom_data[$i]['u_id']            = 0;
                $sameroom_data[$i]['r_name']          = $r_name[$i];
                $sameroom_data[$i]['unit_price']      = $unit_price[$i];
                $sameroom_data[$i]['bt_price']        = $bt_price[$i];
                $sameroom_data[$i]['usable_price']    = $usable_price[$i];
                $sameroom_data[$i]['usable_tw_price'] = $usable_tw_price[$i];
                $sameroom_data[$i]['area']            = $area[$i];
                $sameroom_data[$i]['usable_area']     = $usable_area[$i];
                $sameroom_data[$i]['total_price']     = $total_price[$i];
                $sameroom_data[$i]['apartment']       = $apartment[$i];
                $sameroom_data[$i]['hall']            = $hall[$i];
                $sameroom_data[$i]['kitchen']         = $kitchen[$i];
                $sameroom_data[$i]['toilet']          = $toilet[$i];
                $sameroom_data[$i]['orientation']     = $orientation[$i];
                $sameroom_data[$i]['thumb']           = $thumb[$i];
            }

            $s_ids = array();
            for ($i = 0; $i < count($sameroom_data); $i++) {
                $s_ids[$i] = D('sameroom')->add($sameroom_data[$i]);
            }

            /**
             * room表的组装和插入
             * @var integer
             */
            $m = 0;
            for($i = 0;$i<count($unit_data);$i++){//单元循环
                for ($k=$unit_data[$i]['floor_start']; $k <= $unit_data[$i]['floor_over']; $k++) {//每个单元的初始楼层到结束楼层。
                    for ($j=0; $j < $unit_data[$i]['room_num'] ; $j++){//每层楼的套房
                        $room_data[$m]['houses_id'] = $houses_id;
                        //$room_data[$m]['room_number'] = str_pad($k,2,'0',STR_PAD_LEFT)   . str_pad(($j+1),2,'0',STR_PAD_LEFT);
                        $r_name[$j] = ($r_name[$j] != '') ? $r_name[$j] :$j + 1;
                        if($unit_data[$i]['floor_start'] == $unit_data[$i]['floor_over']){//代表没有输入楼层后者相等
                            $room_data[$m]['room_number'] = ($r_name[$j]);
                        }else{
                             $room_data[$m]['room_number'] = str_pad($k,2,'0',STR_PAD_LEFT)   . str_pad(($r_name[$j]),2,'0',STR_PAD_LEFT);
                        }
                        $room_data[$m]['u_id'] = $u_ids[$i];
                        $room_data[$m]['s_id'] = $s_ids[$j];
                        $room_data[$m]['floor'] = $k;
                        $room_data[$m]['unit_price'] = $sameroom_data[$i]['unit_price'] + ($k - $unit_data[$i]['floor_start'])*$sameroom_data[$i]['bt_price']  ;
                        $room_data[$m]['usable_price'] =$sameroom_data[$i]['usable_price'] +($k - $unit_data[$i]['floor_start'])*$sameroom_data[$i]['usable_tw_price'] ;

                        $m++;
                    }
                }
            }

            if(D('room')->addAll($room_data)){
                unset($us_data);
                unset($room_data);
                unset($unit_data);
                unset($sameroom_data);
                //$this->success('新增成功', 'Room/building_list');
                $this->redirect('building_list');
            }else{
                $this->error('添加失败');
            }
            return ;
        }
        /**
         * 填写页面
         * @var [type]
         */
        $building = I();//有栋和单元的基本信息
        if(empty($building) || $building['b_id'] == '' || $building['u_order'] ==''){
            $this->redirect('building_list');
        }

        $model = 'sameroom';
        $page = intval($p);
        $page = $page ? $page : 1; //默认显示第一页数据
        $fields = get_model_attribute('15');

        $fields = $fields[1];
        unset($fields[0]);
        //unset($fields[1]);
        $this->assign('_fields', json_encode($fields));
        $this->assign('_building', $building);
        $this->assign('_title', getHouses('title'). '·' . $building['b_name'] . '·' . ($building['u_order']+1) . '单元');
        $this->display();
    }

    public function editUname()
    {
        if(IS_AJAX){
            $data['id']      = I('u_id');
            $data['u_name']    = I('u_name');
            $data['houses_id'] = getHouse();

            if(D('unit')->save($data)){
                $this->success(1);
            }else{
                $this->error(D('unit')-getError());
            }
        }
    }

    /**
     * 单元修改
     * @return [type] [description]
     */
    public function unit_edit()
    {
        is_auth(AUTH_ROOM_MANAGE);
        if(IS_POST){
            //POST请求数据类型：b_id/3/b_name/C/u_order/1/u_id/1
            $building = I();
            /**
             * 单元重写，删除unit表，us表和room表的数据
             * 修改building 的状态
             */
            if($building['u_id'] != '' || empty($building['u_id'])){
                $model = D();
                $model->startTrans();
                if($model->table('zf_room')->where('u_id='. $building['u_id'])->delete() && $model->table('zf_unit')->where('id='. $building['u_id'])->delete()){
                    $building_data = D('building')->find($building['b_id']);
                    $is_w = explode(',', $building_data['is_w']) ;
                    $is_w[$building['u_order']] = 0;
                    $building_data['is_w'] = implode(',', $is_w);
                     $model->commit();
                    if(D('building')->save($building_data)){
                        $this->redirect('unit_set',$building);
                    }
                }else{
                    $model->rollback();
                    $this->error('清除失败');
                }
            }else{
                $this->redirect('building_list');
            }
            return ;
        }
        /**
         * 填写页面
         * @var [type]
         */
        $building = I();
        if(empty($building) || $building['b_id'] == '' || $building['u_order'] ==''){
            $this->redirect('building_list');
        }
        // $page = intval($p);
        // $page = $page ? $page : 1; //默认显示第一页数据
        $fields = get_model_attribute('15');
        $fields = $fields[1];
        unset($fields[0]);

        $where['b_id']    = $building['b_id'];
        $where['u_order'] = $building['u_order'];
        $unit_data  = D('unit')->where($where)->find($id);

        if(empty($unit_data) || $unit_data == ''){
             $this->redirect('building_list');
        }
        /**
         * 通过单元ID，找到房号表中的同号房ID
         */
        $roomData = D('room')->field('s_id')->where('u_id=' . $unit_data['id'])->group('s_id')->select();
        foreach ($roomData as $value) {
            $srids[] = $value['s_id'];
        }
        $srids = implode(',', $srids);
        $wheresr['id'] = array('in', $srids);

        $field[] = 'id';
        foreach ($fields as $key => $value) {
            $field[] = $value['name'];
        }
        $sameroom_data = D('sameroom')
                        ->where($wheresr)
                        ->field(implode(',', $field))
                        ->select();
        $this->assign('_sameroom', $sameroom_data);
        $this->assign('_unit', $unit_data);
        $this->assign('_fields', $fields);
        $this->assign('_building', $building);
        $this->assign('_title', getHouses('title') . '·' . $building['b_name'] . '·' . ($building['u_order']+1));
        $this->display();
    }


    /**
     * 获取栋号
     * @return [type] [description]
     */
    public function getBuilding()
    {
        if(IS_AJAX){
            if( I('houses_id') != getHouse()){
                $this->error('系统出错，请退出去重新登录！');
            }

            if( I('status') == '1'){
                $where['houses_id'] = I('houses_id');
                $where['status']    = I('status');
                $building  = D('building')->where($where)->order('id asc')->select();
            }else{
                $whereSQL = ' (b.status = -1 or ( b.status=1 and u.status=-1 )) ';//查找那些栋状态是在售，但是其下面的单元有待售的楼
                $where['b.houses_id'] = I('houses_id');
                $building  = D('building')
                            ->table('zf_building b')
                            ->join('zf_unit as u on b.id=u.b_id','LEFT')
                            ->where($where)
                            ->where($whereSQL)
                            ->order('b.id asc')
                            ->field('b.*')
                            ->group('b.id')
                            ->select();
                // $sql = 'select b.* from zf_building b
                //         left join zf_unit as u on b.id=u.b_id
                //         where b.houses_id = '.I('houses_id').' and
                //         (b.status = -1 or ( b.status=1 and u.status=-1 ))';
                // $building = D()->query($sql);

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
            $houses_id = I('houses_id');
            $b_id = I('b_id');
            if($houses_id != getHouse() || $b_id == '' || empty($b_id)){
                $this->error('系统出错，请退出去重新登录！');
            }
            $where['houses_id'] = $houses_id;
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
            $houses_id = I('houses_id');
            $u_id = I('u_id');

            if($houses_id != getHouse() || $u_id == '' || empty($u_id)){
                $this->error('系统出错，请退出去重新登录！');
            }
            $where['r.houses_id'] = $houses_id;
            $where['r.u_id'] = $u_id;
            $where['u.status'] = I('status');
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
        //checkORredirect(is_auth(AUTH_ROOM_LS));
        /**
         * 获取房号的所有信息
         */
        $id = I('id');
        $uid = is_login();
        checkORredirect($id);
        //D('room')->where('id=' . $id)->setInc('view');
        $room = D()
                ->table('zf_room as r')
                ->where('r.id=' . $id)
                ->join('zf_sameroom as sr on r.s_id = sr.id')
                ->join('zf_unit as u on r.u_id = u.id')
                ->join('zf_building as b on u.b_id = b.id')
                ->join('zf_user as user on  r.lastop_uid = user.id','LEFT')
                ->join('zf_user as userL on r.lock_check_uid=userL.id','LEFT')
                ->join('zf_user as userS on r.submit_check_uid=userS.id','LEFT')
                ->field('r.id,r.room_number,r.view,r.status,r.floor,r.unit_price,r.usable_price,r.is_check,sr.r_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.thumb,sr.orientation,u.u_name,u.u_order,u.status as u_status,b.b_name,user.id as uid,user.nick_name,user.phone,userL.id as Luid,userL.nick_name as Lnick_name,userL.phone as Lphone,userS.id as Suid,userS.nick_name as Snick_name,userS.phone as Sphone')
                ->find();
        $room['total_price'] = number_format($room['unit_price']*$room['area']/10000.0, 2);
        $room['thumb'] = explode(',', $room['thumb']);
        if($room['thumb'][0] == '' ){
            $room['thumb'] = NULL;
        }
        $room['address'] = getHouses('address');
        //dump($room);die;
        $button = array();//存储页面中要显示的按钮
        $tip = array();//页面的一些提示内容
        if($room['u_status'] == '1'){
            switch ($room['status']) {
                case ROOM_STATUS_NSOLE://未出售
                    if(is_auth(AUTH_ROOM_LS)){
                        $button[] = $this->getButton('锁定','lock', 'status_success');
                    }
                    break;
                case ROOM_STATUS_LOCK://锁定
                    if(is_auth(AUTH_ROOM_CHECK)){//案场管理，拥有审核权限，表示房号审核的权限，可在后台或数据库中查询
                        if($room['is_check'] == '1'){/*审核通过*/
                            $tip[] = '状态：锁定(已审核)';
                            $tip[] = '锁定会员: ' . $room['nick_name'] . ' ('.$room['phone'].')';
                            //通过房号操作表去获取审核人姓名
                            $tip[] = '审核人:'.   $room['Lnick_name']  . '(' . $room['Lphone'].')';

                            $button[] = $this->getButton('解锁','unlock', 'status_error');
                            if($room['uid'] == $uid){/*案场管理自己锁定房号*/
                                $button[] = $this->getButton('成交','submit', 'status_success');
                            }
                        }else{/*审核未通过*/
                            $button[] = $this->getButton('解锁','unlock', 'status_error');
                            $tip[] = '状态：锁定(未审核)';
                            $tip[] = '申请人：' . $room['nick_name'] . ' ('.$room['phone'].')';
                            $button[] = $this->getButton('通过','check', 'status_success');
                        }
                    }else if($room['uid'] == $uid ){/*本人锁定*/
                        if($room['is_check'] == '1'){/*审核通过*/
                            $check = $this->getCheckUser($room['id'],REPORT_LOCK);
                            $tip[] = '审核人:'.   $room['Lnick_name']  . '(' . $room['Lphone'].')';
                            $button[] = $this->getButton('解锁','unlock', 'status_error');
                            $button[] = $this->getButton('成交','submit', 'status_success');
                        }else{/*审核未通过*/
                            $button[] = $this->getButton('解锁','unlock', 'status_error');
                            $button[] = $this->getButton('待审核','*', 'status_over black');
                        }
                    }else{
                        $button[] = $this->getButton('已锁定','*', 'status_over black');
                    }
                    break;
                case ROOM_STATUS_SUBMIT://已售
                    if(is_auth(AUTH_ROOM_CHECK)){
                        //案场管理，拥有审核权限，
                        //3表示房号审核的权限，可在后台或数据库中查询
                        if($room['is_check'] == '1'){/*审核通过*/
                            $check = $this->getCheckUser($room['id'],REPORT_SUBMIT);
                            $tip[] = '审核人:'.   $room['Snick_name']  . '(' . $room['Sphone'].')';
                            $tip[] = '出售人：' . $room['nick_name']  . ' ('.$room['phone'].')';
                            $button[] = $this->getButton('已出售','*', 'status_over black');
                            $button[] = $this->getButton('退房','unsubmit', 'status_error');
                        }else{/*审核未通过*/
                            $button[] = $this->getButton('取消成交','unsubmit', 'status_error');
                            $tip[] = '状态：成交 (未审核)';
                            $tip[] = '申请人：' .  $room['nick_name'] . ' ('.$room['phone'].')';
                            $button[] = $this->getButton('通过审核','check', 'status_success');
                        }
                    }else if($room['uid'] == $uid ){/*本人锁定*/
                        if($room['is_check'] == '1'){/*审核通过*/
                            $check = $this->getCheckUser($room['id'],REPORT_SUBMIT);
                            $tip[] = '审核人:'.   $room['Snick_name']  . '(' . $room['Sphone'].')';
                            $button[] = $this->getButton('已出售','*', 'status_over black');
                            $tip[]  = '本人出售';
                        }else{/*审核未通过*/
                            $button[] = $this->getButton('取消成交','unsubmit', 'status_error');
                            $button[] = $this->getButton('待审核','*', 'status_over black');
                        }
                    }else{
                        $button[] = $this->getButton('已出售','*', 'status_over black');
                    }
                    break;
                default://已售
                    # code...
                    break;
            }
        }
        // dump($room);
        // dump($button);
        // dump($tip);die;
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
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->display();
    }

    /**
     * 获取审核人信息
     * @param  [type] $r_id [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    protected function getCheckUser($r_id,$type)
    {
       return D()->table('zf_report ro')
        ->join('zf_user as user on ro.check_id = user.id')
        ->where('ro.r_id=' .$r_id . ' and ro.type=' . $type)
        ->field('user.nick_name,user.phone')
        ->order('ro.op_time desc')
        ->find();
    }
    protected function getButton($title, $method, $color)
    {
        $button['title'] = $title;
        $button['method'] = $method;
        $button['color'] = $color;
        return $button;
    }

    /**
     * 修改套房的信息
     * @return [type] [description]
     */
    public function editRoomPrice()
    {
        if(IS_POST){
            if(!is_super()){
                $this->error('无修改权限！');
            }
            $where['id'] = I('id');
            //$where['status'] = 0;//只有未出售的房子能够修改

            $date['unit_price'] = I('unit_price');
            if(D('room')->where($where)->save($date)){
                $this->success('修改成功',U('Room/room_info',array('id'=>$where['id'] )) );
            }else{
                $this->error('修改失败');
            }

        }else{
            checkORredirect(is_super(),'Room/index');
            $id = I('id');
            checkORredirect($id);
            //D('room')->where('id=' . $id)->setInc('view');
            $room = D()
                    ->table('zf_room as r')
                    ->where('r.id=' . $id)
                    ->join('zf_sameroom as sr on r.s_id = sr.id')
                    ->join('zf_unit as u on r.u_id = u.id')
                    ->join('zf_building as b on u.b_id = b.id')
                    ->field('r.id,r.room_number,r.view,r.status,r.floor,r.unit_price,r.usable_price,r.is_check,sr.r_name,sr.area,sr.apartment,sr.hall,sr.kitchen,sr.toilet,sr.thumb,u.u_name,u.u_order,b.b_name')
                    ->find();
            if($room['status'] != -1){
                $this->assign('edit', 1);
            }
            $room['total_price'] = number_format($room['unit_price']*$room['area']/10000.0, 2);
            $this->assign('room', $room);
            $this->display();
        }
    }

    /**
     * 房间操作，修改房间状态
     * @return [type] [description]
     */
    public function changeStatus()
    {
        if(IS_AJAX){

            $method = I('method');
            $hosues_id = getHouse(1);
            $uid = is_login();
            $id = I('id');
            /**
             * 在执行任何操作之前，都要判断该房号的状态是否符合要求
             */
            switch ($method) {
                case 'lock':/*请求锁定房号*/
                    //要判断发该房号是否有被锁定
                    $res = D('room')->where('id=' . $id . ' and status='.ROOM_STATUS_NSOLE)->field('id')->find();
                    if(is_null($res)){
                        $this->error('抱歉！该房间已经被锁定！');
                    }
                    $data['id'] = $id;
                    $data['status'] = ROOM_STATUS_LOCK;
                    $data['lastop_uid'] = $uid;
                    $data['lock_uid'] = $uid;
                    $data['lock_time'] = time();
                    if(is_auth(AUTH_ROOM_CHECK)){//如果拥有审核权限，直接通过审核
                        $data['is_check'] = 1;
                        $data['lock_check_uid'] = $uid;
                    }
                    if(D('room')->save($data)){
                        $this->success('锁定成功！');
                    }else{
                        $this->error('抱歉！锁定失败！');
                    }
                    break;
                case 'unlock': /*请求解锁房号*/
                    //解锁的人是否是本人或者是拥有审核权限
                    $res = D('room')->field('operationer')->find($id);
                    //既不是锁定的人，也没有审核权限，则不能解锁
                    if(!(is_auth(AUTH_ROOM_CHECK) || $res['operationer'] == is_login())){
                        $this->error('抱歉！您没有权利解锁！');
                        return ;
                    }
                    $data['id'] = $id;
                    $data['status'] = ROOM_STATUS_NSOLE;
                    $data['lastop_uid'] = 0;
                    $data['lock_uid'] = 0;
                    $data['lock_time'] = 0;
                    $data['is_check'] = 0;
                    $data['lock_check_uid'] = 0;
                    if(D('room')->save($data)){
                        $this->success('解锁成功！');
                    }else{
                         $this->error('抱歉！解锁失败！');
                    }
                    break;
                case 'submit':/*请求成交*/
                    //判断是否是本人操作，是否是锁定审核状态
                    $res =  D('room')->where('id=' . $id . ' and status=' .ROOM_STATUS_LOCK. ' and is_check=1 and operationer=' . $uid)->field('id')->find();
                    if(is_null($res)){
                        $this->error('抱歉！提交成交申请失败！');
                    }

                    $data['id'] = $id;
                    $data['status'] = ROOM_STATUS_SUBMIT;
                    $data['lastop_uid'] = $uid;
                    $data['submit_uid'] = $uid;
                    $data['submit_time'] = time();
                    if(is_auth(AUTH_ROOM_CHECK)){
                        $data['is_check'] = 1;
                        $data['submit_check_uid'] = $uid;
                    }else{
                        $data['is_check'] = 0;
                    }
                    if(D('room')->save($data)){
                        $this->success('提交成交申请成功！');
                    }else{
                         $this->error('抱歉！提交成交申请失败！');
                    }
                    break;
                case 'unsubmit':/*取消成交，退房，回复未出售状态*/
                    //撤销成交的人是否是本人或者是拥有审核权限
                    $res = D('room')->field('operationer')->find($id);
                    //既不是锁定的人，也没有审核权限，则不能解锁
                    if(!(is_auth(AUTH_ROOM_CHECK) || $res['operationer'] == is_login()) ) {
                        $this->error('抱歉！您没有权利取消成交！');
                        return ;
                    }
                    $data['id'] = $id;
                    $data['status'] = ROOM_STATUS_NSOLE;
                    $data['lastop_uid'] = 0;
                    $data['submit_uid'] = 0;
                    $data['submit_time'] = 0;
                    $data['lock_uid'] = 0;
                    $data['lock_time'] = 0;
                    $data['is_check'] = 0;
                    $data['lock_check_uid'] = 0;
                    $data['lock_sunmit_uid'] = 0;
                    if(D('room')->save($data)){
                        $this->success('撤销成功！');
                    }else{
                         $this->error('抱歉！撤销失败！');
                    }
                    break;
                case 'check':
                    if(is_auth(AUTH_ROOM_CHECK)){
                        $status = D('room')->field('status')->find($id);
                        if($status['status'] == ROOM_STATUS_LOCK){
                             $data['lock_check_uid'] = $uid;
                        }
                        if($status['status'] == ROOM_STATUS_SUBMIT){
                             $data['submit_check_uid'] = $uid;
                        }
                        $data['id'] = $id;
                        $data['is_check'] = 1;
                        if(D('room')->save($data)){
                            $this->success('提交审核成功！');
                        }else{
                             $this->error('抱歉！提交审核失败！');
                        }
                    }else{
                         $this->error('抱歉！提交审核失败！');
                    }
                    break;
                default:
                     $this->error('抱歉！操作失败！');
                    break;
            }
             $this->error('抱歉！操作失败！');
        }else{
            $this->redirect('Index/index');
        }
    }


    /**
     * 销控管理
     * @return [type] [description]
     */
    public function marketingCon()
    {
        checkORredirect(is_auth(AUTH_ROOM_MARKETINCON));
        if(IS_POST){

            /**
             * 1. 找出这个单元下已经销控的ID，设置为oldIds;
             * 2. 获取这次提交的要销控的ID，设置为newIds;
             * 3. oldIds中newIds没有的ID没有的ID就是取消销控的ID；
             * 4. newIds中oldIds没有的ID就是这次要销控的ID.
             */
            $where = array();
            $where['u_id'] =I('u_id');
            $where['status'] = ROOM_STATUS_MARKETINCON;

            $temp = D('room')->where($where)->field('id')->select();
            $oldIds = array();
            foreach ($temp as $a) {
                $oldIds[] = $a['id'];
            }
            $newIds = I('ids');

            if($newIds == ''){
                $upIds = $oldIds;//如果新的
            }else{
                $upIds  = array_diff($oldIds, $newIds);//取消销控的ID。oldIds中newids没有的ID；
            }
            //$upIds  = array_diff($oldIds, $newIds);//取消销控的ID。oldIds中newids没有的ID；
            $addIds = array_diff($newIds, $oldIds);//新增销控的ID。oldIds中newids没有的ID；

            $data = array();
            $i = 0;
            foreach ($upIds as $key=>$vo) {
                $data[$i]['id'] = $vo;
                $data[$i]['status'] = ROOM_STATUS_NSOLE;
                $data[$i]['market_uid'] =0;
                $data[$i]['market_time'] = 0;
                $i++;
            }
            foreach ($addIds as $key=>$vo) {
                $data[$i]['id'] = $vo;
                $data[$i]['status'] = ROOM_STATUS_MARKETINCON;
                $data[$i]['market_uid'] = is_login();
                $data[$i]['lastop_uid'] = is_login();
                $data[$i]['market_time'] = time();
                $i++;
            }
            $res = D('room')->saveAll($data);
            if($res != false || $res == 0){
                //room_op_log($upIds ,ROOM_OP_UNMARKETINCON);//记录取消销控的
                //room_op_log($addIds ,ROOM_OP_MARKETINCON);//记录新添加销控的
                $this->success('设置成功！');
            }else{
                $this->error('设置失败！');
            }
        }else{
            $this->assign('_title', '销控管理');
            $this->display();
        }
    }

}
 ?>