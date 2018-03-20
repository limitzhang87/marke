<?php
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;
use Home\Model\BaseRelationModel;

/**
 * 栋楼模型
 */
class BuildingModel extends BaseRelationModel{

    protected $_link = array(
        'Unit'=>array(
            'mapping_type'      => self::HAS_MANY,
            'class_name'        => 'unit',            // 定义更多的关联属性
            'foreign_key'       => 'b_id',
            'mapping_name'      => 'unit',
            'mapping_fields'    => 'id,u_name,status,u_order',
        ),
    );
}
