<?php
namespace Raise\Model;
use Think\Model;
use Think\Model\RelationModel;

/**
 * 栋楼模型
 */
class BuildingModel extends RelationModel{


    protected $_link = array(
        'Unit'=>array(
            'mapping_type'      => self::HAS_MANY, 
            'class_name'        => 'unit',            // 定义更多的关联属性 
            'foreign_key'       => 'b_id',
            'mapping_name'      => 'unit',
            'mapping_fields'    => 'id,u_name,status,u_order',
        ),
    );

     /**
     * 保存数据
     * @access public
     * @param mixed $data 数据
     * @param array $options 表达式
     * @return boolean
     */
	public function saveAll($datas){
        $model=$this->name;
        $model = 'zf_building';
        $sql   = ''; //Sql
        $lists = []; //记录集$lists
        $pk    = $this->getPk();//获取主键
        foreach ($datas as $data) {
            foreach ($data as $key=>$value) {
                if($pk===$key){
                    $ids[]=$value;
                }else{
                    $lists[$key].= sprintf("WHEN %u THEN '%s' ",$data[$pk],$value);
                }
            }
        }
        foreach ($lists as $key => $value) {
            $sql.= sprintf("`%s` = CASE `%s` %s END,",$key,$pk,$value);
        }
        //$sql = sprintf('UPDATE __%s__ SET %s WHERE %s IN ( %s )',strtoupper($model),rtrim($sql,','),$pk,implode(',',$ids));
        $sql = sprintf('UPDATE %s SET %s WHERE %s IN ( %s )',$model,rtrim($sql,','),$pk,implode(',',$ids));
        //return $sql;
       	return M()->execute($sql);
    }

}
