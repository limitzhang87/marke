<?php
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

/**
 * 文档基础模型
 */
class MenuListModel extends RelationModel{

    protected $_link = array(
    	'MenuAuth' => array(
    		'mapping_type'  => self::HAS_MANY,
    		'class_name'    => 'MenuAuth', 
    		'foreign_key'   => 'm_id',
    		'mapping_name'  => 'MenuAuth',
    		),
    	);

    public function text()
    {
    	echo 1;
    }
}
