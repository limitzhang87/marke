<?php
namespace Admin\Controller;


/**
* 测试
*/
class TextController extends AdminController
{
	
	public function index()
	{
			$dbms='mysql';     //数据库类型
            $host='120.24.92.182'; //数据库主机名
            $dbName='zfw';    //使用的数据库
            $user='zhang';      //数据库连接用户名
            $pass='123456';          //对应的密码
            $dsn="$dbms:host=$host;dbname=$dbName";
            try {
                $dbh = new \PDO($dsn, $user, $pass); //初始化一个PDO对象
                echo "连接成功<br/>";
                /*你还可以进行一次搜索操作
                foreach ($dbh->query('SELECT * from FOO') as $row) {
                    print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
                }
                */
                $dbh = null;
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
            //默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
            //$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
	}


	public function db1()
	{
		$model =  D()->db(1,"mysql://zhang:123456@120.24.92.182:3306/zfw");
		$data = $model->table('zf_document')->limit(1)->select();
		//D()->db(2,"mysql://zhang:123456@120.24.92.182:3306/zfw")->table('zf_')
		//$data = D()->db(1,"mysql://zhang:123456@120.24.92.182:3306/zfw")->query('select * from zf_document limit 1	');
		dump($data);
		echo C('LIST_ROWS');
	}
}

 ?>