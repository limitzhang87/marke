<?php
namespace Home\Model;
use Think\Model;

/**
 * 基础模型
 *
 * 描述：		修改链接的数据库，
 * 所属项目:	zfangw
 * 开发者:		中房通
 * 创建时间:	2017/7/3 11:12 AM
 * 版权所有:	中房通(www.zfangw.cn)
 */
class BaseModel extends Model{
    //protected $connection = 'mysql://zhang:123456@120.24.92.182:3306/wandacheng';
    //protected $connection = 'mysql://root:123456@localhost:3306/wandacheng';
    protected $dbName           =   'marke';
}
