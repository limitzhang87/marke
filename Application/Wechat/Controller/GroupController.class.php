<?php
/**
 * 分组控制器
 *
 * 描述：       分组管理
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/8/3 17:12
 * 版权所有:    中房通(www.zfangw.cn)
 */

namespace Wechat\Controller;
class GroupController extends HomeController {


    public function _initialize()
    {
        parent::_initialize();
        $id = I('get.id');
        if($id != ''){
            $this->assign('_id',$id);
        }
        $this->getGroup();

        checkORredirect(AUTH_GROUP_MANAGE);
    }

	/**
     * 分组首页，显示所有会员组
     * @return [type] [description]
     */
    public function index(){
        // $sql = 'select g.*, count(gu.uid) as usernum from zf_group g
        //         left join zf_group_user as gu on g.id = gu.g_id
        //         where g.houses_id = ' . getHouse(). '
        //         group by g.id';
        // $groupList = D()->query($sql);
        $groupList = D('group')->where('houses_id=' . getHouse())->select();
        for ($i = 0; $i < count($groupList); $i++) {
            $groupList[$i]['usernum'] = D('group_user')
                                        ->table('zf_group_user as gu')
                                        ->join('zf_user as u on gu.uid = u.id')
                                        ->where('g_id='.$groupList[$i]['id'])
                                        ->count();
        }
        $this->assign('groupList',$groupList);
        $this->display();
    }

    /**
     * 添加分组
     */
    public function add()
    {
        if(IS_POST){
            $data['houses_id'] = getHouse();
            $data['name']      = I('name');
            $data['bg_color']  = I('bg_color');
            $data['remark']    = I('remark');
            if(D('group')->add($data)){
                $this->success('添加成功', U('Group/index',array('id'=>$id)) );
            }else{
                $this->error('添加失败');
            }
        }else{
            // $list = D('group')->where('hosues_id=' . getHouse())->select();
            // dump($list);
           $this->display();
        }
    }

    /**
     * 编辑分组信息
     * @return [type] [description]
     */
    public function edit()
    {
        if(IS_POST){
            $data['id']        = I('id');
            $data['houses_id'] = getHouse();
            $data['name']      = I('name');
            $data['bg_color']  = I('bg_color');
            $data['remark']    = I('remark');
            if(D('group')->save($data)){
                $this->success('保存成功', U('Group/edit',array('id'=>$id)));
            }else{
                $this->error('保存失败');
            }
        }else{
            $where['id'] = $this->checkID();
            $where['houses_id'] = getHouse();
            $data = D('group')->where($where)->find();
            $this->assign('_data', $data);
            $this->display();
        }
    }

    /**
     * 菜单列表
     * @return [type] [description]
     */
    public function menuList()
    {
        $id = $this->checkID();

        $where['gm.g_id'] = $id;
        $where['ml.status'] = array('gt',0);
        $listT = D()
                ->table('zf_menu_list as ml')
                ->join('zf_menu_auth as ma on ml.id = ma.m_id','left')
                ->join('zf_group_menu as gm on ml.id = gm.m_id')
                ->field('ml.id,ml.icon,ml.title,ma.id as auth_id,ma.title as matitle,gm.m_auth')
                ->order('ml.id')
                ->where($where)
                ->select();
        for ($i=0; $i < count($listT); $i++) {
            $listT[$i]['auth_ids'] = explode(',', $listT[$i]['m_auth']);
            unset($listT[$i]['m_auth']);
            $auth = '';
            if($listT[$i]['auth_id'] != ''){
                $auth['id'] =  $listT[$i]['auth_id'];
                $auth['title'] =  $listT[$i]['matitle'];
            }
            if(!isset($list[$listT[$i]['id']])){
                $list[$listT[$i]['id']] = $listT[$i];
            }
            if($auth != ''){
                 $list[$listT[$i]['id']]['auth'][] = $auth;
            }
            unset( $list[$listT[$i]['id']]['auth_id']);
            unset( $list[$listT[$i]['id']]['matitle']);
        }
        // dump($list);
        // die;
        $this->assign('_list', $list);
        $this->display();
    }

    /**
     * 添加菜单功能
     * @return [type] [description]
     */
    public function menu_add()
    {
        if(IS_POST){
            //获取勾选的ID
            $ids = I('group_menu');
            $cha = 1;
            foreach ($ids as $vo) {
                if(I('s_' . $vo) != ''){
                    $sort[I('s_' . $vo)] = $vo;
                }else{
                     $sort[chr($cha)] = $vo;
                     $cha++;
                }
            }
            ksort($sort);
            $g_id = $this->checkID();
            $dataG['id']  = $g_id;
            $dataG['menu_sort']  = implode(',', $sort);
            D('group')->save($dataG);
            //添加菜单，首先是要删除前面取消勾选的选项。
            $ids = I('group_menu');
            $where['g_id'] = I('get.id');
            $where['m_id'] = array('not in', $ids);
            $res = D('group_menu')->where($where)->delete();
            if($res == false && $res  != 0){
                $this->error('删除之前的权限失败！');
            }
            $where['m_id'] = array('in', $ids);
            $list = D('group_menu')->field('m_id')->where($where)->select();
            $oldids = array_column($list,'m_id');
            $newids = array();
            //去除本身已经存在的菜单的ID
            foreach ($ids as $vo) {
                if(!in_array($vo, $oldids) ){
                     $newids[] =$vo;
                }
            }

            //组装要新添加的菜单数据
            $k = 0;
            foreach ($newids as $id) {
                $data[$k]['g_id'] = $where['g_id'];
                $data[$k]['m_id'] = $id;
                $k++;
            }
            if($data){
                if( D('group_menu')->addAll($data) ){
                     $this->success('添加权限成功！',U('Group/menuList',array('id'=>I('get.id'))) );
                }else{
                     $this->error('添加权限失败！');
                }
            }else{
                 $this->success('添加权限成功！',U('Group/menuList',array('id'=>I('get.id'))) );
            }
            return ;
        }else{
            $g_id = $this->checkID();
            $where['status'] = array('gt',0);
            $menuList = D('menu_list')->where($where)->order('id')->select();//所有菜单列表
            /**
             * 计算出那些已经添加的菜单的ID
             * @var [type]
             */
            $group_menuList = D('group_menu')->field('m_id')->where('g_id=' .  $g_id)->select();
            $gmids = array_column($group_menuList,'m_id');

            $group = D('Group')->field('menu_sort')->find($g_id);

            $sort = explode(',', $group['menu_sort']);
            for ($i = 0; $i < count($menuList); $i++) {
                $menuList[$i]['sort'] = array_search($menuList[$i]['id'],$sort ) === false ? '' :array_search($menuList[$i]['id'],$sort ) +1;
            }
            $this->assign('menuList', $menuList);
            $this->assign('gmids', $gmids);
            $this->display();
        }
    }

    /**
     * 修改权限
     * @return [type] [description]
     */
    public function menu_auth()
    {
        if(IS_POST){
            $data = I('post.');
            $i = 0;
            foreach ($data as $key => $value) {
                if(strpos($key,'gm_') !== false ){
                    $data_save[$i]['id'] = substr($key,3);
                    $data_save[$i]['m_auth'] = implode(',', $value);
                    $i++;
                }
            }
            $result = D('group_menu')->saveAll($data_save);
            if($result == false && $result  != 0){
                $this->error('权限设置失败！');
            }else{
                $this->success('权限设置成功!', U('Group/menuList',array('id'=>I('get.id'))) );
            }
            return;
        }
        $id = $this->checkID();
        $where['gm.g_id'] = $id;
        $where['ml.status'] = array('gt',0);
        $listT = D()
                ->table('zf_menu_list as ml')
                ->join('zf_menu_auth as ma on ml.id = ma.m_id','left')
                ->join('zf_group_menu as gm on ml.id = gm.m_id')
                ->field('ml.id,ml.icon,ml.title,ma.id as auth_id,ma.title as matitle,gm.id as gm_id,gm.m_auth')
                ->order('ml.id')
                ->where($where)
                ->select();
        for ($i=0; $i < count($listT); $i++) {
            $listT[$i]['auth_ids'] = explode(',', $listT[$i]['m_auth']);
            unset($listT[$i]['m_auth']);
            $auth = '';
            if($listT[$i]['auth_id'] != ''){
                $auth['id'] =  $listT[$i]['auth_id'];
                $auth['title'] =  $listT[$i]['matitle'];
            }
            if(!isset($list[$listT[$i]['id']])){
                $list[$listT[$i]['id']] = $listT[$i];
            }
            if($auth != ''){
                 $list[$listT[$i]['id']]['auth'][] = $auth;
            }
            unset( $list[$listT[$i]['id']]['auth_id']);
            unset( $list[$listT[$i]['id']]['matitle']);
        }
        $this->assign('_list', $list);
        $this->display();
    }


    /**
     * 底部列表
     * @return [type] [description]
     */
    public function bottomList()
    {
        $id = $this->checkID();

        $where['gm.g_id'] = $id;
        $where['gm.is_bottom'] = 1;
        $list = D()
                ->table('zf_bottom_nav as bn')
                ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                ->join('zf_group_menu as gm on ml.id = gm.m_id','right')
                ->field('bn.id,bn.title,bn.icon')
                ->where($where)
                ->select();
        // dump($list);
        // die;
        $this->assign('_list', $list);
        $this->display();
    }

    /**
     * 添加底部
     * @return [type] [description]
     */
    public function bottom_add()
    {
        if(IS_POST){
            /**
             * 添加底部是从先后去到当前组的菜单ID，
             * 然后判断每个菜单ID是否在传过来的菜单ID数组里面group_menu_b
             * 如果存在，则表示这个菜单ID需要底部，设置is_bottom为1，则反；
             * @var [type]
             */
            $g_id = $this->checkID();
            $gmNids = I('group_menu_b');//开启底部的菜单ID
            /**
             * 搜索某个组的拥有的菜单，然后判断开启菜单ID是否在里面，
             * 如果在里面，则修改这个组下面的菜单的数组，开启底部。
             * @var [type]
             */
            $gmList = D('group_menu')->field('id,m_id,is_bottom')->where('g_id=' . $g_id)->select();//分组菜单列表
            $ids     = array_column($gmList, 'id');
            $m_ids   = array_column($gmList, 'm_id');//菜单ID

            foreach ($gmList as $vo) {
                if($vo['is_bottom'] == 1){
                    $isBids[] = $vo['m_id'];
                }
            }
            /**
             * 循环判断那个分组下的菜单需要显示底部
             * @var integer
             */
            for ($i=0; $i < count($m_ids); $i++) {
                if( in_array($m_ids[$i], $gmNids) ){
                    $data[$i]['id'] = $ids[$i];
                    $data[$i]['is_bottom'] = 1;
                    $sort[I('s_' . $m_ids[$i])] = $m_ids[$i];
                }else{
                    $data[$i]['id'] = $ids[$i];
                    $data[$i]['is_bottom'] = 0;
                }
            }
            ksort($sort);//菜单ID根据键排序，
            $bnwhere['m_id'] = array('in', $sort);
            $bnorder ='FIELD(m_id,' . implode(',', $sort) . ')';
            $bottom = D('bottom_nav')->where($bnwhere)->field('id')->order($bnorder)->select();
            unset($sort);
            foreach ($bottom as $vo) {
                $sort[] = $vo['id'];
            }
            $dataG['id']  = $g_id;
            $dataG['bottom_sort']  = implode(',', $sort);
            //dump($dataG);die;
            D('group')->save($dataG);
            $result = D('group_menu')->saveAll($data);
            if($result == false && $result  != 0){
                $this->error('底部添加失败！');
            }else{
                $this->success('底部添加成功!', U('Group/bottomList',array('id'=>I('get.id'))) );
            }
        }else{
            $g_id = $this->checkID();
            $where['bn.status'] = array('gt',0);
            $where['ml.status'] = array('gt',0);
            $bottomList = D()
                    ->table('zf_bottom_nav as bn')
                    ->join('zf_menu_list as ml on bn.m_id = ml.id','left')
                    ->field('bn.id,bn.title,bn.icon,ml.id as m_id')
                    ->where($where)
                    ->select();

            $whereG['g_id'] = $g_id;
            $whereG['is_bottom'] = 1;
            $group_menuList = D('group_menu')->field('id,m_id')->where($whereG)->select();
            $gmids = array_column($group_menuList,'id');
            $gmm_ids = array_column($group_menuList,'m_id');
            $group = D('Group')->field('bottom_sort')->find($g_id);
            $sort = explode(',', $group['bottom_sort']);
            for ($i = 0; $i < count($bottomList); $i++) {
                $bottomList[$i]['sort'] = array_search($bottomList[$i]['id'],$sort ) === false ? '' :array_search($bottomList[$i]['id'],$sort ) +1;
            }
            $this->assign('bottomList', $bottomList);
            $this->assign('gmids', $gmids);
            $this->assign('gmm_ids', $gmm_ids);
            $this->display();
        }

    }
    /**
     * 用户列表
     * @return [type] [description]
     */
    public function user()
    {
        /*根据group_user表搜索出该分组下的会员user表*/
        $id = $this->checkID();
        $list = D()
                ->table('zf_user as u')
                ->join('zf_group_user as gu on u.id = gu.uid')
                ->field('u.id,u.phone,u.nick_name,u.head_img,u.is_activation,u.status')
                ->where('gu.g_id=' . $id)
                ->order('u.status desc')
                ->select();
        $this->assign('_list', $list);
        $this->display();
    }

    /**
     * 分组下的会员添加
     * @return [type] [description]
     */
    public function user_add()
    {
        if(IS_POST){
            $id    = I('id');
            $phone = I('phone');
            $nick_name = I('nick_name');
            //think_ucenter_md5
            $houses_title = getHouses('title');
            $uids = array();
            for($i = 0; $i < count($phone); $i++){
                $data[$i]['phone'] = $phone[$i];
                $data[$i]['password'] = '123456';
                $data[$i]['nick_name'] = $nick_name[$i];
                $data[$i]['head_img'] = './Public/Mobile/images/icon/head_img_m.png';
                if(D('user')->create($data[$i])){
                    if($uids[] = D('user')->add()){
                        //$this->success('添加成功',U('Group/user',array('id'=>$id)));
                    }else{
                        $this->error('添加失败');
                    }
                }else{
                    $this->error('添加失败！' . D('user')->getError());
                }
            }
            foreach ($uids as $key => $value) {
                $dataG[$key]['g_id'] = $id;
                $dataG[$key]['uid'] = $value;
            }

            if(D('group_user')->addAll($dataG)){
                $this->success('添加成功',U('Group/user',array('id'=>$id)));
            }else{
                $this->error('添加失败');
            }
        }else{
            $id = $this->checkID();
            $g_name = D('group')->field('name')->find($id);
            $this->assign('g_name', $g_name['name']);
            $this->display();
        }
    }

    /**
     * 删除会员组
     * @return [type] [description]
     */
    public function delGroup()
    {
        if(IS_AJAX){
            $g_id       = I('id');
            $houses_id = I('houses_id');

            if( $g_id == '' || $houses_id != getHouse()){
                $this->error('删除失败！');
            }else{

                /**
                 * 删除一个分组之前，该分组下不能有会员。
                 */
                $userList =D('group_user')
                            ->table('zf_group_user as gu')
                            ->join('zf_user as u on gu.uid = u.id')
                            ->where('g_id='.$g_id)
                            ->count();
                if($userList != 0){
                    $this->error('该分组下有会员，不能删除！');
                }
                /**
                 * 删除一个会员组需要同时删除其下面的数据
                 * 1. 会员组group, 2.会员组菜单和底部group_mune, 3. 会员组下的会员 group_user,user
                 */
                if(D('group')->delete($g_id) &&D('group_menu')->where('g_id=' . $g_id)->delete() !== false
                    && D()->execute('delete from zf_user where id in(select uid from zf_group_user where g_id= '.$g_id.' )') !== false
                     && D('group_user')->where('g_id=' .$g_id)->delete() !== false){
                    $this->success('删除成功');
                }else{
                    $this->error('删除失败！');
                }
            }
        }else{
            $this->direct('Index/index');
        }
    }

    /**
     * 判断是否有会员组ID
     * @return [type] [description]
     */
    protected function checkID()
    {
       $id = I('get.id');
        if($id == '' || empty($id)){
            $this->redirect('Group/index');
        }else{
            return $id;
        }
    }


    /**
     * 获取会员组
     * @return [type] [description]
     */
    protected function getGroup()
    {
        $this->assign('groupList', D('group')->where('houses_id=' . getHouse())->select());
    }
}