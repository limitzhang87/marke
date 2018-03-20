<?php

namespace Addons\Comment\Model;
use Think\Model;

/**
 * Comment模型
 */
class AddonCommentModel extends Model{

  public $model = array(
    'title'         => '',            //新增[title]、编辑[title]、删除[title]的提示
    'template_add'  => 'View/edit.html',     //自定义新增模板自定义html edit.html 会读取插件根目录的模板
    'template_edit' => 'View/edit.html',    //自定义编辑模板html
    'search_key'    => 'content',// 搜索的字段名，默认是title
    'extend'        => 1,
  );

  public $_fields = array(
    'document-search' =>array(
      'name'    => 'document-search-input',
      'title'   => '搜索文档',
      'type'    => 'string',
      'remark'  => '文档ID或关键字',
      'is_show' => 1
    ),
    'id'  =>array(
      'name'    => 'id',//字段名
      'title'   => 'ID',//显示标题
      'type'    => 'num',//字段类型
      'remark'  => '评论ID',// 备注，相当于配置里的tip
      'is_show' => 0,// 1-始终显示 2-新增显示 3-编辑显示 0-不显示
      'value'   => 0,//默认值
      'is_must' => 1,
    ),
    'pid'=>array(
      'name'    => 'pid',
      'title'   => '上层评论ID',
      'type'    => 'num',
      'remark'  => '上一层评论的ID',
      'is_show' => 0,
      'value'   => 0,
      'is_must' => 1,
    ),
    'uid'=>array(
      'name'    => 'uid',
      'title'   => '用户ID',
      'type'    => 'num',
      'remark'  => '评论的用户ID',
      'is_show' => 0,
      'value'   => 0,
      'is_must' => 1,
    ),
    'did'=>array(
      'name'    => 'did',
      'title'   => '文档ID',
      'type'    => 'num',
      'remark'  => '评论的用户ID',
      'is_show' => 0,
      'value'   => 0,
      'is_must' => 1,
    ),
    'username'=>array(
      'name'    => 'username',
      'title'   => '用户名',
      'type'    => 'text',
      'remark'  => '评论人的用户名，只在匿名时有效',
      'is_show' => 1,
      'value'   => '游客',
      'is_must' => 1,
    ),
    'content'=>array(
      'name'    => 'content',
      'title'   => '内容',
      'type'    => 'textarea',
      'remark'  => '评论的内容',
      'is_show' => 1,
      'value'   => 0,
      'is_must' => 1,
    ),
    'status'=>array(
      'name'    => 'status',
      'title'   => '状态',
      'type'    => 'select',
      'remark'  => '评论状态',
      'is_show' => 1,
      'extra'   => "-1:删除\n\r0:禁用\n\r1:正常",
      'value'   => 1,
      'is_must' => 1,
    ),
    'create_time'=>array(
      'name'    => 'create_time',
      'title'   => '创建时间',
      'type'    => 'datetime',
      'remark'  => '评论创建的时间',
      'is_show' => 1,
      'value'   => 0,
      'is_must' => 1,
    ),
    'update_time'=>array(
      'name'    => 'update_time',
      'title'   => '更新时间',
      'type'    => 'datetime',
      'remark'  => '评论最后的时间',
      'is_show' => 1,
      'value'   => 0,
      'is_must' => 1,
    ),
  );

  private $_error = '';
  private $_success = '';
  private $_data = '';
  private $_thisModel;
  private $_parentDetail;

  // 自动验证
  protected $_validate = array(
    array('id', '/^[0-9]{1,10}$/', 'ID错误', self::MUST_VALIDATE, 'regex'),
    array('pid', 'checkParent', 'PID错误', self::MUST_VALIDATE, 'callback'),
    array('uid', '/^[0-9]{1,10}$/', 'UID错误', self::MUST_VALIDATE, 'regex'),
    array('did', 'checkDocument', '此文档被删除或禁用', self::MUST_VALIDATE, 'callback'),
    array('username', '2,20', '用户名长度为2-20个字', self::MUST_VALIDATE, 'length'),
    array('content', 'require', '评论内容错误', self::MUST_VALIDATE),
    array('content', '5,500', '评论内容长度5-500字', self::MUST_VALIDATE, 'length'),
    array('status', array(-1,0,1), '未知状态', self::MUST_VALIDATE, 'in'),
    array('create_time', 'checkDatetime', '创建时间错误', self::MUST_VALIDATE, 'callback'),
    array('update_time', 'checkDatetime', '更新时间错误', self::MUST_VALIDATE, 'callback')
    );

  // 自动完成
  protected $_auto = array(
    array('create_time', 'dateToTime', self::MODEL_BOTH, 'callback'),
    array('update_time', 'dateToTime', self::MODEL_BOTH, 'callback'),
    array('content', 'trimAllSpace', self::MODEL_BOTH, 'callback'),
    );

  /**
   * 添加需要使用函数才能初始化的值，
   * 必须使用析构函数，自带初始化函数无效
   **/
  public function __construct() {
    parent::__construct();
    $this->_fields['create_time']['value'] = time();
    $this->_fields['update_time']['value'] = time();
    $this->_thisModel = D('AddonComment');
  }

  /**
   * 获得单条评论的方法
   * @param int $id
   * @param array $where
   * @return false|array
   **/
  public function detail($id, $where = array()) {
    $map = array_merge(array('id' => $id), $where);
    $detail = $this->_thisModel->where($map)->field('*')->find();
    if ($detail) {
      return $detail;
    }
    return false;
  }

  /**
   * 返回有效评论的数量
   */
  public function getCommentsCount() {
    $map = array('update_time'=> array('elt', NOW_TIME), 'status'=> 1);
    return $this->_thisModel->where($map)->count();
  }

  /**
   * 返回该栏目有效评论的数量
   */
  public function getthisCommentsCount($id) {
	$map = array('did'=> $id, 'update_time'=> array('elt', NOW_TIME), 'status'=> 1);  
    return $this->_thisModel->where($map)->count();
  }
  
  /**
   * 获得评论列表，性能有待优化
   * @param int $id 文档id
   * @param int $per_page 获取评论的最大条数
   * @return array 评论列表
   **/
  public function getComments($id, $per_page = 100) {
    $map = array('did'=> $id, 'update_time'=> array('elt', NOW_TIME), 'status'=> 1);
    $var_page = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
    $comments = $this->_thisModel->where($map)->page((int)I('GET.'.$var_page, 1), $per_page)->order('create_time desc')->getField('id, pid, pids, username, content, create_time');
    unset($map);

    if (!$comments || count($comments) === 0) {
      return array();
    }

    $parent_id_collection = array();
    $comment_id_collection = array();
    foreach ($comments as $comment) {
      $comment_id_collection[] = $comment['id'];
      if ((int)$comment['pids'] !== 0) {
        $parent_ids = explode(',', $comment['pids']);
        $parent_id_collection = array_merge($parent_id_collection, $parent_ids);
      }
      unset($comment);
    }
    $parent_id_collection = array_diff(array_unique($parent_id_collection), $comment_id_collection);
    if (count($parent_id_collection) !== 0) {
      $parent_comments = $this->_thisModel->where('id IN (%s) AND update_time<%d AND status=%d', implode(',', $parent_id_collection), NOW_TIME, 1)->order('create_time desc')->getField('id, pid, pids, username, content, create_time');
    }

    if ($parent_comments) {
      $comments = array_merge($comments, $parent_comments);
    }
    unset($parent_comments);
    unset($parent_id_collection);
    unset($comment_id_collection);

    return $comments;
  }

  /**
   * 后台编辑一条评论
   * @return boolen
   **/
  public function edit() {
    $id = I('post.id');
    if ($id === 0 || !$id) {
      return $this->createOne();
    }
    else {
      return $this->updateOne($id);
    }
  }

  /**
   * 后台改变一条评论的状态
   * @return boolen
   **/
  public function status() {
    $id = I('get.id', null);
    $status = I('get.status', null);
    if ($id === null || $status === null) {
      $this->_error = '参数错误[NULL]';
      return false;
    }
    $data = array('status' => intval($status));
    $map = array('id' => intval($id));
    $result = $this->_thisModel->where($map)->save($data);
    if ($result === false || $result === 0) {
      $this->_error = '没有更新数据[NO_UPDATE]';
      return false;
    }
    return true;
  }

  /**
   * 前台用户提交评论方法
   * @return boolen
   **/
  public function submit() {
    // 获得用户ID
      $addon_config = get_addon_config('Comment');

    $validate = array(
      array('pid', 'checkParent', 'PID错误', self::MUST_VALIDATE, 'callback'),
      array('did', 'checkDocument', '此文档被删除或禁用', self::MUST_VALIDATE, 'callback'),
      array('content', 'require', '评论内容不能为空', self::MUST_VALIDATE),
      array('content', '5,500', '评论内容长度5-500字', self::MUST_VALIDATE, 'length'),
    );
    $auto = array(
      array('username', 'getNickName', self::MODEL_BOTH, 'callback'),
      array('status', $addon_config['comment_status']),
      array('create_time', 'time', self::MODEL_BOTH, 'function'),
      array('update_time', 'time', self::MODEL_BOTH, 'function'),
    );
    // 获得插件配置
    
    if ($addon_config['comment_enable'] != 1) {
      $this->_error = '评论已经被关闭';
      return false;
    }
    if ($addon_config['comment_need_login'] == 1 && is_login() === 0) {
      $this->_error = '需要登录才可以评论';
      return false;
    }
    if ($addon_config['comment_verify'] == 1) {
      $validate[] = array('verify_code', 'checkVerify', '验证码错误', self::MUST_VALIDATE, 'callback');
    }
    if ($this->validate($validate)->auto($auto)->create()) {
      $this->data['uid'] = is_login();

      // 查找父层id集合
      $this->data['pids'] = $this->getParentIdCollection($this->data['pid']);
      //判断模型kind
      if($addon_comment_data['model_id']!=3){$this->data['kind']="1";}else {$this->data['kind']="2";}
      $conid=$this->add();
      if ($conid) {
        $this->_success = '评论成功';
        return $conid;
      }
      $this->_error = '评论失败[无法写入数据]';
    }
    else {
      $this->_error = $this->getError();
    }
    return false;
  }

  public function searchDocument($limit = 5) {
    $q = I('post.q', null);
    if ($q == null || empty($q)) {
      return array();
    }
    $Document = M('Document');
    if (preg_match('/^\d+$/', $q)) {
      // 按照id搜索
      $map = array('id' => $q);
      $result = $Document->where($map)->limit($limit)->order('id desc')->select();
    }
    else {
      // 按照关键字搜索
      $map = array('title' => array('like', '%'.$q.'%')); // like的性能差，待优化
      $result = $Document->where($map)->limit($limit)->order('id desc')->select();
    }
    // 获得所有文档模型
    $Model = M('Model');
    $models = $Model->limit(1000)->getField('id, name'); // 似乎这样省sql，待优化
    foreach ($result as &$r) {
      $r['document_url'] = U('Article/edit', array('id'=>$r['id'], 'model'=>$r['model_id'], 'cate_id'=>$r['category_id'])); // Home/Article/detail/id/1.html
    }
    return $result;
  }

  /**
   * 返回错误信息
   * @return string 错误
   **/
  public function Error() {
    return $this->_error;
  }

  /**
   * 返回成功信息
   * @return string 错误
   **/
  public function Success() {
    return $this->_success;
  }

  /**
   * 后台创建评论内部方法
   * @return boolen
   **/
  private function createOne() {
    if ($this->create()) {
       
      // 查找父层id集合
      
      $this->data['pids'] = $this->getParentIdCollection($this->data['pid']);
      //判断模型
      if($addon_comment_data['model_id']!=3){$this->data['kind']="1";}else {$this->data['kind']="2";}
      $result = $this->data($this->data)->add();
      
      if ($result) {
        $this->_success = '创建评论成功';
        return true;
      }
      else {
        $this->_error = '创建数据失败，请联系管理员';
      }
    }
    else {
      $this->_error = $this->getError();
    }
    return false;
  }

  /**
   * 后台更新评论内部方法
   * @param int $id 评论ID
   * @return boolen
   **/
  private function updateOne($id) {
    if ($this->create()) {
      // 找到用户名则更新用户名，否则不更新用户名
      if (($username = $this->checkUser($this->data['uid'])) !== false) {
        $this->data['username'] = $username;
      }
      else {
        unset($this->data['username']);
      }
      //判断模型资讯或者楼盘
      if(get_article_model_id($this->data['did'])!=3){$this->data['kind']="1";}else {$this->data['kind']="2";}
      
      // 查找父层id集合
      $this->data['pids'] = $this->getParentIdCollection($this->data['pid']);
      //var_dump($this->data['pids']);die;
      $result = $this->where(array('id'=>$id))->save($this->data);
      if ($result) {
        $this->_success = '更新评论成功';
        return true;
      }
      else if ($result == 0) {
        $this->_error = '没有需要更新的数据';
      }
      else {
        $this->_error = '更新数据失败，请联系管理员';
      }
    }
    else {
      $this->_error = $this->getError();
    }
    return false;
  }

  /**
   * 将时间转化为时间戳
   * @param string $data 2015-04-01 08:01
   * @return string 时间戳
   **/
  public function dateToTime($date) {
    list($year, $month, $day, $hour, $minute) = $this->filteDate($date);
    return mktime(intval($hour), intval($minute), 0, intval($month), intval($day), intval($year));
  }

  /**
   * 检查评论用户
   * @param int $id 用户ID
   * @return boolen
   **/
  public function checkUser($id) {
    if ($id === 0)
      return true;
    $Member = D('Admin/Member');
    $nickname = $Member->getNickName($id);
    return $nickname ? $nickname : false;
  }

  /**
   * 检查引用评论
   * @param int $id 评论ID
   * @return boolen
   **/
  public function checkParent($id = 0) {
    if (intval($id) === 0) {
      return true;
    }
    // 验证是否存在此评论
    $this->_parentDetail = $this->detail($id);
    if (!$this->_parentDetail) {
      return false;
    }

    $post_id = I('post.id', null);
    // 验证引用评论是否是自己本身
    if ($this->_parentDetail['id'] == $post_id)
      return false;

    $did = I('post.did', null);
    // 验证引用评论的文档是否是当前文档
    if ($this->_parentDetail['did'] != $did)
      return false;
    return true;
  }

  /**
   * 检查文档是否存在
   * @param int $id 文档ID
   * @return boolen
   **/
  public function checkDocument($id) {
	$Document = M('Document');
    $info = $Document->field('*')->find($id);
    if (!$info || $info['status'] != 1) return false;
    return true;
  }

  /**
   * 检查日期格式
   * @param string $datetime
   * @return boolen
   **/
  public function checkDatetime($datetime) {
    if (!is_string($datetime))
      return false;
    if ($match = $this->filteDate($datetime)) {
      list($year, $month, $day, $hour, $minute) = $match;
      if ($month < 1 || $month > 12)
        return false;
      if ($day < 1)
        return false;
      if ($this->isLargeMonth($month) && $day > 31)
        return false;
      if ($this->isLitteMonth($month) && $day > 30)
        return false;
      if ($this->isLeapYear($year) && $month == 2 && $day > 29)
        return false;
      if (!$this->isLeapYear($year) && $month == 2 && $day > 28)
        return false;
      if ($hour < 0 || $hour > 23)
        return false;
      if ($minute < 0 || $minute > 59)
        return false;
      return true;
    }
    return false;
  }

  /**
   * 检查验证码
   * @param string $verify_code
   * @return boolen
   **/
  public function checkVerify($verify_code) {
    $Verify = new \Think\Verify();
    return $Verify->check($verify_code, '');
  }

  /**
   * 清除所有空格
   * @return string
   **/
  public function trimAllSpace($str) {
    return preg_replace('/\s+/', ' ', trim($str));
  }

  /**
   * 将日期过滤成单个值的数组
   * @param string $datetime 2015-04-01 08:01
   * @return string array(year, month, day, hour, minute)
   **/
  private function filteDate($datetime) {
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2})$/', $datetime, $match)) {
      array_shift($match);
      return $match;
    }
    return false;
  }

  /**
   * 验证闰年
   * @param int[4] $year
   * @return boolen
   **/
  private function isLeapYear($year) {
    $short_year = substr($year, 2);
    if ('00' == $short_year && $year % 4 == 0 && $year % 200 == 0) {
      return true;
    }
    else if ($year % 4 == 0) {
      return true;
    }
    return false;
  }

  /**
   * 验证大月
   * @param int $month
   * @return boolen
   **/
  private function isLargeMonth($month) {
    $months = array(1, 3, 5, 7, 8, 10, 12);
    if (in_array(intval($month), $months)) {
      return true;
    }
    return false;
  }

  /**
   * 验证小月
   * @param int $month
   * @return boolen
   **/
  private function isLitteMonth($month) {
    $months = array(4, 6, 9, 11);
    if (in_array(intval($month), $months)) {
      return true;
    }
    return false;
  }

  /**
   * 获得用户名
   * @param int $uid
   * @return string
   **/
  public function getNickName($uid = null) {
    $uid = $uid == null ? is_login() : $uid;
    if ($uid == 0) {
      return '游客';
    }
    //$Member = D('Admin/Member');TODO
    $nickname = $_SESSION['onethink_home']['user_auth']['username']; //$Member->getNickName($uid);
    return $nickname;
  }

  /**
   * 补完父评论id集合
   */
  private function getParentIdCollection($pid)
  {
    if ((int)$pid === 0) {
      return 0;
    }
    else {
      if ((int)$this->_parentDetail['pids'] !== 0) {
        return $pid . ',' .$this->_parentDetail['pids'];
      }
      else {
        return $pid;
      }
    }
  }
  /*根据ID获取类型*/
  private function get_article_model_id($did)
  {
      $data=M('document')->field('model_id')->find($did);
      return $data['model_id'];
  }
  
  
  
  

}