<?php
namespace Wechat\Model;
use Think\Model;

/**
 * 
 */
class UnitModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
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
        $model = 'zf_unit';
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
        return $sql;
        return M()->execute($sql);
    }
}
