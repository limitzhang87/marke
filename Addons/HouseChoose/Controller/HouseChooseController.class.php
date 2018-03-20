<?php
namespace Addons\HouseChoose\Controller;
use Admin\Controller\AddonsController;
class HouseChooseController extends AddonsController{
	public function HouseChoose(){
            $nickname   =   I('nickname');
			$all_id      =   I("houses_id");
			
			$map['status']  =   array('egt',0);
			if(is_numeric($nickname)){
				$map['name|title']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
			}else{
				$map['title']    =   array('like', '%'.(string)$nickname.'%');
			}  
			
			
			$data1 = str2arr($all_id);	//转换为数组
            $where['id'] = array('in',$data1);  //原先存在的楼盘
            $map['id'] = array('NOT IN',$data1);//条件不在所需楼盘列表中的
            
            $SelectResult = $this->getAllSelectData($map);
            $SelectedResult = $this->getAllSelectData($where);
            
            $this->assign("addon_path", "./Addons/HouseChoose/");
            $this->assign("fields1",$SelectResult);
            $this->assign("fields2",$SelectedResult);
            $this->display(T('Addons://HouseChoose@HouseChoose/index'));
	}
        //处理自动完成函数
        public function GetCheck(){
			
			header('Content-Type:text/html;charset=UTF-8');
			$nickname   =   I('term');
			if(is_numeric($nickname)){
				$map['name|title']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
			}else{
				$map['title']    =   array('like', '%'.(string)$nickname.'%');
			}
			
			
			$SelectResult = $this->getAllSelectData($map);
			$add_data=array_column($SelectResult,'title');
			//返回的数据最好是数组或对象类型的JSON格式字符串			
			echo json_encode($add_data);
		}
		
		
      
		
		public function GetSearch(){
			$nickname   =   I('nickname');
			if(is_numeric($nickname)){
				$map['name|title']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
			}else{
				$map['title']    =   array('like', '%'.(string)$nickname.'%');
			}
			$SelectResult = $this->getAllSelectData($map);
			$this->assign("fields1",$SelectResult);
			$this->display(T('Addons://HouseChoose@HouseChoose/search'));
		}
		
        /**
         * 查询document函数
         * @return type
         */
        private function getAllSelectData (array $where = array()) {
 
            $result = M("document")->where($where)->where("status=1")->where("model_id=3")->page($p,15)->field('id,title')->select();
            return $result;
        }
        
       /**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
		private function str2arr($str, $glue = ','){
			return explode($glue, $str);
		}
        
      
}
