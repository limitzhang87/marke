<?php

namespace Addons\HousesDialog\Controller;
use Home\Controller\AddonsController;

class HousesDialogController extends AddonsController{	
	public function HousesSelect(){
		$DB =  D()->db(1,"mysql://zhang:123456@120.24.92.182:3306/zf");

		 /* -------------begin 查询条件初始化 -----------------------------------*/
        $map = array();

        if(isset($_GET['mult'])){
        	$mult=I('mult');
        }
        $mult=(empty($mult))?0:$mult;
		if(isset($_GET['title'])){
            $map['d.title']  = array('like', '%'.(string)I('title').'%');
        }
        if(isset($_GET['status'])){
            $map['status'] = I('status');
            $status = $map['status'];
        }else{
            $status = null;
            $map['status'] = array('in', '1');
        }
        
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['nickname']) ) {
            //$map['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
            $map['uid'] = $DB->table('zf_member')->where(array('nickname'=>I('nickname')))->getField('uid');
        }
        if( isset($_GET['category_id'])){//位置快捷栏
        	$category_id=I('category_id');
        	$city=get_category($category_id, 'city');
        	if(!empty($city)){
        		//$city_rs=M('district')->field('id,name')->where('level=3 and upid='.$city)->select();
        		$city_rs= $DB->table('zf_district')->field('id,name')->where('level=3 and upid='.$city)->select();
        		$map['city'] =$city;
        	}
        	$province=get_category($category_id, 'province');
        	if(!empty($province) && $city == 0){
        		$province_rs=M('district')->field('id,name')->where('level=2 and upid='.$province)->select();
        		$province_rs=$DB->table('zf_district')->field('id,name')->where('level=2 and upid='.$province)->select();
        		$map['province'] =$province;
        	}
        }
        if( isset($_GET['position'])){
            $position =  I('position');
        }

        if(!isset($map['city'])||!isset($map['d.province'])){
            if(!empty($_GET['city'])){
                $map['d.city'] = I('city');
                $city = $map['city'];
            }else if(isset($_GET['province'])){
                $map['d.province'] = I('province');
            }
        }  
        $field =(isset($_GET['field']))?(explode(',',I('field'))):'d.id,baidumap';
       
        if(isset($_GET['group_id'])){
            $group_id =I('group_id');
        }
        /* -------------end 查询条件初始化 -----------------------------------*/
        $model_id=3;//楼盘
        // 构建列表数据
        //$Document = M('Document');
        $map['model_id']	=	$model_id;
        $map['pid']         =   I('pid',0);
        if($map['pid']){ // 子文档列表忽略分类
            unset($map['category_id']);
        }
        if(!is_null($position)){
            $map[] = "position & {$position} = {$position}";
        }
        if(!is_null($group_id)){
            $map['group_id']	=	$group_id;
        }
        //$total=$list['total'] =    M('document')->table('zf_document d')->where($map)->count();
        $total=$list['total'] = $DB->table('zf_document d')->where($map)->count();
        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
            $listRows = 15;
        }
        $page_index=(isset($_GET['p']))?$_GET['p']:1;
        $limit = ($page_index-1)*$listRows.','.$listRows;
        //$list['contents']= M('document')->table('zf_document d')->field('id,title,get_city_name(city) as city_name,city,update_time,view,status')->where($map)->limit($limit)->order('d.level DESC,d.id DESC')->select();
        $list['contents']= $DB->table('zf_document d')->field('id,title,get_city_name(city) as city_name,city,update_time,view,status')->where($map)->limit($limit)->order('d.level DESC,d.id DESC')->select();

        if($list['contents']){
           foreach($list['contents'] as $k=>$v){
               $list['contents'][$k]['mainimage']=get_cover($v['cover_id'], 'path');
           }
        }
        $REQUEST    =   (array)I('request.');
        $page = new \Think\Page($total, $listRows, $REQUEST);
        if($total>$listRows){
        	$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $this->assign('mult',$mult);

        $this->assign('province_rs', $province_rs);
        $this->assign('city_rs', $city_rs);
		$this->assign('list',   $list);
		$this->assign('houses_id',   $_GET['houses_id_new']);
		$this->assign('get_data',   $_GET);
		$this->assign('select_type',I('select_type'));
		$this->display(T('Addons://HousesDialog@HousesDialog/HousesSelect'));
	}

	/**
	 * 默认文档列表方法
	 * @param integer $cate_id 分类id
	 * @param integer $model_id 模型id
	 * @param integer $position 推荐标志
	 * @param mixed $field 字段列表
	 * @param integer $group_id 分组id
	 */
	protected function getDocumentList($cate_id=0,$model_id=null,$position=null,$field=true,$group_id=null){
		/* 查询条件初始化 */
		$map = array();
		if(isset($_GET['title'])){
			$map['title']  = array('like', '%'.(string)I('title').'%');
		}
		if(isset($_GET['status'])){
			$map['status'] = I('status');
			$status = $map['status'];
		}else{
			$status = null;
			$map['status'] = array('in', '0,1,2');
		}
		//zfangw.cn 2015-08-11 市和区搜索显示 崔
		if(isset($_GET['city'])){
			$where['province']  = I('city');
			$where['city']  = I('city');
			$where['district']  = I('city');
			$where['community']  = I('city');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
		}
		if ( isset($_GET['time-start']) ) {
			$map['update_time'][] = array('egt',strtotime(I('time-start')));
		}
		if ( isset($_GET['time-end']) ) {
			$map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
		}
		if ( isset($_GET['nickname']) ) {
			//$map['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
			$map['uid'] = $DB->table('zf_member')->where(array('nickname'=>I('nickname')))->getField('uid');
		}
	
		// 构建列表数据
		$Document = M('Document');
		if($cate_id){
			$map['category_id'] =   $cate_id;
		}
		$map['pid']         =   I('pid',0);
		if($map['pid']){ // 子文档列表忽略分类
			unset($map['category_id']);
		}
		//$Document->alias('DOCUMENT');
		$DB->alias('DOCUMENT');
		if(!is_null($model_id)){
			$map['model_id']    =   $model_id;
			//if(is_array($field) && array_diff($Document->getDbFields(),$field)){
			if(is_array($field) && array_diff($DB->table('zf_document')->getDbFields(),$field)){
				//$modelName  =   M('Model')->getFieldById($model_id,'name');
				$modelName  =   $DB->table('zf_model')->getFieldById($model_id,'name');
				//$Document->join('__DOCUMENT_'.strtoupper($modelName).'__ '.$modelName.' ON DOCUMENT.id='.$modelName.'.id');
				$DB->table('zf_document')->join('__DOCUMENT_'.strtoupper($modelName).'__ '.$modelName.' ON DOCUMENT.id='.$modelName.'.id');
				$key = array_search('id',$field);
				if(false  !== $key){
					unset($field[$key]);
					$field[] = 'DOCUMENT.id';
				}
			}
		}
		if(!is_null($position)){
			$map[] = "position & {$position} = {$position}";
		}
		if(!is_null($group_id)){
			$map['group_id']	=	$group_id;
		}
		//$list = $this->lists($Document,$map,'level DESC,DOCUMENT.id DESC',$field);
		$list = $this->lists($DB,$map,'level DESC,DOCUMENT.id DESC',$field);

		if($map['pid']){
			// 获取上级文档
			//$article    =   $Document->field('id,title,type')->find($map['pid']);
			$article    =   $DB->table('zf_document')->field('id,title,type')->find($map['pid']);
			$this->assign('article',$article);
		}
		//检查该分类是否允许发布内容
		$allow_publish  =   get_category($cate_id, 'allow_publish');
	
		$this->assign('status', $status);
		$this->assign('allow',  $allow_publish);
		$this->assign('pid',    $map['pid']);
	
		$this->meta_title = '文档列表';
		return $list;
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 * @author ELVIS
	 */
	public function setStatus($model='Document'){
		return parent::setStatus('Document');
	}


	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 * @author 朱亚杰 <xcoolcc@gmail.com>
	 *
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists ($model,$where=array(),$order='',$field=true){
		$options    =   array();
		$REQUEST    =   (array)I('request.');
		if(is_string($model)){
			$model  =   M($model);
		}
	
		$OPT        =   new \ReflectionProperty($model,'options');
		$OPT->setAccessible(true);
	
		$pk         =   $model->table('zf_document')->getPk();
		if($order===null){
			//order置空
		}else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
			$options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
		}elseif( $order==='' && empty($options['order']) && !empty($pk) ){
			$options['order'] = $pk.' desc';
		}elseif($order){
			$options['order'] = $order;
		}
		unset($REQUEST['_order'],$REQUEST['_field']);
	
		if(empty($where)){
			$where  =   array('status'=>array('egt',0));
		}
		if( !empty($where)){
			$options['where']   =   $where;
		}
		$options      =   array_merge( (array)$OPT->getValue($model), $options );
		$total        =   $model->table('zf_document')->where($options['where'])->count();
	
		if( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}else{
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}
		$page = new \Think\Page($total, $listRows, $REQUEST);
		if($total>$listRows){
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$options['limit'] = $page->firstRow.','.$page->listRows;
	
		$model->table('zf_document')->setProperty('options',$options);
	
		return $model->table('zf_document')->field($field)->select();
	}
	
	/**
	 * 处理文档列表显示
	 * @param array $list 列表数据
	 * @param integer $model_id 模型id
	 */
	protected function parseDocumentList($list,$model_id=null){
		$model_id = $model_id ? $model_id : 1;
		$attrList = get_model_attribute($model_id,false,'id,name,type,extra');
		// 对列表数据进行显示处理
		if(is_array($list)){
			foreach ($list as $k=>$data){
				foreach($data as $key=>$val){
					if(isset($attrList[$key])){
						$extra      =   $attrList[$key]['extra'];
						$type       =   $attrList[$key]['type'];
						if('select'== $type || 'checkbox' == $type || 'radio' == $type || 'bool' == $type) {
							// 枚举/多选/单选/布尔型
							$options    =   parse_field_attr($extra);
							if($options && array_key_exists($val,$options)) {
								$data[$key]    =   $options[$val];
							}
						}elseif('date'==$type){ // 日期型
							$data[$key]    =   date('Y-m-d',$val);
						}elseif('datetime' == $type){ // 时间型
							$data[$key]    =   date('Y-m-d H:i',$val);
						}
					}
				}
				$data['model_id'] = $model_id;
				$list[$k]   =   $data;
			}
		}
		return $list;
	}
}
