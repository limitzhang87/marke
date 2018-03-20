<?php
namespace Home\Controller;
use Think\Controller;

class TextController extends Controller {
  	protected function _initialize(){
        /* 切换数据库 */

          changeDB();
  	}
    public function index(){
    	$dbname = 'zhangjixian';
    	$a = $this->createBD($dbname);
    	dump($a);
    }

	/**
     * 创建数据库
     * @param  string $dbname 数据库名称
     * @return boollean         真或假
     */
    public function createBD($dbname = '')
    {
        if(!is_string($dbname) || $dbname == ''){
            return false;
        }

        /*创建数据库*/
        $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
        $res = D()->execute($sql );

        //读取SQL文件
        $sql = file_get_contents('start.sql');
        $sql = str_replace("\r", "\n", $sql);
        $sql = explode(";\n", $sql);
        $connection = 'mysql://root:123456@localhost:3306/' . $dbname;
        $db = M('user','zf_',$connection);
        //开始安装
        foreach ($sql as $value) {
            $value = trim($value);
            if(empty($value)) continue;
            if(substr($value, 0, 12) == 'CREATE TABLE') {
                if(false !== $db->execute($value)){
                } else {
                    $drop = 'drop database ' . $dbname;
                    $db->execute($drop);
                    return  false;
                }
            } else {
                $db->execute($value);
            }

        }
        return true;
    }

}