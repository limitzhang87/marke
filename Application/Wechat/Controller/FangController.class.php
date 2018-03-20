<?php
/**
 * 登录控制器
 *
 * 描述：		用户登录
 * 所属项目:	marke
 * 开发者:		张继贤
 * 创建时间:	2017/8/9 11:12 AM
 * 版权所有:	中房通(www.zfangw.cn)
 */
namespace Wechat\Controller;
use User\Api\UserApi;

/**
 * 登录控制器
 * 包括用户中心，用户登录及注册
 */
class FangController extends HomeController {


	protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }

       
    }
	



	/* 整体房号数据 */
	public function fang()
	{

	/*栋号*/	
	$arr = array ('id'=>1,'tree'=>$tree); 
	$tree = array ('id'=>1,'desc'=>'A栋',"desc2"=>'11','level'=>'level1','logo'=>'/up/i.jpg','popular'=>null,'nodes'=>$nodes); 
	/*单元号*/	
	$nodes= array($tree1);
	$tree1 = array ('id'=>2,'tree'=>$tree3)	; 
	$tree3 = array ('id'=>2,'desc'=>'1单元',"desc2"=>'1','level'=>'level2','logo'=>'/up/i.jpg','popular'=>1,'nodes'=>$nodes1); 
	/*层*/
	$nodes1= array($tree2);
	$tree2 = array ('id'=>12,'tree'=>$tree3);
	$tree3 = array ('id'=>12,'desc'=>'1层',"desc2"=>'1','level'=>'level2','logo'=>'/up/i.jpg','popular'=>1,'nodes'=>$nodes2);
	/*房号*/
	$nodes2= array($tree4);
	$tree4 = array ('id'=>15,'tree'=>$tree5); ; 
	$tree5 = array ('id'=>15,'desc'=>'101房',"desc2"=>'1','level'=>'level3','logo'=>'/up/i.jpg','popular'=>1,'nodes'=>''); 
	
	/*输出数据组*/
    $a = array($arr);
	echo json_encode($a);
	}


	

	    /**
     * 获取栋号
     * @return [type] [description]
     */
    public function getBuilding()
    {
        if(IS_AJAX){
            if(!I('houses_id')){
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


}
