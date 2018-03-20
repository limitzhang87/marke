<?php
/**
 * 客户信息控制器
 *
 * 描述：       客户信息
 * 所属项目:    marke
 * 开发者:      张继贤
 * 创建时间:    2017/10/24 11:12 AM
 * 版权所有:    中房通(www.zfangw.cn)
 */
namespace Home\Controller;

class CustomerController extends HomeController {

	protected function _initialize(){
	 	parent::_initialize();
	 	$this->assign('_right_url', U('Customer/index'));
	 	$this->assign('uid',is_login());
	}

	public function index()
	{
		$this->assign('_right_url', U('Index/index'));
		$this->display();

	}

	/**
	 * 详情页
	 * @return  [description]
	 */
	public function detail()
	{
		$id = I('id');

		$model = M('Model')->where(array('status' => 1,'name'=>'customer'))->find();
		$fields     = get_model_attribute($model['id']);
        //获取数据
        $data       = M(get_table_name($model['id']))->find($id);
        $data || $this->error('数据不存在！');

        $groups = parse_config_attr($model['field_group']);
        $groupT[1] = '基础';
        $groupT[2] = '合同';
        $groupT[3] = '佣金';

        $fieldsT[1] = array_merge($fields[1],$fields[2]);
        $fieldsT[2] = array_merge($fields[3],$fields[4]);
        $fieldsT[3] = array_merge($fields[5],$fields[6],$fields[7],$fields[8]);
        $this->assign('model', $model);
        $this->assign('fields', $fieldsT);
		$this->assign('groups',$groupT);
        $this->assign('data', $data);

		$this->assign('info',$info);
		$this->display();
	}
	/**
	 * 数据添加
	 */
	public function add($model = 'customer'){
		if(!is_auth(AUTH_CUSTOMER_ADD)){
			$this->error('抱歉，您没有访问该页面的权限！');
			return ;
		}
        //获取模型信息
        $model = M('Model')->where(array('status' => 1,'name'=>'customer'))->find();
        $model || $this->error('模型不存在！');
        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            //将一些常用的数据保存在cookie中
            $temp['intention_money']    = I('intention_money');
			$temp['deposit']            = I('deposit');
			$temp['unit_price']         = I('unit_price');
			$temp['area']               = I('area');
			$temp['sales']              = I('sales');
			$temp['sales_point']        = I('sales_point');
			$temp['distribution_point'] = I('distribution_point');
			$temp['distribution']       = I('distribution');
			$temp['manager_point']      = I('manager_point');
			$temp['manager']            = I('manager');
			$temp['supervisor_point']   = I('supervisor_point');
			$temp['supervisor']         = I('supervisor');

            if(cookie('temp_data') != $temp){
            	cookie('temp_data', $temp);
            }
            unset($data);
            $data = I('post.');
            $data['uid'] = $user['uid'];
            $data['uid'] = is_login();
            $data['created_time'] = date('Y-m-d H:i:s');
            // 获取模型的字段信息
            $Model  =  $this->checkAttr($Model,$model['id']);
            if($Model->create($data) && $Model->add()){
                $this->success('添加'.$model['title'].'成功！', U('all'));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($model['id']);
            $this->assign('model', $model);
            $this->assign('fields', $fields);
            $temp_data = cookie('temp_data');
            if(!$temp_data && !$temp_data['sales']){
            	$user = session('user_auth');
            	$temp_data['sales'] = $user['nick_name'];
            }
            $this->assign('temp_data', json_encode($temp_data));
            $this->assign('_title','新增合同');
            $this->display();
        }
    }

	/**
	 * 数据修改
	 */
	public function edit($model = 'customer', $id = 0){
		if(!is_auth(AUTH_CUSTOMER_ADD)){
			$this->error('抱歉，您没有访问该页面的权限！');
			return ;
		}
        //获取模型信息
        $model = M('Model')->where(array('status' => 1,'name'=>'customer'))->find();
        $model || $this->error('模型不存在！');

        if(IS_POST){
            $Model  =   D(parse_name(get_table_name($model['id']),1));
            // 获取模型的字段信息
            $Model  =   $this->checkAttr($Model,$model['id']);
            if($Model->create() && $Model->save()){
                $this->success('保存'.$model['title'].'成功！');
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
            $this->assign('_title','编辑合同');
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
	 * AJAX获取数据列表
	 */
	public function getList ()
	{
		if(IS_AJAX || IS_POST){
			$model = 'customer';
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
	                $value['href']	=	$val[2];
	                // 搜索链接信息中的字段信息
	                preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
	            }
	            if(strpos($val[1],'|')){
	                // 显示格式定义
	                list($value['title'],$value['format'])   =  explode('|',$val[1]);
	            }
	            foreach($field as $val){
	                $array	=	explode('|',$val);
	                $fields[] = $array[0];
	            }
	        }
	        // 过滤重复字段信息
	        $fields =   array_unique($fields);

	        /* 条件处理 */
	        $where = I('where');
	        $where = json_decode($where,1);
	        if($where == null){
	        	$where = array();
	        }

			$map = array();


			/*拥有管理权限可以查看所有数据，否者只能查看本人的*/
			if(!is_auth(AUTH_CUSTOMER_MANAGE)){
				// $uid = I('uid');
	   			//$uid || $this->error('获取失败！');
	            $map['uid'] = is_login();
			}

             /*根据不同类型搜索关键词*/
			$key = I('search_key')?I('search_key'):'name';
			$kw  = I('kw');
			if(is_array($kw)){
				$map[$key]	=	array($kw[0],$kw[1]);
			}else{
				if($kw != ''){
		            $map[$key]	=	array('like','%'.$kw.'%');
		        }
			}

			//$this->ajaxReturn($map[$key]);

	        /*时间条件设置*/
	        $time_style = I('time_style');

	        $timestyle[0] = 'created_time';
	        $timestyle[1] = 'intention_time';
	        $timestyle[2] = 'subscription_time';
	        $timestyle[3] = 'deposit_time';
	        $timestyle[4] = 'deposit_time';
	        $timestyle[5] = 'down_payment_time';
	        $timestyle[5] = 'check_out_time';
            if(!in_array(trim($time_style),$timestyle)){
            	$time_style = 'created_time';
            }
	        if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where[$time_style] = array(array('egt',$time[0]),array('lt',$time[1]));
            }

            if(I('name') != '*' && I('name') && I('field')){
            	$where[I('field')] = array('eq', I('name'));
            }

            //排序
	        $order = I('order');
	        if(!$order){
	        	$order = $time_style . ' desc';
	        }

	        $map = array_merge($where, $map);
	        $row    = C('LIST_ROWS') ? C('LIST_ROWS') : 10;


	        //读取模型数据列表
	        in_array('id', $fields) || array_push($fields, 'id');//如果要查询中的字段中没有id，则添加ID
	        $name = 'customer';
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
			$sumfields = 'is_over,intention_money,is_intention,return_money,deposit,deposit_return,contract_money,down_payment,ot_payment,bank_mortgage,installment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,decoration_money,decoration_receive_money,check_out,check_out_money,get_check_out_money,in_province,base_commission,sales_commission,sales_bonus,sales_receive_commission,sales_receive_bonus,sales_return_commission,distribution_commission,distribution_bonus,dis_receive_commission,dis_receive_bonus,dis_return_commission,manager_commission,manager_bonus,manager_receive_commission,manager_receive_bonus,manager_return_commission,supervisor_commission,supervisor_bonus,supervisor_receive_commission,supervisor_receive_bonus,supervisor_return_commission';

			$sumArray = explode(',', $sumfields);
			$sumArray = array_intersect($sumArray,$fields);

			/* 查询字段变成求和字段 */
			$sfield = array();
			foreach ($sumArray as $v) {
				$sfield[] = ' sum('.$v.') as ' . $v . ' ';
			}
			$sfield = implode(',', $sfield);
			$all = D('customer')
					->where($map)
					->field($sfield)
					->find();
			//$all['out_provice'] = D('customer')->where(' in_province != 1 ')->where($map)->count();
			foreach ($all as &$value) {
				if($value == null || $value == ''){
					$value = 0;
				}
			}

			if(IS_AJAX){
				$data[] = $all;
				$info['_total'] = $count;
		        $info['_data'] = $data;
		        $info['_grids'] = $grids;
		        $this->success($info);
			}
			if(IS_POST){
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
			        		$temp[$kk] = $temp[$kk] == ''? '-' : $temp[$kk] ;
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
	}



	/**
     * 合同管理汇总表
     */
    public function statistics()
    {
    	if(!is_auth(AUTH_CUSTOMER_MANAGE)){
			$this->error('抱歉，您没有访问该页面的权限！');
			return ;
		}
    	$this->assign('_title','合同管理汇总表');
    	$field = '*';
    	$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
    	$this->display();
    }

    /**
     * AJAX获取统计数据
     * @return [type] [description]
     */
    public function getStastics()
    {
    	if(IS_AJAX || IS_POST){
    		/* 字段处理*/
			$fields = I('fields');
			$sumArray = array();
			if($fields == '*' || $fields == ''){
				$fields = 'intention_money,is_intention,return_money,deposit,deposit_return,contract_money,down_payment,ot_payment,bank_mortgage,installment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,decoration_money,decoration_receive_money,check_out,check_out_money,get_check_out_money,in_province,base_commission,sales_commission,sales_bonus,sales_receive_commission,sales_receive_bonus,sales_return_commission,distribution_commission,distribution_bonus,dis_receive_commission,dis_receive_bonus,dis_return_commission';
			}
			$sumArray = explode(',', $fields);

			foreach ($sumArray as $value) {
				$field[] = ' sum('.$value.') as ' . $value . ' ';
			}
			$field = implode(',', $field);


			/* 条件处理 */
			$where = I('where');
			if($where == ''){
				$where = array();
			}else{
				$where = json_decode($where,1);
			}

			// 根据不同类型搜索关键词
			$map = array();
			$key = I('search_key')?I('search_key'):'name';
			$kw  = trim(I('kw'));
	        if($kw != ''){
	            $map[$key]	=	array('like','%'.$kw.'%');
	        }

			$where = array_merge($where, $map);


             /*时间条件设置*/
	        $time_style = I('time_style');

	        $timestyle[0] = 'created_time';
	        $timestyle[1] = 'intention_time';
	        $timestyle[2] = 'subscription_time';
	        $timestyle[3] = 'deposit_time';
	        $timestyle[4] = 'deposit_time';
	        $timestyle[5] = 'down_payment_time';
	        $timestyle[5] = 'check_out_time';
            if(!in_array(trim($time_style),$timestyle)){
            	$time_style = 'created_time';
            }
	        if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where[$time_style] = array(array('egt',$time[0]),array('lt',$time[1]));
            }


            if(I('name') != '*' && I('name') && I('field')){
            	$where[I('field')] = array('eq', I('name'));
            }


			$all = D('customer')
					->where($where)
					->field($field)
					->find();
			$total =  D('customer')->where($where)->count();
			$all['total'] = $total ;
			$all['contract_receive_money'] = $all['down_payment'] + $all['get_loan_amout'] + $all['progress_payment_1'] + $all['progress_payment_2'] + $all['progress_payment_3'];

			$all['unget_loan_amout'] = $all['loan_amout'] - $all['get_loan_amout'];

			$all['contract_unreceive_money'] = $all['contract_money'] - $all['contract_receive_money'];
			$all['unget_check_out_money'] = $all['check_out_money'] - $all['get_check_out_money'];
			$all['contract_total'] = D('customer')->where(array('contract_no'=>array('neq','')) )->where($where)->count();
			$all['distribution_num'] = D('customer')->where(array('distribution'=>array('neq','')) )->where($where)->count();
			$all['distribution_construct_num'] = D('customer')->where(array('distribution'=>array('neq',''),'contract_no'=>array('neq','')) )->where($where)->count();

			$all['free'] = $total - $all['distribution_num'];
			$all['free_construct_num'] = $all['contract_total']- $all['distribution_construct_num'];
			$all['out_province'] = $total - $all['in_province'];
			$all['decoration_unreceive_money'] = $all['decoration_money'] - $all['decoration_receive_money'];
			$all['sales_unreceive_commission'] = $all['sales_commission'] - $all['sales_receive_commission'];
			$all['sales_unreceive_bonus'] = $all['sales_bonus'] - $all['sales_receive_bonus'];
			$all['dis_unreceive_commission'] = $all['distribution_commission'] - $all['dis_receive_commission'];
			$all['dis_unreceive_bonus'] = $all['distribution_bonus'] - $all['dis_receive_bonus'];
			foreach ($all as &$value) {
				if($value == null || $value == ''){
					$value = 0;
				}
			}
			$data = $this->setData($all);
			if(IS_AJAX){
				$this->success($data);
			}
			if(IS_POST){
				$newData = array();
				foreach ($data as &$value) {
					unset($value['field']);
				}
				foreach ($data as $key => &$value)
				{
					array_unshift($value,$key+1);
				}
				$title = array('编号','title'=>'统计名称','统计值');
				array_unshift($data,$title);
				if($time == null){
		        	$data[] = array('无日期限定');
		        }else{
		        	$data[] = array('数据日期区间'.date('Y年m月d日',$time[0]) . '-' .  date('Y年m月d日',$time[1]));
		        }
		        $data[] = array( '该文件于' . date('Y年m月d日 H:i:s') . '打印,打印人:' .session('user_auth.nick_name') );
				downloadExcelFile($data,I('title'));
			}
    	}
    }


   protected function setData($all)
   {
   		$temp['field'] = 'intention_money';
		$temp['title'] = '意向登记金额合计';
		$temp['value'] = '￥' . $all['intention_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'is_intention';
		$temp['title'] = '意向登记人数';
		$temp['value'] = $all['is_intention'] . '人';
		$data[] = $temp;

		$temp['field'] = 'return_money';
		$temp['title'] = '已退意向金人数';
		$temp['value'] =   $all['return_money']  . '人';
		$data[] = $temp;

		$temp['field'] = 'deposit';
		$temp['title'] = '已收定金额合计（含意向金）';
		$temp['value'] =  '￥' . $all['deposit']  . '元';
		$data[] = $temp;

		$temp['field'] = 'deposit_return';
		$temp['title'] = '已退定金金额合计';
		$temp['value'] =  '￥' . $all['deposit_return']  . '元';
		$data[] = $temp;

		$temp['field'] = 'contract_money';
		$temp['title'] = '合同总金额合计';
		$temp['value'] = '￥' . $all['contract_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'contract_receive_money';
		$temp['title'] = '合同已收款总金额';
		$temp['value'] = '￥' . $all['contract_receive_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'contract_unreceive_money';
		$temp['title'] = '合同未收款总额';
		$temp['value'] = '￥' . $all['contract_unreceive_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'down_payment';
		$temp['title'] = '已 收首付（含定金）合计';
		$temp['value'] = '￥' . $all['down_payment'] . '元';
		$data[] = $temp;

		$temp['field'] = 'progress_payment_1';
		$temp['title'] = '进度款一合计';
		$temp['value'] = '￥' . $all['progress_payment_1'] . '元';
		$data[] = $temp;

		$temp['field'] = 'progress_payment_2';
		$temp['title'] = '进度款二合计';
		$temp['value'] = '￥' . $all['progress_payment_2'] . '元';
		$data[] = $temp;

		$temp['field'] = 'progress_payment_3';
		$temp['title'] = '进度款三合计';
		$temp['value'] = '￥' . $all['progress_payment_3'] . '元';
		$data[] = $temp;

		$temp['field'] = 'loan_amout';
		$temp['title'] = '银行按揭贷款金额合计';
		$temp['value'] = '￥' . $all['loan_amout'] . '元';
		$data[] = $temp;

		$temp['field'] = 'get_loan_amout';
		$temp['title'] = '已收银行按揭贷款金额合计';
		$temp['value'] = '￥' . $all['get_loan_amout'] . '元';
		$data[] = $temp;

		$temp['field'] = 'unget_loan_amout';
		$temp['title'] = '未收银行按揭贷款金额合计';
		$temp['value'] = '￥' . $all['unget_loan_amout'] . '元';
		$data[] = $temp;

		$temp['field'] = 'decoration_money';
		$temp['title'] = '装修款合计';
		$temp['value'] = '￥' . $all['decoration_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'decoration_receive_money';
		$temp['title'] = '已收装修款合计';
		$temp['value'] = '￥' . $all['decoration_receive_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'decoration_unreceive_money';
		$temp['title'] = '未收装修款合计';
		$temp['value'] = '￥' . $all['decoration_unreceive_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'check_out';
		$temp['title'] = '退房人数合计';
		$temp['value'] = $all['check_out'] . '人';
		$data[] = $temp;

		$temp['field'] = 'check_out_money';
		$temp['title'] = '退房退款总金额';
		$temp['value'] = '￥' . $all['check_out_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'get_check_out_money';
		$temp['title'] = '已退退房退款金额合计';
		$temp['value'] = '￥' . $all['get_check_out_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'unget_check_out_money';
		$temp['title'] = '未退退房退款金额合计';
		$temp['value'] = '￥' . $all['unget_check_out_money'] . '元';
		$data[] = $temp;

		$temp['field'] = 'total';
		$temp['title'] = '客户人数';
		$temp['value'] = $all['total'] . '人';
		$data[] = $temp;

		$temp['field'] = 'contract_total';
		$temp['title'] = '合同总份数';
		$temp['value'] = $all['contract_total'] . '份';
		$data[] = $temp;


		$temp['field'] = 'distribution_num';
		$temp['title'] = '分销商客户人数';
		$temp['value'] = $all['distribution_num'] . '人';
		$data[] = $temp;

		$temp['field'] = 'free';
		$temp['title'] = '自来客户人数';
		$temp['value'] = $all['free'] . '人';
		$data[] = $temp;

		$temp['field'] = 'distribution_construct_num';
		$temp['title'] = '分销商客户销售合同总份数';
		$temp['value'] = $all['distribution_construct_num'] . '份';
		$data[] = $temp;

		$temp['field'] = 'free_construct_num';
		$temp['title'] = '自来客户销售合同总份数';
		$temp['value'] = $all['free_construct_num'] . '份';
		$data[] = $temp;

		$temp['field'] = 'ot_payment';
		$temp['title'] = '一次性付款人数合计';
		$temp['value'] = $all['ot_payment'] . '人';
		$data[] = $temp;

		$temp['field'] = 'bank_mortgage';
		$temp['title'] = '银行按揭人数合计';
		$temp['value'] = $all['bank_mortgage'] . '人';
		$data[] = $temp;

		$temp['field'] = 'installment';
		$temp['title'] = '分期付款人数合计';
		$temp['value'] = $all['installment'] . '人';
		$data[] = $temp;

		$temp['field'] = 'in_province';
		$temp['title'] = '省内购房人数合计';
		$temp['value'] =  $all['in_province']  . '人';
		$data[] = $temp;

		$temp['field'] = 'out_province';
		$temp['title'] = '省外购房人数合计';
		$temp['value'] =  $all['out_province'] . '人';
		$data[] = $temp;

		$temp['field'] = 'base_commission';
		$temp['title'] = '佣金基数合计';
		$temp['value'] = '￥' . $all['base_commission'] . '元';
		$data[] = $temp;


		$temp['field'] = 'sales_commission';
		$temp['title'] = '置业顾问佣金金额合计';
		$temp['value'] = '￥' . $all['sales_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'sales_bonus';
		$temp['title'] = '置业顾问奖金金额合计';
		$temp['value'] = '￥' . $all['sales_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'sales_receive_commission';
		$temp['title'] = '置业顾问已领取佣金合计';
		$temp['value'] = '￥' . $all['sales_receive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'sales_receive_bonus';
		$temp['title'] = '置业顾问已领取奖金合计';
		$temp['value'] = '￥' . $all['sales_receive_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'sales_return_commission';
		$temp['title'] = '置业顾问退回佣金合计';
		$temp['value'] = '￥' . $all['sales_return_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'sales_unreceive_commission';
		$temp['title'] = '置业顾问未领取佣金合计';
		$temp['value'] = '￥' . $all['sales_unreceive_commission']. '元';
		$data[] = $temp;

		$temp['field'] = 'sales_unreceive_bonus';
		$temp['title'] = '置业顾问未领取奖金合计';
		$temp['value'] = '￥' . $all['sales_unreceive_bonus'] . '元';
		$data[] = $temp;


		$temp['field'] = 'distribution_commission';
		$temp['title'] = '分销商佣金合计';
		$temp['value'] = '￥' . $all['distribution_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'distribution_bonus';
		$temp['title'] = '分销商奖金、成交金合计';
		$temp['value'] = '￥' . $all['distribution_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'dis_receive_commission';
		$temp['title'] = '分销商已领取佣金合计';
		$temp['value'] = '￥' . $all['dis_receive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'dis_receive_bonus';
		$temp['title'] = '分销商已领取奖金、成交金合计';
		$temp['value'] = '￥' . $all['dis_receive_bonus'] . '元';
		$data[] = $temp;


		$temp['field'] = 'dis_unreceive_commission';
		$temp['title'] = '分销商未领取佣金合计';
		$temp['value'] = '￥' . $all['dis_unreceive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'dis_unreceive_bonus';
		$temp['title'] = '分销商未领取奖金合计';
		$temp['value'] = '￥' . $all['dis_unreceive_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'intention_money';
		$temp['title'] = '分销商退回的佣金合计';
		$temp['value'] = '￥' . $all['dis_return_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'manager_bonus';
		$temp['title'] = '渠道经理奖金合计';
		$temp['value'] = '￥' . $all['manager_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'manager_receive_commission';
		$temp['title'] = '渠道经理已领取佣金合计';
		$temp['value'] = '￥' . $all['manager_receive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'manager_receive_bonus';
		$temp['title'] = '渠道经理已领取奖金合计';
		$temp['value'] = '￥' . $all['manager_receive_bonus'] . '元';
		$data[] = $temp;


		$temp['field'] = 'manager_unreceive_commission';
		$temp['title'] = '渠道经理未领取佣金合计';
		$temp['value'] = '￥' . $all['manager_unreceive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'manager_unreceive_bonus';
		$temp['title'] = '渠道经理未领取奖金合计';
		$temp['value'] = '￥' . $all['manager_unreceive_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'intention_money';
		$temp['title'] = '渠道经理退回的佣金合计';
		$temp['value'] = '￥' . $all['manager_return_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'supervisor_bonus';
		$temp['title'] = '案场主管奖金合计';
		$temp['value'] = '￥' . $all['supervisor_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'supervisor_receive_commission';
		$temp['title'] = '案场主管已领取佣金合计';
		$temp['value'] = '￥' . $all['supervisor_receive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'supervisor_receive_bonus';
		$temp['title'] = '案场主管已领取奖金合计';
		$temp['value'] = '￥' . $all['supervisor_receive_bonus'] . '元';
		$data[] = $temp;


		$temp['field'] = 'supervisor_unreceive_commission';
		$temp['title'] = '案场主管未领取佣金合计';
		$temp['value'] = '￥' . $all['supervisor_unreceive_commission'] . '元';
		$data[] = $temp;

		$temp['field'] = 'supervisor_unreceive_bonus';
		$temp['title'] = '案场主管未领取奖金合计';
		$temp['value'] = '￥' . $all['supervisor_unreceive_bonus'] . '元';
		$data[] = $temp;

		$temp['field'] = 'intention_money';
		$temp['title'] = '案场主管退回的佣金合计';
		$temp['value'] = '￥' . $all['supervisor_return_commission'] . '元';
		$data[] = $temp;
		return $data;
   }


   	public function downloadStastic()
   	{
   		if(IS_POST){
    		/* 字段处理*/
			$fields = I('fields');
			$sumArray = array();
			if($fields == '*' || $fields == ''){
				$fields = 'intention_money,is_intention,return_money,deposit,deposit_return,contract_money,down_payment,ot_payment,bank_mortgage,installment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,decoration_money,decoration_receive_money,check_out,check_out_money,get_check_out_money,in_province,base_commission,sales_commission,sales_bonus,sales_receive_commission,sales_receive_bonus,sales_return_commission,distribution_commission,distribution_bonus,dis_receive_commission,dis_receive_bonus,dis_return_commission';
			}
			$sumArray = explode(',', $fields);

			foreach ($sumArray as $value) {
				$field[] = ' sum('.$value.') as ' . $value . ' ';
			}
			$field = implode(',', $field);


			/* 条件处理 */
			$where = I('where');
			if($where == ''){
				$where = array();
			}else{
				$where = json_decode($where,1);
			}

			// 根据不同类型搜索关键词
			$map = array();
			$key = I('search_key')?I('search_key'):'name';
			$kw  = trim(I('kw'));
	        if($kw != ''){
	            $map[$key]	=	array('like','%'.$kw.'%');
	        }

			$where = array_merge($where, $map);


	        /*时间条件设置*/
	        if(I('time') != '*' && I('time')){
                $time = explode('-',I('time'));
                //时间的判断是>= 小的，  <大的,即一个半开区间 [1,2)
                $where['subscription_time'] = array(array('egt',$time[0]),array('lt',$time[1]));

            }

            if(I('name') != '*' && I('name') && I('field')){
            	$where[I('field')] = array('eq', I('name'));
            }


			$all = D('customer')
					->where($where)
					->field($field)
					->find();
			$total =  D('customer')->where($where)->count();
			$all['total'] = $total ;
			$all['contract_receive_money'] = $all['down_payment'] + $all['get_loan_amout'] + $all['progress_payment_1'] + $all['progress_payment_2'] + $all['progress_payment_3'];

			$all['unget_loan_amout'] = $all['loan_amout'] - $all['get_loan_amout'];

			$all['contract_unreceive_money'] = $all['contract_money'] - $all['contract_receive_money'];
			$all['unget_check_out_money'] = $all['check_out_money'] - $all['get_check_out_money'];
			$all['contract_total'] = D('customer')->where(array('contract_no'=>array('neq','')) )->where($where)->count();
			$all['distribution_num'] = D('customer')->where(array('distribution'=>array('neq','')) )->where($where)->count();
			$all['distribution_construct_num'] = D('customer')->where(array('distribution'=>array('neq',''),'contract_no'=>array('neq','')) )->where($where)->count();

			$all['free'] = $total - $all['distribution_num'];
			$all['free_construct_num'] = $all['contract_total']- $all['distribution_construct_num'];
			$all['out_province'] = $total - $all['in_province'];
			$all['decoration_unreceive_money'] = $all['decoration_money'] - $all['decoration_receive_money'];
			$all['sales_unreceive_commission'] = $all['sales_commission'] - $all['sales_receive_commission'];
			$all['sales_unreceive_bonus'] = $all['sales_bonus'] - $all['sales_receive_bonus'];
			$all['dis_unreceive_commission'] = $all['distribution_commission'] - $all['dis_receive_commission'];
			$all['dis_unreceive_bonus'] = $all['distribution_bonus'] - $all['dis_receive_bonus'];
			foreach ($all as &$value) {
				if($value == null || $value == ''){
					$value = 0;
				}
			}
			$data = $this->setData($all);
			dump($data);die;
    	}
   	}

	/**
	 * 意向客户登记表
	 */
	public function intention()
	{
	$
		$field = '*';
		$fields = 'name,is_intention,intention_money,intention_time,intention_room_style,serial_number,return_money,	intention_money_return_time,sex,phone,id_number,address,in_province,sales,distribution,created_time';
		$where['is_intention'] = 1;
		$this->assign('fields',$fields);
		$this->assign('unfields',$unfields);
		$this->assign('where',json_encode($where));
		$this->assign('_title','意向客户登记表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 合同统计表
	 */
	public function contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}


	/**
	 * 已完成合同统计表
	 */
	public function contract_over()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['is_over'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','已完成合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 未完成合同统计表
	 */
	public function contract_unover()
	{
		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['is_over'] = array('neq',1);
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','未完成合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 已完成收款合同统计表
	 */
	public function get_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['get_contract_money'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','已完成收款合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 未完成收款合同统计表
	 */
	public function unget_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['get_contract_money'] = array('neq',1);
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','未完成收款合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 银行按揭客户合同统计表
	 */
	public function bank_mortgage_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['bank_mortgage'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','银行按揭客户合同统计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 一次性付款客户合同计表
	 */
	public function ot_payment_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['ot_payment'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','一次性付款客户合同计表');

		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 分期付款客户合同统计表
	 */
	public function installment_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['contract_no'] = array('neq','');
		$where['installment'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','分期付款客户合同统计表');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 已交定金未签合同统计表
	 */
	public function deposit_contract()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['deposit'] = array('gt','0');
		$where['contract_no'] = array('eq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','已交定金未签合同统计表');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 退定金客户统计表
	 */
	public function deposit_return()
	{

		$field = '*';
		$fields = 'name,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,sales,distribution,manager,supervisor,created_time';
		$where['deposit'] = array('gt','0');
		$where['contract_no'] = array('eq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','退定金客户统计表');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 退房客户统计表
	 */
	public function check_out()
	{

		$field = '*';
		$fields = 'name,check_out,check_out_money,get_check_out_money,check_out_time,is_over,get_contract_money,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,sales,distribution,manager,supervisor,created_time';

		$where['check_out'] = 1;
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','退房客户统计表');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 省内客户统计表
	 */
	public function in_province()
	{
		$where['in_province'] = 1;
		$this->assign('where', json_encode($where));
		$this->assign('_title','省内客户统计表');
		$this->display('common2');
	}
	/**
	 * 省外客户统计表
	 */
	public function out_province()
	{
		$where['in_province'] = array('neq',1);
		$this->assign('where', json_encode($where));
		$this->assign('_title','省外客户统计表');
		$this->display('common2');
	}
	/**
	 * 置业顾问统计表
	 */
	public function sales()
	{
		$field = 'sales';
		$fields = 'sales,sales_point,sales_commission,sales_bonus,sales_receive_commission,sales_commission_time,sales_receive_bonus,sales_bonus_time,sales_return_commission,sales_return_com_time,name,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,created_time';

		$where[$field] = array('neq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','置业顾问统计表');
		$this->assign('search_title','置业顾问搜索:');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}
	/**
	 * 分销商统计表
	 */
	public function distribution()
	{
		$field = 'distribution';
		$fields = 'distribution,distribution_point,is_dribution_invoice,distribution_commission,distribution_bonus,dis_receive_commission,dis_commission_time,dis_receive_bonus,dis_bonus_time,dis_return_commission,dis_return_com_time,name,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,created_time';
		$where[$field] = array('neq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','分销商统计表');
		$this->assign('search_title','分销商搜索:');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 渠道经理统计表
	 */
	public function manager()
	{
		$field = 'manager';
		$fields = 'manager,manager_point,manager_commission,manager_bonus,manager_receive_commission,manager_commission_time,manager_receive_bonus,manager_bonus_time,manager_return_commission,manager_return_com_time,name,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,created_time';

		$where[$field] = array('neq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','渠道经理统计表');
		$this->assign('search_title','渠道经理搜索:');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');
	}

	/**
	 * 案场主管统计表
	 */
	public function supervisor()
	{
		$field = 'supervisor';
		$fields = 'supervisor,supervisor_point,supervisor_commission,supervisor_bonus,supervisor_receive_commission,supervisor_commission_time,supervisor_receive_bonus,supervisor_bonus_time,supervisor_return_commission,supervisor_return_com_time,name,subscription_time,contract_no,contract_time,contract_receipt_time,unit_price,contract_money,room_money,decoration_money,offer_policy,room_number,area,ot_payment,bank_mortgage,installment,deposit,deposit_time,deposit_return,deposit_return_time,down_payment,progress_payment_1,progress_payment_2,progress_payment_3,loan_amout,get_loan_amout,cus_info_reported_time,check_out,check_out_money,get_check_out_money,check_out_time,created_time';
		$where[$field] = array('neq','');
		$this->assign('fields',$fields);
		$this->assign('where', json_encode($where));
		$this->assign('_title','案场主管统计表');
		$this->assign('search_title','案场主管搜索:');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');

	}

	/**
     * 意向登记未转定客户统计表
     * @return [type] [description]
     */
    public function intention_contrack()
    {
        $field = '*';
        $where['is_intention'] = 1;

        // $where['name']  = array('like', '%thinkphp%');
        // $where['title']  = array('like','%thinkphp%');
        // $where['_logic'] = 'or';
        // $map['_complex'] = $where;

       	$map['is_intention'] = 1;
       	$map['contract_no'] = array('neq' ,'');
       	$map['_logic'] = 'and';
       	$where['_complex'] = $map;

        $this->assign('where', json_encode($where));

        $this->assign('_title','意向登记未转定客户统计表');
        $filter = $this->getDateFilter($field);
        $this->assign('field', $field);
        $this->assign('_filter', $filter);
        $this->display('common2');
    }

	/**
	 * 总客户统计表
	 */
	public function all()
	{
		$field = '*';
		$this->assign('_title','总客户统计表');
		$filter = $this->getDateFilter($field);
		$this->assign('field', $field);
		$this->assign('_filter', $filter);
		$this->display('common2');

	}


	/**
	 * 组装过滤器
	 * @param  string $fields 字段名称，如置业顾问sales，分销商distribution
	 * @return array         过滤条件数组
	 */
	protected function getDateFilter($fields = '')
	{
        $filter = array();//过滤器列表

        /*类型过滤*/
        if($fields != '*' && $fields != ''){
        	$temp['type'] = 'name';
	        $FIRST[0]['value'] = '*';
	        $FIRST[0]['title'] = '全部';
	        $list = D('customer')
	                ->order('id asc ')
	                ->field($fields . ' as title,' . $fields . ' as value')
	                ->group($fields)
	                ->where(array($fields=>array('neq','') ))
	                ->select();
	        $temp['data'] = array_merge($FIRST, $list);
	        $filter[] =$temp;
	        unset($temp);
        }

        /*时间类型过滤*/
        $timestyle[0]['title'] = '创建时间';
        $timestyle[0]['value'] = 'created_time';

        $timestyle[1]['title'] = '意向登记时间';
        $timestyle[1]['value'] = 'intention_time';

        $timestyle[2]['title'] = '认购时间';
        $timestyle[2]['value'] = 'subscription_time';

        $timestyle[3]['title'] = '定金时间';
        $timestyle[3]['value'] = 'deposit_time';

        $timestyle[4]['title'] = '定金时间';
        $timestyle[4]['value'] = 'deposit_time';

        $timestyle[5]['title'] = '首付时间';
        $timestyle[5]['value'] = 'down_payment_time';

        $timestyle[5]['title'] = '退房时间';
        $timestyle[5]['value'] = 'check_out_time';

        $temp['type'] = 'time_style';
        $temp['data'] = $timestyle;
        $filter[] = $temp;

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

