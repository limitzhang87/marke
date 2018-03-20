<?php
/**
 * 统计报表控制器
 *
 * 描述：       统计报表
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/8/17 03:12 PM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;

class ReportController extends HomeController {

    protected function _initialize(){
        parent::_initialize();
        checkORredirect(AUTH_REPORT_MANAGE);
    }

    /**
     * 统计报表
     * @return [type] [description]
     */
    public function index()
    {
        //type  1:锁定，2:成交
        $type = I('type') ? I('type') : 1;
        $uid =  I('uid') ? I('uid') : '*';
        $this->assign('type',$type);
        $this->assign('uid',$uid);

        //dump();die;

        $filter = array();//过滤器列表
        //用户过滤器
        $temp['type'] = 'uid';
        $FIRST[0]['value'] = '*';
        $FIRST[0]['title'] = '会员';
        $list = D('user')
                ->order('id asc ')
                ->field('id as value,nick_name as title')
                ->select();
        $temp['data'] = array_merge($FIRST, $list);
        $filter[] =$temp;
        unset($temp);
        /**
         * 年份过滤器
         */
        $year[0]['title']  = '年份';
        $year[0]['value'] = '*';
        for ($i = 1; $i <= 2; $i++) {
            $year[$i]['title'] = date('Y')-$i+1;
            $year[$i]['value'] = strtotime($year[$i]['title'] . '-01-01 00:00:00') . '-' . strtotime($year[$i]['title'] . '-12-31 23:59:59') ;
        }
        $temp['type'] = 'year';
        $temp['data'] = $year;
        $filter[] = $temp;

        /**
         * 月份过滤器
         */
        $month[0]['title']  = '月份';
        $month[0]['value'] = '*';
        // for ($i = 1; $i <=12; $i++) {
        //     $month[$i]['title'] = str_pad($i,2,'0',STR_PAD_LEFT);
        //     //$month[$i]['value'] = strtotime(date('Y') . '-'. str_pad($i,2,'0',STR_PAD_LEFT) . '-01');
        //     $month[$i]['value'] = '*';

        // }
        unset($temp);
        $temp['type'] = 'month';
        $temp['data'] = $month;
        $filter[] = $temp;

        /**
         * 月份过滤器
         */
        $day[0]['title']  = '日期';
        $day[0]['value'] = '*';
        unset($temp);
        $temp['type'] = 'day';
        $temp['data'] = $day;
        $filter[] = $temp;
        //dump($month);die;

        $data = array();
        $data['room_total'] = D('room')->count();
        $data['nosole_total'] = D('room')->where('status=0')->count();
        $data['market_total'] = D('room')->where('status=2')->count();
        $this->assign('_filter', $filter);
        $this->assign('data', $data);
        $this->display();
    }

    public function getReportList()
    {
        if(IS_AJAX){
            /**
             * 搜索报表记录
             * 1. 要有房号状态，
             * 2. 要有审核ID
             * 注意事项
             */
            $type = I('type');
            if( $type  == 1){//锁定记录
                $where['r.status'] = array('in','1,9');
                $where['r.lock_check_uid'] = array('NEQ' ,'0');

                if(I('uid') != '*' && I('uid')){
                    $where['r.lock_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.lock_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.lock_check_uid= user2.id';
                $stime = 'r.lock_time';
            }else if($type == 2){//成交记录
                $where['r.status'] = 9;
                $where['r.submit_check_uid'] = array('NEQ' ,'0');
                if(I('uid') != '*' && I('uid')){
                    $where['r.submit_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.submit_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.submit_check_uid= user2.id';
                $stime = 'r.submit_time';
            }else{
                $where['r.status'] = 3;
                if(I('uid') != '*' && I('uid')){
                    $where['r.submit_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.submit_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.submit_check_uid= user2.id';
                $stime = 'r.submit_time';
            }

            if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                $where[$stime] = array(array('egt',$time[0]),array('lt',$time[1])) ;
            }
            $page = I('page')? I('page') : 1;
            // $where['r.is_check'] = 1 ;//已经审核
            $list = D()
                    ->table('zf_room r ')
                    ->join('zf_unit as u on r.u_id = u.id')
                    ->join('zf_building as b on u.b_id = b.id')
                    ->join($joinUser1,'LEFT')
                    ->join($joinUser2,'LEFT')
                    ->field('r.id,r.room_number,r.is_check,u.u_name,u.u_order,b.b_name,'.$stime.',user1.nick_name,user2.nick_name as check_name')
                    ->page($page)
                    ->limit(10)
                    ->order($stime . ' desc')
                    ->where($where)
                    ->select();
            $total = D()
                    ->table('zf_room r')
                    ->where($where)
                    ->count();
            $info['list'] = $list;
            $info['total'] = $total;
            $this->success($info);

        }else{
            $this->redirect('Index/index');
        }
    }


    public function downloadExcel()
    {
        if (IS_POST) {
            /**
             * 搜索报表记录
             * 1. 要有房号状态，
             * 2. 要有审核ID
             * 注意事项
             */
            $typeTitle = '操作';
            $type = I('type');
            if( $type  == 1){//锁定记录
                $where['r.status'] = array('in','1,9');
                $where['r.lock_check_uid'] = array('NEQ' ,'0');

                if(I('uid') != '*' && I('uid')){
                    $where['r.lock_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.lock_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.lock_check_uid= user2.id';
                $stime = 'r.lock_time';
                $typeTitle = '锁定';
            }else if($type == 2){//成交记录
                $where['r.status'] = 9;
                $where['r.submit_check_uid'] = array('NEQ' ,'0');
                if(I('uid') != '*' && I('uid')){
                    $where['r.submit_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.submit_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.submit_check_uid= user2.id';
                $stime = 'r.submit_time';
                $typeTitle = '成交';
            }else{
                $where['r.status'] = 3;
                if(I('uid') != '*' && I('uid')){
                    $where['r.submit_uid'] = I('uid');
                }
                $joinUser1 = 'zf_user as user1 on r.submit_uid=user1.id';
                $joinUser2 = 'zf_user as user2 on r.submit_check_uid= user2.id';
                $stime = 'r.submit_time';
            }

            if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                $where[$stime] = array(array('egt',$time[0]),array('lt',$time[1])) ;
            }
            $page = I('page')? I('page') : 1;
            // $where['r.is_check'] = 1 ;//已经审核
            $data = D()
                    ->table('zf_room r ')
                    ->join('zf_unit as u on r.u_id = u.id')
                    ->join('zf_building as b on u.b_id = b.id')
                    ->join($joinUser1,'LEFT')
                    ->join($joinUser2,'LEFT')
                    ->field('b.b_name,u.u_name,r.room_number,r.is_check,'.$stime.',user1.nick_name,user2.nick_name as check_name')
                    ->order($stime . ' desc')
                    ->where($where)
                    ->select();
           $stime = explode('.',$stime);
            foreach ($data as $key=> &$value) {
                array_unshift($value,  $key +1);
                $value['is_check'] = getYN($value['is_check']);
                $value[$stime[1]] = date('Y年m月d日 H:i',$value[$stime[1]]);
            }

            $title = array('栋名称','单元名称','房号','是否审核','审核时间',$nick_name_title . '顾问', '审核人');

            array_unshift($title, '编号');
            array_unshift($data, $title);

            if($time == null){
                $data[] = array('无日期限定');
            }else{
                $data[] = array('数据日期区间'.date('Y年m月d日',$time[0]) . '-' .  date('Y年m月d日',$time[1]));
            }

            $data[] = array( '该文件于' . date('Y年m月d日 H:i:s') . '打印,打印人:' .session('user_auth.nick_name') );
            //dump($data);die;
            downloadExcelFile($data,$typeTitle . '统计报表');
        }
    }

}
