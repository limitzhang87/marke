<?php

namespace Addons\CategoryDialog\Controller;
use Home\Controller\AddonsController;

class CategoryDialogController extends AddonsController{
	public function CategorySelect(){
		 /* -------------begin 查询条件初始化 -----------------------------------*/
        $where=' 1=1';
        if($_GET['category_pid']){
           $map['pid']	=	$_GET['category_pid'] ;
           $map['id']	=	$_GET['category_pid'] ;
           $where.=' and  ( find_in_set(pid,getChildList('.$_GET['category_pid'].')) ) ';
        }
        if($_GET['province']){
        	$where.=' and  (province= '.$_GET['province'].')';
        }
        if($_GET['city']){
        	$where.=' and  (city='.$_GET['city'].')';
        }
        if($_GET['model']=='2'){
        	$where.=' and  (model!=3 or pid=0)  ';
        } if($_GET['model']=='3'){
        	$where.=' and (model!=2 or pid=0)  ';
        }
        /* -------------end 查询条件初始化 -----------------------------------*/
   
        $tree = M('Category')->field('id,pid,title,allow_publish,model')->where($where)->select();
        $this->assign('tree', $tree);
        //print_r(M('Category')->getlastsql());exit;
		$this->assign('Category_id',   $_GET['Category_id_new']);
		$this->assign('get_data',   $_GET);
		if($_GET['type']=='home'){
			$this->display('./Addons/CategoryDialog/View/CategoryDialog/CategoryHomeSelect.html');
		}else{
			$this->display('./Addons/CategoryDialog/View/CategoryDialog/CategorySelect.html');
		}
	}

}
