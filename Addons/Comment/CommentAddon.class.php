<?php

namespace Addons\Comment;
use Common\Controller\Addon;

/**
 * 评论插件
 * @author leoding86@msn.com
 */

class CommentAddon extends Addon{

  private $tableName;
  private $extendTableIpList;
  private $addonRoot;

  public $info = array(
    'name'      => 'Comment',
    'title'     => '评论',
    'description'   => '仿sohu本地独立评论插件',
    'status'    => 1,
    'author'    => 'rk',
    'version'     => '0.1'
  );

  public $admin_list = array(
    'model'   => "AddonComment",   //要查的表
    'fields'  => '*',               //要查的字段
    'map'     => '',                //查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
    'order'   => 'id desc',         //排序,
    'list_grid' => array(           //这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
      'username:用户名',
      'content:内容',
      'did:评论文档',
      'create_time|time_format:评论时间',
      'status:状态',
      'id:操作:[EDIT]|编辑,[DELETE]|删除'
    ),
  );

  public $custom_adminlist = 'adminlist.html' ;

  public function __construct() {
    parent::__construct();
    $this->tableName = C('DB_PREFIX') . "addon_comment";
    $this->extendTableIpList = C('DB_PREFIX') . "addon_comment_iplist";
    $this->addonRoot = __ROOT__.'/Addons/Comment';
    // 填充状态占位符
    $this->assign('meta_title_suffix', $this->info['title']);
    $addon_searchs = array();
    if ($did = I('get.did')) {
      $Document = M('Document');
      if ($detail = $Document->where(array('id' => $did))->find()) {
        $Model = M('Model');
        $model = $Model->field('name')->where(array('id'=>$detail['model_id']))->find();
        $addon_searchs['document_title'] = $detail['title'];
        $addon_searchs['document_edit_url'] = U($model['name'].'/edit', array('id'=>$detail['id'], 'name'=>'Comment'));
      }
      $addon_searchs['did'] = $did;
      $this->admin_list['map'] = array('did'=>$did);
    }
    $this->assign('addon_searchs', $addon_searchs);
  }

  // 安装插件
  public function install(){
    $Model = new \Think\Model(); // 实例一个模型
    // 创建数据表
    $query = "DROP TABLE IF EXISTS `" . $this->tableName . "`;
      CREATE TABLE `" . $this->tableName . "` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `pid` INT NOT NULL DEFAULT 0,
      `pids` TEXT NOT NULL,
      `did` INT NOT NULL DEFAULT 0,
      `uid` INT NOT NULL DEFAULT 0,
      `username` VARCHAR(100) NOT NULL DEFAULT '',
      `content` TEXT NOT NULL,
      `status` INT NOT NULL DEFAULT 0,
      `create_time` INT(10) NOT NULL DEFAULT 0000000000,
      `update_time` INT(10) NULL DEFAULT 0000000000,
      `kind` INT(4) NULL DEFAULT 1,
      PRIMARY KEY (`id`));";
    $Model->execute($query); // 执行创建语句
    $result = $Model->query("SHOW TABLES IN `".C('DB_NAME')."` LIKE '".$this->tableName."';");
    if (count($result) != 1) {
      return false;
    }
    $query = "DROP TABLE IF EXISTS `" . $this->extendTableIpList . "`;
      CREATE TABLE `".$this->extendTableIpList."` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `ip` VARCHAR(128) NOT NULL,
      `last_comment_time` INT(10) NOT NULL DEFAULT 0,
      `status` INT NOT NULL DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `ip_UNIQUE` (`ip` ASC))
      ENGINE = MyISAM;";
    $Model->execute($query);
    $result = $Model->query("SHOW TABLES IN `".C('DB_NAME')."` LIKE '".$this->extendTableIpList."';");
    if (count($result) != 1) {
      $query = "DROP TABLE IF EXISTS `" . $this->tableName . "`;";
      $Model->execute($query);
      return false;
    }
    return true;
  }


  // 卸载插件
  public function uninstall(){
    $Model = new \Think\Model();
    // 删除数据表
    $query = "DROP TABLE IF EXISTS `".$this->tableName."`;";
    $result = $Model->execute($query);
    if ($result === false) {
      return false;
    }
    $query = "DROP TABLE IF EXISTS `".$this->extendTableIpList."`;";
    $result = $Model->execute($query);
    if ($result === false) {
      return false;
    }
    return true;
  }

  //实现的documentDetailAfter钩子方法
  public function documentDetailAfter($param){
    $addon_comment_data = array('nickname' => '' ,'form' => array('did' => '', 'pid' => ''));
    $addon_config = $this->getConfig();
    $this->assign('addon_comment_config', $addon_config);
    if (($member_id = is_login()) == 0) {
      // 未登录
      $addon_comment_data['nickname'] = '游客';
      $addon_comment_data['form']['did'] = $param['id'];
      $addon_comment_data['model_id'] = $param['model_id'];
      
    }
    else {
      // 已登录
      //$Member = D('Home/UcMember');
      $addon_comment_data['nickname'] =$_SESSION['onethink_home']['user_auth']['username']; //$Member->rand_nickname($member_id);
      $addon_comment_data['form']['did'] = $param['id'];
    }
    $addon_comment_data['form']['pid'] = 0;
	 
    $Comment = D('Addons://Comment/AddonComment');
    if ($addon_config['comment_per_page'] > 0) {
      $addon_comment_data['list'] = $Comment->getComments($param['id'], $addon_config['comment_per_page']);
    }
    else {
      $addon_comment_data['list'] = array();
    }
	//var_dump($addon_config['comment_per_page']);
	
	$count=$Comment->getthisCommentsCount($param['id']);
	$this->assign('addon_comment_count',$count);
    $this->assign('addon_comment_data', $addon_comment_data);

   

    // 处理数据分页
    $Page = new \Think\Page($Comment->getthisCommentsCount($param['id']), $addon_config['comment_per_page']);
    $this->assign('addon_comment_page', $Page->show());

    $this->assign('addon_comment_title', $addon_config['comment_title']);

    // 获取模版名称
    $template_name = $addon_config['comment_template'] == '' ? 'default' : $addon_config['comment_template'];
    // 模版路径
    $template_path = __DIR__ .'/View/'.$template_name.'/';
    if (!file_exists($template_path)) {
      $this->assign('addon_comment_error', '模版不存在，使用默认模版');
      $template_name = 'default';
    }
    
    $this->display('View/'.$template_name.'/documentComments');

  }

  // 加载插件Css样式
 public function pageHeader() {
//     echo '<link href="'.$this->addonRoot.'/Public/comments.css" rel="stylesheet">';
//     echo '<link href="'.$this->addonRoot.'/Public/changyan2.css" rel="stylesheet">';
//     echo '<link href="'.$this->addonRoot.'/Public/default.css" rel="stylesheet">';
     
 
 }

  // 加载插件js
  public function pageFooter() {
  //echo '<script type="text/javascript" src="'.$this->addonRoot.'/Public/comments.js"></script>';
    //echo '<script type="text/javascript" src="'.$this->addonRoot.'/Public/jquery-1.7.2.min.js"></script>';
  }
  
  

}