<?php
/**
 * 客户跟踪控制器
 *
 * 描述：       各户跟踪
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/11/2 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;

class TrackController extends HomeController {

	public function index()
	{
        $this->assign('_title','客户跟踪');
		$this->display();

	}

    public function lists()
    {
        $this->assign('_title','客户跟踪列表');
        $this->display();
    }
	/**
	 * AJAX获取数据列表
	 */
	public function getList2()
	{
		if(IS_AJAX){
	        $page = I('p');
	        $page = $page ? $page : 1; //默认显示第一页数据

	        //排序
	        $order = I('order');
	        if(!$order){
	        	$order = 'id desc';
	        }

	        /* 条件处理 */
            $where = I('where');
            $where = json_decode($where,1);
            if($where == null){
                $where = array();
            }

            $map = array();


            /*拥有管理权限可以查看所有数据，否者只能查看本人的*/
            if(!is_auth(AUTH_CUSTOMER_MANAGE)){
                $uid = is_login();
                $uid || $this->error('获取失败！');
                $map['uid'] = $uid;
            }

             /*根据不同类型搜索关键词*/
            $key = I('search_key')?I('search_key'):'name';
            $kw  = trim(I('kw'));
            if($kw != ''){
                $map[$key]  =   array('like','%'.$kw.'%');
            }

            /*时间条件设置*/
            if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where['first_time'] = array(array('egt',$time[0]),array('lt',$time[1]));

            }

            if(I('name') != '*' && I('name') && I('field')){
                $where[I('field')] = array('eq', I('name'));
            }

            /*状态条件*/
            $where['status'] = in_array(trim(I('status')), array('1','-1')) ? I('status') : 1;

            $map = array_merge($where, $map);


	        $row    = I('row') ? I('row'):10;
	        //读取模型数据列表
	        $name = 'cus_track';
	        $data = D($name)
	            /* 查询指定字段，不指定则查询所有字段 */
	            ->field('id,name,phone,intention,sales_name,last_time')
	            // 查询条件
	            ->where($map)
	            /* 默认通过id逆序排列 */
	            ->order($order)
	            /* 数据分页 */
	            ->page($page, $row)
	            /* 执行查询 */
	            ->select();
	        /* 查询记录总数 */
	        $count = M($name)->where($map)->count();
	        //分页
	        $info['_page'] = '';
	        if($count > $row){
	            $page = new \Think\Page($count, $row);
	            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	            $info['_page'] = $page->show();
	        }
	        foreach ($data as &$value) {
	        	$value['last_time'] = date('Y-m-d H:i:s',$value['last_time'] );
	        }

	        $info['_data'] = $data;
	        $this->success($info);
		}
	}

    /**
     * AJAX获取数据列表
     */
    public function getList ()
    {
        if(IS_AJAX){
            $model = 'cus_track';
            $page = I('page');
            $page = $page ? $page : 1; //默认显示第一页数据

            //获取模型信息
            $model = M('Model')->getByName($model);
            $model || $this->error('模型不存在！');

            //解析列表规则
            $fields = array();
            $grids  = preg_split('/[;\r\n]+/s', $model['list_grid']);//获取要读取的字段
            /* 根据获取到的字段来定义需要提取那些字段 */
            $getField = I('fields');
            if($getField != '*' && $getField != ''){
                $getField = explode(',', $getField);
                $newGrids = array();
                foreach ($getField as $value) {
                    foreach ($grids as $g) {
                        /*在总字段中提取与接受的字段相同的字段*/
                        if(strpos($g, $value.':') === 0 || strpos($g, $value.'|') === 0){
                            $newGrids[] = $g;
                            continue;
                        }
                    }
                }
                $grids = $newGrids;unset($newGrids);
            }
            /* 去除接收到的排除字段 */
            $unfields = I('unfields');
            if($unfields != '*' && $unfields != ''){
                $newUnGrids = array();
                $unfields = explode(',', $unfields);
                foreach ($unfields as $value) {
                    foreach ($grids as $g) {
                        if(strpos($g, $value.':') === 0 || strpos($g, $value.'|') === 0){
                            $newUnGrids[] = $g;
                            continue;
                        }
                    }
                }
                $grids = array_diff($grids,  $newUnGrids);unset($newUnGrids);
            }

            $grids = array_values($grids);
            foreach ($grids as &$value) { //在value前面添加一个&表示$grids和$value使用同一个内存，当$value在循环中改变的时候，$grids也改变
                // 字段:标题:链接
                $val      = explode(':', $value);
                // 支持多个字段显示
                $field   = explode(',', $val[0]);
                $value    = array('field' => $field, 'title' => $val[1]);
                if(isset($val[2])){
                    // 链接信息
                    $value['href']  =   $val[2];
                    // 搜索链接信息中的字段信息
                    preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
                }
                if(strpos($val[1],'|')){
                    // 显示格式定义
                    list($value['title'],$value['format'])   =  explode('|',$val[1]);
                }
                foreach($field as $val){
                    $array  =   explode('|',$val);
                    $fields[] = $array[0];
                }
            }
            // 过滤重复字段信息
            $fields =   array_unique($fields);

            //排序
            $order = I('order');
            if(!$order){
                $order = 'id desc';
            }


            /* 条件处理 */
            $where = I('where');
            $where = json_decode($where,1);
            if($where == null){
                $where = array();
            }

            $map = array();


            /*拥有管理权限可以查看所有数据，否者只能查看本人的*/
            if(!is_auth(AUTH_CUSTOMER_MANAGE)){
                $uid = is_login();
                $uid || $this->error('获取失败！');
                $map['uid'] = $uid;
            }

             /*根据不同类型搜索关键词*/
            $key = I('search_key')?I('search_key'):'name';
            $kw  = trim(I('kw'));
            if($kw != ''){
                $map[$key]  =   array('like','%'.$kw.'%');
            }

            /*时间条件设置*/
            if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where['first_time'] = array(array('egt',$time[0]),array('lt',$time[1]));

            }

            if(I('name') != '*' && I('name') && I('field')){
                $where[I('field')] = array('eq', I('name'));
            }

            /*状态条件*/
            $where['status'] = in_array(trim(I('status')), array('1','-1')) ? I('status') : 1;

            $map = array_merge($where, $map);
            $row    = empty($model['list_row']) ? 10 : $model['list_row'];

            //读取模型数据列表
            in_array('id', $fields) || array_push($fields, 'id');//如果要查询中的字段中没有id，则添加ID
            $name = 'cus_track';
            $data = D($name)
                /* 查询指定字段，不指定则查询所有字段 */
                ->field(empty($fields) ? true : $fields)
                // 查询条件
                ->where($map)
                /* 默认通过id逆序排列 */
                ->order($order)
                /* 数据分页 */
                ->page($page, $row)
                /* 执行查询 */
                ->select();
            /* 查询记录总数 */
            $count = M($name)->where($map)->count();
            if($data == null){
                $info['_data'] = $data;
                $info['_grids'] = $grids;
                $info['_total'] = 0;
                $this->success($info);
            }
            //分页
            $info['_page'] = '';
            if($count > $row){
                $page = new \Think\Page($count, $row);
                $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
                $info['_page'] = $page->show();
            }

            /* 统计数据 */
            $sumArray = array();
            $sumfields = 'in_province,is_deal,over';

            $sumArray = explode(',', $sumfields);
            $sumArray = array_intersect($sumArray,$fields);

            /* 查询字段变成求和字段 */
            $sfield = array();
            foreach ($sumArray as $v) {
                $sfield[] = ' sum('.$v.') as ' . $v . ' ';
            }
            $sfield = implode(',', $sfield);
            $all = D('cus_track')
                    ->where($map)
                    ->field($sfield)
                    ->find();
            //$all['out_provice'] = D('cus_track')->where(' in_province != 1 ')->where($map)->count();
            foreach ($all as &$value) {
                if($value == null || $value == ''){
                    $value = 0;
                }
            }
            $data[] = $all;
            $info['_total'] = $count;
            $info['_data'] = $data;
            $info['_grids'] = $grids;
            $this->success($info);
        }
    }

    /**
     * 接受条件获取数据
     * @return [type] [description]
     */
    public function downloadExcel()
    {
        if (IS_POST) {
            $model = 'cus_track';
            $page = I('page');
            $page = $page ? $page : 1; //默认显示第一页数据

            //获取模型信息
            $model = M('Model')->getByName($model);
            $model || $this->error('模型不存在！');

            //解析列表规则
            $fields = array();
            $grids  = preg_split('/[;\r\n]+/s', $model['list_grid']);//获取要读取的字段
            /* 根据获取到的字段来定义需要提取那些字段 */
            $getField = I('fields');
            if($getField != '*' && $getField != ''){
                $getField = explode(',', $getField);
                $newGrids = array();
                foreach ($getField as $value) {
                    foreach ($grids as $g) {
                        /*在总字段中提取与接受的字段相同的字段*/
                        if(strpos($g, $value.':') === 0 || strpos($g, $value.'|') === 0){
                            $newGrids[] = $g;
                            continue;
                        }
                    }
                }
                $grids = $newGrids;unset($newGrids);
            }
            /* 去除接收到的排除字段 */
            $unfields = I('unfields');
            if($unfields != '*' && $unfields != ''){
                $newUnGrids = array();
                $unfields = explode(',', $unfields);
                foreach ($unfields as $value) {
                    foreach ($grids as $g) {
                        if(strpos($g, $value.':') === 0 || strpos($g, $value.'|') === 0){
                            $newUnGrids[] = $g;
                            continue;
                        }
                    }
                }
                $grids = array_diff($grids,  $newUnGrids);unset($newUnGrids);
            }

            $grids = array_values($grids);
            foreach ($grids as &$value) { //在value前面添加一个&表示$grids和$value使用同一个内存，当$value在循环中改变的时候，$grids也改变
                // 字段:标题:链接
                $val      = explode(':', $value);
                // 支持多个字段显示
                $field   = explode(',', $val[0]);
                $value    = array('field' => $field, 'title' => $val[1]);
                if(isset($val[2])){
                    // 链接信息
                    $value['href']  =   $val[2];
                    // 搜索链接信息中的字段信息
                    preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
                }
                if(strpos($val[1],'|')){
                    // 显示格式定义
                    list($value['title'],$value['format'])   =  explode('|',$val[1]);
                }
                foreach($field as $val){
                    $array  =   explode('|',$val);
                    $fields[] = $array[0];
                }
            }

            // 过滤重复字段信息
            $fields =   array_unique($fields);

            //排序
            $order = I('order');
            if(!$order){
                $order = 'id desc';
            }


            /* 条件处理 */
            $where = I('where');
            $where = json_decode($where,1);
            if($where == null){
                $where = array();
            }

            $map = array();


            /*拥有管理权限可以查看所有数据，否者只能查看本人的*/
            if(!is_auth(AUTH_CUSTOMER_MANAGE)){
                $uid = I('uid');
                $uid || $this->error('获取失败！');
                $map['uid'] = $uid;
            }

             /*根据不同类型搜索关键词*/
            $key = I('search_key')?I('search_key'):'name';
            $kw  = trim(I('kw'));
            if($kw != ''){
                $map[$key]  =   array('like','%'.$kw.'%');
            }

            /*时间条件设置*/
            if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where['subscription_time'] = array(array('egt',$time[0]),array('lt',$time[1]));

            }

            if(I('name') != '*' && I('name') && I('field')){
                $where[I('field')] = array('eq', I('name'));
            }

            $map = array_merge($where, $map);
            $row = C('LIST_ROWS') ? C('LIST_ROWS') : 10;


            //读取模型数据列表
            //in_array('id', $fields) || array_push($fields, 'id');//如果要查询中的字段中没有id，则添加ID
            $name = 'cus_track';
            $data = D($name)
                /* 查询指定字段，不指定则查询所有字段 */
                ->field($fields)
                // 查询条件
                ->where($map)
                /* 默认通过id逆序排列 */
                ->order($order)
                /* 数据分页 */
                //->page($page, $row)
                /* 执行查询 */
                ->select();
             /* 统计数据 */
            $sumArray = array();
           $sumfields = 'in_province,is_deal,over';

            $sumArray = explode(',', $sumfields);
            $sumArray = array_intersect($sumArray,$fields);
            /* 查询字段变成求和字段 */
            $sfield = array();
            foreach ($sumArray as $v) {
                $sfield[] = ' sum('.$v.') as ' . $v . ' ';
            }
            $sfield = implode(',', $sfield);
            $all = D('cus_track')
                    ->where($map)
                    ->field($sfield)
                    ->find();
            foreach ($all as &$value) {
                if($value == null || $value == ''){
                    $value = 0;
                }
            }
            $a = array();
            foreach ($data[0] as $k => $v) {
                if(!isset($all[$k])){
                    $a[] = '';
                }else{
                    $a[] = $all[$k];
                }
            }
            $data[] = $a;
            foreach ($data as $key => &$value) {
                if($key < count($data)-1){
                    $temp = array();
                    foreach ($grids as $kk => $grid) {
                        $temp[$kk] = get_list_field($value,$grid,$model);
                        $temp[$kk] = $temp[$kk] == '' ? '-' : $temp[$kk] ;
                    }
                    $value = $temp;
                    array_unshift($value, $key+1);
                }else{
                    array_unshift($value, '合计');
                }
            }
            $title = array_column($grids,'title');
            array_unshift($title, '编号');

            array_unshift($data, $title);

            if($time == null){
                $data[] = array('无日期限定');
            }else{
                $data[] = array('数据日期区间'.date('Y年m月d日',$time[0]) . '-' .  date('Y年m月d日',$time[1]));
            }

            $data[] = array( '该文件于' . date('Y年m月d日 H:i:s') . '打印,打印人:' .session('user_auth.nick_name') );
            downloadExcelFile($data,I('title'));
        }
    }


	/**
	 * 数据添加
	 */
	public function add($model = 'cus_track'){
        if(!is_auth(AUTH_TRACK_ADD) && !is_auth(AUTH_TRACK_MANAGE) ){
            $this->error('抱歉，您没有访问该页面的权限！');
            return ;
        }
        //获取模型信息
        $model = M('Model')->where(array('status' => 1,'name'=>$model))->find();
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $data = I('post.');
            $data['uid'] =is_login();
            $data['status'] = 1;
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create($data) && $Model->add()){
                $this->success('添加'.$model['title'].'成功！', U('lists'));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($model['id']);
            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->assign('nick_name',get_nickname());
            $this->assign('_title','添加客户跟踪信息');
            $this->display();
        }
    }

	/**
	 * 数据修改
	 */
	public function edit($model = 'cus_track', $id = 0){
        if(!is_auth(AUTH_TRACK_ADD) && !is_auth(AUTH_TRACK_MANAGE) ){
            $this->error('抱歉，您没有访问该页面的权限！');
            return ;
        }
        //获取模型信息
        $model = M('Model')->where(array('status' => 1,'name'=>$model))->find();
        $model || $this->error('模型不存在！');

        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create() && $Model->save()){
                $this->success('保存'.$model['title'].'成功！',U('detail',array('id'=>I('id'))));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields     = get_model_attribute($model['id']);
            //获取数据
            $data       = M(get_table_name($model['id']))->find($id);
            $data || $this->error('数据不存在！');
            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->assign('_title','编辑客户跟踪信息');
            $this->display();
        }
    }

    /**
     * 自动验证规则
     * @param  [type] $Model    [description]
     * @param  [type] $model_id [description]
     * @return [type]           [description]
     */
    protected function checkAttr($Model,$model_id){
        $fields     =   get_model_attribute($model_id,false);
        $validate   =   $auto   =   array();
        foreach($fields as $key=>$attr){
            if($attr['is_must']){// 必填字段
                $validate[]  =  array($attr['name'],'require',$attr['title'].'必须!');
            }
            // 自动验证规则
            if(!empty($attr['validate_rule'])) {
                $validate[]  =  array($attr['name'],$attr['validate_rule'],$attr['error_info']?$attr['error_info']:$attr['title'].'验证错误',0,$attr['validate_type'],$attr['validate_time']);
            }
            // 自动完成规则
            if(!empty($attr['auto_rule'])) {
                $auto[]  =  array($attr['name'],$attr['auto_rule'],$attr['auto_time'],$attr['auto_type']);
            }elseif('checkbox'==$attr['type']){ // 多选型
                $auto[] =   array($attr['name'],'arr2str',3,'function');
            }elseif('datetime' == $attr['type']){ // 日期型
                $auto[] =   array($attr['name'],'strtotime',3,'function');
            }
        }
        return $Model->validate($validate)->auto($auto);
    }


    /**
     * 客户跟踪详情
     */
    public function detail()
    {
    	$id = I('id');
    	$id || $this->error('抱歉，找不到相关数据！',U('Track/index'));

    	$info = D('cus_track')->find($id);
        if(!$info){
            $this->error('抱歉，找不到相关数据！');
        }
        $user = session('user_auth');
        //判断权限1.是否是管理者，2.是否是该条记录创建者
        if(!is_auth('AUTH_TRACK_MANAGE') && $user['uid'] != $info['uid']){
            $this->error('抱歉，您不是该客户的记录者！');
        }
    	$info['log'] = D('track_log')->where(array('ct_id'=>$id))->order('time desc')->select();

    	$button = array();
    	/* 根据状态渲染按钮 */
        if($info['is_deal'] == 1){
            if($info['check_out'] == 1){
                $button[] = $this->getButton('已退房','*','status_over');
            }else{
                if($info['record'] == 1){
                    if($info['get_house'] == 1){
                        if($info['over'] == 1){
                            $button[] = $this->getButton('已完成','*','status_over');
                        }else{
                            $button[] = $this->getButton('完成','over','status_raise');
                            $button[] = $this->getButton('退房','check_out','status_success');
                        }
                    }else{
                        $button[] = $this->getButton('交房','get_house','status_raise');
                        $button[] = $this->getButton('退房','check_out','status_success');
                    }
                }else{
                    $button[] = $this->getButton('网上备案','record','status_raise');
                    $button[] = $this->getButton('退房','check_out','status_success');
                }
            }

        }else{
            $button[] = $this->getButton('成交','deal','status_raise');
        }
    	$this->assign('_info',$info);
    	$this->assign('button', $button);
        $this->assign('_title','客户跟踪详情');
        $this->assign('_right_url', U('index'));
    	$this->display();
    }
    protected function getButton($title, $method, $color)
    {
        $button['title'] = $title;
        $button['method'] = $method;
        $button['color'] = $color;
        return $button;
    }

    public function changeStatus()
    {
        if(!is_auth(AUTH_TRACK_ADD) && !is_auth(AUTH_TRACK_MANAGE) ){
            $this->error('抱歉，您没有访问该页面的权限！');
            return ;
        }
    	if (IS_AJAX) {
    		$id = I('id');
    		$method = I('method');
    		$id || $method || $this->error('提交失败！');

    		$data['id'] = $id;
    		switch ($method) {
    			case 'deal':
    				$data['is_deal'] = 1;
    				$dataT['type']   = '成交';
    				break;
                case 'record':
                    $data['record'] = 1;
                    $dataT['type']   = '网上备案' ;
                    break;
                case 'get_house':
                    $data['get_house'] = 1;
                    $dataT['type']   = '交房' ;
                    break;
    			case 'over':
    				$data['over'] = 1;
    				$dataT['type']   = '完成';
    				break;
    			case 'check_out':
    				$data['check_out'] = 1;
    				$dataT['type']   = '退房' ;
    				break;
    		}
            $data['last_time'] = time();
    		$dataT['ct_id']  = $id;
			$dataT['time']   = $data['last_time'];
            $dataT['uid']    = is_login();
			D('track_log')->add($dataT);
    		if(D('cus_track')->save($data)){
    			$this->success('提交成功');
    		}else{
    			$this->error('提交失败');
    		}
    	}
    }
  	/**
  	 * 添加记录
  	 */
    public function add_log()
    {
    	if (IS_AJAX) {
            $data['ct_id']  = I('id');
            $data['time']   = time();
            $data['type']   = I('type');
            $data['remark'] = I('remark');
            $data['uid']    = is_login();

            $dataCT['id'] = I('id');
            $dataCT['last_time'] = $data['time'];
			if($data['ct_id']){
				if(D('track_log')->add($data) && D('cus_track')->save($dataCT) ){
					$data['time'] = date('Y-m-d H:i:s',$data['time']);
					$this->success($data);
				}else{
					$this->error('提交失败');
				}
			}else{
				$this->error('提交失败');
			}
    	}
    }


    /**
     * 修改状态
     *     加入回收站，还原，测底删除
     * @return [type] [description]
     */
    public function status()
    {
        if(IS_AJAX){
            $id = I('id');
            $id || $this->error('删除失败！');
            $option = I('option');
            switch($option){
                case 'del':
                    if(D('track_log')->where( array('ct_id'=>$id) )->delete() !== false &&
                        D('cus_track')->where(array('status'=>-1))->delete($id)){
                        $this->success('删除成功！');
                    }else{
                        $this->error('删除失败！');
                    }
                    break;
                case 'recycle':
                    $data['status'] = -1;
                    $data['id'] = $id;
                    if(D('cus_track')->save($data)){
                        $this->success('加入回收站成功！');
                    }else{
                        $this->error('加入回收站失败！');
                    }
                    break;
                case 'unrecycle':
                    $data['status'] = 1;
                    $data['id'] = $id;
                    if(D('cus_track')->save($data)){
                        $this->success('还原成功！');
                    }else{
                        $this->error('还原失败！');
                    }
                    break;
                default:
                    $this->success('操作失败！');

            }
        }
    }


    /**
     * 未成交客户跟踪分析统计表
     * @return [type] [description]
     */
    public function un_done()
    {
        $field = '*';
        $where['is_deal'] = array('neq',1);
        $this->assign('where', json_encode($where));
        $this->assign('_title','未成交客户跟踪分析统计表');
        $this->assign('search_key',$field);

        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 已成交客户统计表
     * @return [type] [description]
     */
    public function done()
    {
        $where['is_deal'] = array('eq',1);
        $this->assign('where', json_encode($where));
        $this->assign('_title','已成交客户统计表');
        $filter = $this->getDateFilter();
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 按置业顾姓名查询统计表
     * @return [type] [description]
     */
    public function sales()
    {
        $field = 'sales_name';
        $this->assign('_title','按置业顾姓名查询统计表');
        $this->assign('search_key',$field);

        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 按更新时间跟踪分析统计表
     * @return [type] [description]
     */
    public function last_time()
    {
        $field = '*';
        $this->assign('_title','按更新时间跟踪分析统计表');
        $this->assign('order','last_time desc');
        $this->assign('search_key',$field);
        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 省内客户跟踪统计表
     * @return [type] [description]
     */
    public function in_province()
    {
        $field = '*';
        $where['in_province'] = array('eq',1);
        $this->assign('where', json_encode($where));
        $this->assign('_title','省内客户跟踪统计表');
        $this->assign('search_key',$field);

        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }
    /**
     * 省外客户跟踪统计表
     * @return [type] [description]
     */
    public function out_province()
    {
        $field = '*';
        $where['in_province'] = array('neq',1);
        $this->assign('where', json_encode($where));
        $this->assign('_title','省外客户跟踪统计表');
        $this->assign('search_key',$field);

        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 按首次登记时间排统计表
     * @return [type] [description]
     */
    public function first_time()
    {
        $field = '*';
        $this->assign('_title','按首次登记时间排统计表');
        $this->assign('search_key',$field);
        $this->assign('order','first_time desc');
        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycleList()
    {
        $field = '*';

        $this->assign('status',-1);

        $this->assign('_title','回收站');
        $this->assign('search_key',$field);
        $this->assign('order','first_time desc');
        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common');
    }


    /**
     * 组装过滤器
     * @param  string $fields 字段名称，如置业顾问sales，分销商distribution
     * @return array         过滤条件数组
     */
    protected function getDateFilter($fields = '*')
    {
        $filter = array();//过滤器列表

        /*类型过去*/
        if($fields != '*' && $fields != ''){
            $temp['type'] = 'name';
            $FIRST[0]['value'] = '*';
            $FIRST[0]['title'] = '全部';
            $list = D('cus_track')
                    ->order('id asc ')
                    ->field($fields . ' as title,' . $fields . ' as value')
                    ->group($fields)
                    ->where(array($fields=>array('neq','') ))
                    ->select();

            $temp['data'] = array_merge($FIRST, $list);
            $filter[] =$temp;
            unset($temp);
        }

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
        return $filter;
    }
}

