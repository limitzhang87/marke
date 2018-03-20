<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿
// +----------------------------------------------------------------------
// | 二次开发：elvis
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */
//  /**
//  * 根据用户ID获取用户名
//  * @param  integer $uid 用户ID
//  * @return string       用户名
//  */
// function get_username($uid = 0){

//  static $list;
//  if(!($uid && is_numeric($uid))){ //获取当前登录用户名
//      return session('user_auth.username');
//  }

//  /* 获取缓存数据 */
//  if(empty($list)){
//      $list = S('sys_active_user_list');
//  }
//  /* 查找用户信息 */
//  $key = "u{$uid}";
//  if(isset($list[$key])){ //已缓存，直接使用
//      $name = $list[$key];
//  } else { //调用接口获取用户信息
//      $User = new Userhome\Api\UserApi();
//      $info = $User->info($uid);
        
//      if($info && isset($info[1])){
//          $name = $list[$key] = $info[1];
//          /* 缓存用户 */
//          $count = count($list);
//          $max   = C('USER_MAX_CACHE');
//          while ($count-- > $max) {
//              array_shift($list);
//          }
//          S('sys_active_user_list', $list);
//      } else {
//          $name = '';
//      }
//  }

//  return $name;
// }
// 分析枚举类型字段值 格式 a:名称1,b:名称2
// 暂时和 parse_config_attr功能相同
// 但请不要互相使用，后期会调整
function parse_field_attr($string) {
    if(0 === strpos($string,':')){
        // 采用函数定义
        return   eval('return '.substr($string,1).';');
    }elseif(0 === strpos($string,'[')){
        // 支持读取配置参数（必须是数组类型）
        return C(substr($string,1,-1));
    }

    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}


/**
 * 判断注册时间
 * @param unknown $hour 小时
 * @return number 与当前时间的比较
 */
function check_time($hour){
    return date('H:i:s')-$hour;
}
/**
 * 密码加密
 * @param unknown $pw 输入的密码
 * @return string
 */
function sp_password($pw){
    $decor=md5(C('DB_PREFIX'));
    $mi=md5($pw);
    return substr($decor,0,12).$mi.substr($decor,-4,4);
}
/**
 * 发送激活邮件的内容
 * @return string 内容 $_SERVER['HTTP_HOST']获取当前子域名
 */
function mail_content($uid='',$password=''){
    
    $uid=sp_password($uid);
    $content="请完成激活，".$_SERVER['HTTP_HOST'].U("user/check_email",array("uid"=>$uid,"key"=>$password));
    return $content;
}
/*

*系统邮件发送函数

* @param string $to    接收邮件者邮箱

* @param string $name  接收邮件者名称

* @param string $subject 邮件主题

* @param string $body    邮件内容

* @param string $attachment 附件列表

* @return boolean

*/

function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
    $config = C('THINK_EMAIL');
    vendor('PHPMailer.class#phpmailer');//从PHPMailer目录导class.phpmailer.php类文件

    $mail = new PHPMailer(); //PHPMailer对象

    $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码

    $mail->IsSMTP();  // 设定使用SMTP服务

    $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能

    // 1 = errors and messages

    // 2 = messages only

    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能

    $mail->SMTPSecure = 'ssl';                 // 使用安全协议

    $mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器

    $mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号

    $mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名

    $mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码

    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);

    $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];

    $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];

    $mail->AddReplyTo($replyEmail, $replyName);

    $mail->Subject    = $subject;

    $mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";

    $mail->MsgHTML($body);

    $mail->AddAddress($to, $name);

    if(is_array($attachment)){ // 添加附件

        foreach ($attachment as $file){
            is_file($file) && $mail->AddAttachment($file);
        }
    }

    //return  $mail->Send() ? true : $mail->ErrorInfo;
    if($mail->send()){
        return ture;
    }else{
        print_r($mail->ErrorInfo);
    }
}


// 获取数据的状态操作
function show_status_op($status) {
    switch ($status){
        case 0  : return    '启用';     break;
        case 1  : return    '禁用';     break;
        case 2  : return    '审核';       break;
        default : return    false;      break;
    }

}
/**
 * 获取推送对应状态的文字信息
 * @param int $status
 * @return string 状态文字 ，false 未获取到
 * @author ELVIS
 */
function get_push_status_title($status = null){
    if(!isset($status)){
        return false;
    }
    switch ($status){
        case -1 : return    '拒绝推送';   break;
        case 0  : return    '请求推送';     break;
        case 1  : return    '推送成功';     break;
        case 2  : return    '请求更新';   break;
        default : return    false;      break;
    }
}
/**
 * 获取新闻对应状态的信息
 * @param int $status
 * @return string 状态文字 ，false 未获取到
 * @author ELVIS
 */
function get_ad_status_title($status = null){
    if(!isset($status)){
        return false;
    }
    switch ($status){
        case -1 : return    '审核未通过';   break;
        case 0  : return    '未审核';     break;
        case 1  : return    '审核通过';     break;
        case 2  : return    '禁用';   break;
        default : return    false;      break;
    }
}

function get_house_type_pic($pic=null){
    if(!isset($pic)){
        return false;
    }
    
    $result = array();
    preg_match_all('#"(.*?)"#i',$pic,$result);
    return $result[0][1]; 
}

/*获取checkbox的值*/
/**
 * 
 * @param string $name  标示名
 * @param string $type  类型
 * @param string $flag 
 * @param string $download_id  楼盘ID
 * @param string $download_type  区分是测评（只显示三种）还是普通
 * @return boolean|string|Ambigous <string, unknown>
 */
function get_checkbox($name='',$type=null,$flag='1',$download_id='',$download_type=0){
    if($download_id==''){
        if(!isset($type)){
            return false;
        }
        $str='';
        $group=M("config")->where("name='$name'")->field("value")->find();
        $group1=split("\n",$group["value"]);
        foreach($group1 as $val){
            $group2=split(":",$val);
            $int=intval($group2['0']);
            $res = $type & $int ;
            if($res !== 0){
                $data['name'][]=$group2['1'];
                $str=$str.$group2['1'];
            }else{
                continue;
            }
        }
        return $str;
    }else{
        if($download_type==1){
            $download=M("document_download")->where("id='$download_id'")->field("houses_grade,salestate,houses_features")->find();
            switch($download['houses_grade']){
                case 1: $data[]='高端级';break;
                case 2: $data[]='精英级';break;
                case 3: $data[]='白领级';break;
                case 4: $data[]='亲民级';break;
            }
        }else{
            $download=M("document_download")->where("id='$download_id'")->field("housetype,download_need,hcategory,housefeature,renovation,salestate,saleyes")->find();
        }
        foreach ($download as $key=>$val){
            $array_key=$key;
            switch ($key){
                case 'housetype' : 
                    $name="HOUSE_HOUSETYPE" ;//物业类型
                    break;
                case 'download_need' : 
                    $name="DOWNLOAD_NEED";//楼盘需求
                    break;
                case 'hcategory' : 
                    $name="HOUSE_HCATEGORY";//建筑类别
                    break;
                case 'housefeature' : 
                    $name="HOUSE_HOUSEFEATURE";//项目特色
                    break;
                case 'renovation' : 
                    $name="HOUSE_RENOVATION";//装修状况
                    break;
                case 'salestate' : 
                    $name="HOUSE_SALESTATE";//现房期房
                    break;
                case 'saleyes' : 
                    $name="HOUSE_SALEYES";//销售状态
                    break;
                case 'houses_features' :
                    $name="HOUSE_FEATURES" ;//房产功能
                    break;
            }
            if($name=='HOUSE_SALESTATE'){
                switch($download[$key]){
                    case 1: $data[]='期房';break;
                    case 2: $data[]='现房';break;
                    case 4: $data[]='在建';break;
                    case 8: $data[]='待建';break;
                }
            }
            $str='';
            $group=M("config")->where("name='$name'")->field("value")->find();
            $group1=split("\n",$group["value"]);
            
            foreach($group1 as $val){
                $group2=split(":",$val);
                
                $int=intval($group2['0']);
                $res = $download[$key] & $int ;
                if($res !== 0){
                    $data[]=$group2['1'];
                    $str=$str.$group2['1'];
                }else{
                    continue;
                }   
            }   
        }
        return $data;
    }
}
/*物业类型*/
function get_housetype($type=null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '住宅';       break;
        case 2  : return    '别墅';       break;
        case 4  : return    '写字楼';      break;
        case 8  : return    '商铺';       break;
        case 16 : return    '商业街';      break;
        case 32 : return    '城市综合体';    break;
        case 64 : return    '酒店式公寓';        break;
        default : return    '无';      break;
    }
}
/*装修情况*/
function get_renovation($type=null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '毛坯';       break;
        case 2  : return    '精装修';      break;
        case 4  : return    '公共部分精装';       break;
        case 8  : return    '菜单式装修';        break;
        default : return    '无';      break;
    }
}
/*现房期房*/
function get_salestate($type=null){
    if(!isset($type)){
        return false;
    }
    switch ($type){ 
        case 1  : return    '期房';       break;
        case 2  : return    '现房';       break;
        default : return    '无';      break;
    }
}
/*销售状态*/
function get_saleyes($type=null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '待售';       break;
        case 2  : return    '在售';       break;
        case 4  : return    '尾盘';       break;
        case 8  : return    '售罄';       break;
        case 16 : return    '老盘加推';     break;
        default : return    '无';      break;
    }
}
function cut_content($str=null){
    if(!isset($str)){
        return false;
    }
    
    return mb_substr($str,40,20,'utf-8');
}

function get_brand_type($type=null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '开发商';          break;
        case 2  : return    '物业公司';     break;
        case 3  : return    '装修公司';     break;
        case 4  : return    '营销代理';     break;
        case 5  : return    '策划公司';     break;
        default : return    false;      break;
    }
}
function get_city($num=null){
    if(!isset($num)){
        return false;
    }else{
        $result=M('district')->field('name')->where("id='$num'")->find();
        $city=mb_substr($result['name'], 0, 2, 'utf8');
    }
    return $city;
}
function get_download($id=null){

    if(!isset($id)){
        return false;
    }else{
        $result=M('document')->field('id,title')->where("id='$id'")->find();
        
    }
    return $result;
}
function get_brand_name($id=null){

    if(!isset($id)){
        return false;
    }else{
        $result=M('developer')->field('id,brand_name')->where("uid='$id'")->find();

    }
    return $result;
}
/**
 * 获取折扣值
 * @param unknown $p1 现价
 * @param unknown $p2 原价
 * @return string 返回值
 */
function get_rebate($p1,$p2){
    $change_p=$p2-$p1;
    $rebate=$change_p/$p2;
    return sprintf("%.2f", $rebate).'折'; ;
}
/**
 * 获取剩余时间
 * @param unknown $t1 开始时间
 * @param unknown $t2 结束时间
 */
function get_lastDate($t1,$t2){
    $length=round($t2-$t1);
    $hour=$length/3600;
    $hour_remain=$hour%24;
    $day=intval($hour/24);
    

    $time['day']=$day;
    $time['hour']=$hour_remain;
    if($day<100){
        $time['day_a']=intval($day/10);
        $time['day_b']=$day-$time['day_a']*10;
    }
    $time['hour_a']=intval($hour_remain/10);
    $time['hour_b']=$hour_remain-$time['hour_a']*10;
    return $time;
}
/*
 * 空转0或者暂无  $z=1时为暂无其他为0
 * $z=2为价格，固定格式
 */
function null2zero($e,$z) {
    if(empty($e)||($e=="")||$e==null){
        if($z==1){
            $e="暂无";
        }elseif($z==2){
            $e="<font class='red f-family '>暂无报价</font>";
        }else{
           $e=0;
        }
    }elseif($z==2){
        $e="<span class='dw'>元/㎡</span><strong class='red f-family f40'>".intval($e)."</strong><em class='red'>￥</em>";
    }
    return $e;
}
/*
 * 电话号码过滤器by rk php
 */
function phonefilter($num) {
    $num=preg_match("/(\d{3}-|\d{4}-)?(\d{8}|\d{7})/", $num,$result);
    //var_dump($result);die;
    if ($result[0]==null){
        return "暂无";
    }else{
        return $result[0];
    }
    
}
/*
 * 日期过滤器
 */
function datefilter($date) {
    
    if($date==''||$date==null||$date=='1970-01-01'){
        
        $date="待定";
    }
    return $date;
}
/**
 * 只保留数字
 */
function number($str)
{
    if(empty($str)){
        return false;
    }
    return preg_replace('/\D/s', '', $str);
}
/**
 * 移动端分离专题名字
 */
function separate_semianrname($str){
    if(empty($str)){
        return false;
    }
    $arr=split('-',$str);
    if($arr[1]!=''){
        return $arr[1];
    }else{
        return $arr[0];
    }
}
function get_rent($str){
    if(!isset($str)){
        return false;
    }
    switch ($str){
        case 1  : return    '日租';       break;
        case 2  : return    '月租';       break;
        case 3  : return    '整租';       break;
        case 4  : return    '合租';       break;
        default : return    false;      break;
    }
}
function get_message($tag){
    $where=array();
    if(!is_array($tag)){
        $tag=sp_param_lable($tag);
    }
    $limit = !empty($tag['limit']) ? $tag['limit'] : '0,5';
    $order = !empty($tag['order']) ? $tag['order'] : 'sub_time desc';
    $pos = !empty($tag['pos']) ? $tag['pos'] : ''; //推荐位
    $where_str = !empty($tag['where']) ? $tag['where'] : ' 1=1 ';
    if(isset($tag['cate_id'])){
        $where['cate_id']=$tag['cate_id'];
    }
    $where['sub_time']=array("lt",NOW_TIME);
    $list=M('zhongfang_message')->where($where)->where($where_str)->order($order)->limit($limit)->select();
    return $list;
}

function check_resign_point($id=''){
    if(empty($id)){
        return false;
    }else{
        $result=M('user_money')->where("user_id='$id' and type='2'")->find();
        if($result){
            return $result;
        }else{
            add_money($id, 1, 2);
        }
    }
}


/**
 * 自动登录
 */
function remmember_login(){
    return D('user')->remember_login();
}

/**
 * 超级会员注册未审核的用户判断
 * 如果该用户是刚刚注册但是未审核的状态，直接跳转到一个特定页面
 * @return boolean [description]
 */
function is_temporary()
{
    $user = session('user_temporary');
    if (empty($user)) {
        return false;
    } else {
        redirect(U('Temporary/index'));
    }
}

/**
 * 判断当前用户是否是超级会员
 * @return boolean 如果是返回用户ID，不是返回false;
 */
function is_super(){
    // $uid = is_null($uid) ? is_login() : $uid;
    // return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
    $user = session('user_auth');
    return @$user['is_super'] == '1' ?  $user['uid'] : false;
}

/**
 * 判断当前用户是否是超级会员
 * @return boolean 如果是返回用户ID，不是则跳转;
 */
function is_superD(){
    // $uid = is_null($uid) ? is_login() : $uid;
    // return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
    $user = session('user_auth');
    return @$user['is_super'] == '1' ?  $user['uid'] : redirect(U('index'));
}

/**
 * 从session中获取楼盘ID和楼盘名称，如果没有则搜索数据库，然后存入session
 * @param [integra] $type 1:返回楼盘ID，2：表示返回楼盘ID和标题
 * @return [type] [description]
 */
function getHouse($type = 1){
    return 1;

    $uid = is_super();
    if($uid){
        //超级会员获取楼盘ID
        $houses_id = session('houses_id');
        if(empty($houses_id) || $houses_id == ''){
            $houses_id = D('super_code')->field('houses_id')->where('uid='.$uid)->find();
            $houses_id = $houses_id['houses_id'];
            session('houses_id',$houses_id);
        }
        return $houses_id;
    }else{
        //非超级会员设置房号
        /**
         * 1. 通过会员组数据中的楼盘ID获取
         */
        $houses_id = session('houses_id');
        if(empty($houses_id) || $houses_id == ''){
            $group = session('group');
            $houses_id = $group['houses_id'];
            session('houses_id',$houses_id);
        }
        return $houses_id;

    }
}

/**
 * 获取楼盘信息
 * @return [type] [description]
 */
function getHouses($field = '')
{
    $field = $field == '' ?  'title' : $field;
    $res = session($field);
    if(!$res){
        $houses = D('houses')->field($field)->find(1);
        $res =  $houses[$field];
        session($field,$res);
        //cookie($field, $houses[$field] ,array('expire'=>86400,'prefix'=>'houses_'));
    }
    return $res;
}

/**
 * 获取底部
 * @return [type] [description]
 */
function getBottom(){
    $bottom = session('bottom');
    return $bottom;
}

/**
 * 获取菜单
 * @return [type] [description]
 */
function getMenu(){
    $menu = session('menu');
    return $menu;
}

/**
 * 根据房间状态，返回状态的CSS样式
 * @param  integer $status [description]
 * @return [type]          [description]
 */
function getRoomStatus($status = 0,$is_check = 0){
    switch ($status) {
        case 0:
            $statusCss = 'status_success';
            break;
        case 1:
            if(is_auth(AUTH_ROOM_CHECK)){ //根据权限是判断是否显示审核状态
                if($is_check == 1){
                    $statusCss = 'status_waring';
                }else{
                    $statusCss = 'status_check1';//未审核
                }
            }else{
                $statusCss = 'status_waring';
            }
            break;
        case 2:
            if(is_auth(AUTH_ROOM_MARKETINCON)){
                $statusCss = 'status_none';
            }else{
                $statusCss = 'status_error';
            }
            break;
        case 3:
            $statusCss = 'status_raise';
            break;
        case 9:
            if(is_auth(AUTH_ROOM_CHECK)){ //根据权限是判断是否显示审核状态
                if($is_check == 1){
                    $statusCss = 'status_error';
                }else{
                    $statusCss = 'status_check2';//未审核
                }
            }else{
                $statusCss = 'status_error';
            }
            break;
        default:
            $statusCss = 'status_over';
            break;
    }
    return $statusCss;
}


/**
 * 
 * @param  [type] $str [description]
 * @param  string $key [description]
 * @return [type]      [description]
 */
function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 传入而两个个参数，一个是要判断为真的参数，一个是跳转的链接。如果为真则继续，否则跳转，默认跳转到首页，
 * @param  boolean $check 需要判断为真的参数
 * @param  string  $url   跳转的链接
 * @return [type]         [description]
 */
function checkORredirect($check=false, $url = 'Index/index')
{
    if(!$check){
       redirect(U($url));
    }
}

/**
 * 判断当前用户所有在会员组是否拥有功能的权限
 * @param  string  $id 功能权限ID
 * @return boolean     [description]
 */
function is_auth($id = '')
{
    if(is_super()){
        return true;
    }
    if($id == ''){
        return false;
    }
    $group = session('group');
    $list = D('group_menu')->where('g_id=' . $group['id'] . ' and m_auth != \'\' ')->field('m_auth')->select();
    $ids = array();
    foreach ($list as $vo) {
        $ids =array_merge($ids,explode(',', $vo['m_auth'])) ;
    }
    if(in_array($id, $ids)){
        return true;
    }else{
        return false;
    }
}


/**
 * 会员操作房号记录
 * @param  ine $rid 房号表ID
 * @param  ine $type 操作类型
 * @param  int $uid  会员ID
 * @return [type]       [description]
 */
function room_op_log($rid, $type, $uid = '')
{
    //传过来的ID是数组；
    if(is_array($rid)){
        $uid = $uid ? $uid : is_login();
        $i = 0;
        foreach ($rid as $id) {
            $data[$i]['r_id'] = $id;
            $data[$i]['type'] = $type;
            $data[$i]['uid'] = $uid;
            $data[$i]['op_time'] = time();
            $i++;
        }
        D('room_oplog')->addAll($data);
    }else{
        $data['r_id'] = $rid;
        $data['type'] = $type;
        $data['uid'] = $uid ? $uid : is_login();
        $data['op_time'] = time();
        D('room_oplog')->add($data);
    }
}

/**
 * 审核通过的锁定和成交记录表
 * @param  string $value [description]
 * @return [type]        [description]
 */
function room_report($r_id, $type, $uid, $time,$check_id = NULL)
{
    if($type == -1){
        //解锁删除记录
        $where['r_id'] = $r_id;
        $where['uid'] = $uid;
        D('report')->where($where)->delete();
        return ;
    }
    $data['r_id']     = $r_id;
    $data['type']     = $type;
    $data['uid']      = $uid;
    $data['op_time']  = $time;
    $data['check_id'] = $data['check_id'] ? $data['check_id'] : is_login();
    D('report')->add($data);
}

/**
 * 获取性别
 * @param  int $type 类型
 * @return [type]       [description]
 */
function getSex($type)
{
    if($type == 1){
        return '男';
    }else if($type==2){
        return '女';
    }else{
        return '未知';
    }
}

/**
 * 获取文件名
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据  或者  指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function get_filename($cover_id, $field = 'name'){
    if(empty($cover_id)){
        return false;
    }
    $picture = M('file')->field($field)->find($cover_id);
    return empty($field) ? $picture : $picture[$field];
}


 // 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}
/**
 * 传入一栋楼的单元数据，然后将每个单元的key变成d单元ID
 * @param  [type] $v [description]
 * @param  [type] $w [description]
 * @return [type]    [description]
 */
function editUnit($v,$w){
    $v[$w["id"]] = array('id'=>$w["id"], 'status'=>$w["status"],'u_name'=>$w["u_name"]);
    return $v;
}


function get_DB($name,$where = array(),$order = 'id desc', $limit = 10){
    $name || die('');
}



/**
 * 修改数据库
 * @return [type] [description]
 */
function changeDB(){
    $db_name = session('db_name');
    C('db_name',$db_name);
    return  $db_name ? $db_name : false;
}



/**
 * 获取二级域名
 * @return [type] [description]
 */
function getDB()
{
    $db_name = session('db_name');
    return $db_name;
}


/**
 * 在总数据库中添加会员信息
 */
function addUserall($m_id,$phone)
{
    $data['m_id'] = $m_id;
    $data['phone'] = $phone;
    return D('userall')->add($data);
}

/**
 * 获取总数据库中的项目ID
 * @return string 项目ID
 */
function getMID()
{
    $m_id = session('m_id');
    if(!$m_id){
        $where['db_name'] = C('db_name');
        $res = D('main')->where($where)->find();
        if(!$res){
            return false;
        }else{
            $m_id = $res['id'];
            session('m_id',$m_id);
        }
    }
    return $m_id;
}

/* 解析列表定义规则*/

function get_list_field($data, $grid,$model){

    // 获取当前字段数据
    foreach($grid['field'] as $field){
        $array  =   explode('|',$field);
        $temp  =    $data[$array[0]];
        // 函数支持
        if(isset($array[1])){
            $temp = call_user_func($array[1], $temp);
        }
        $data2[$array[0]]    =   $temp;
    }
    if(!empty($grid['format'])){
        $value  =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data2){return $data2[$match[1]];}, $grid['format']);
    }else{
        $value  =   implode(' ',$data2);
    }
    // 链接支持
    if(!empty($grid['href'])){
        $links  =   explode(',',$grid['href']);
        foreach($links as $link){
            $array  =   explode('|',$link);
            $href   =   $array[0];
            if(preg_match('/^\[([a-z_]+)\]$/',$href,$matches)){
                $val[]  =   $data2[$matches[1]];
            }else{
                $show   =   isset($array[1])?$array[1]:$value;
                // 替换系统特殊字符串
                $href   =   str_replace(
                    array('[DELETE]','[EDIT]','[MODEL]'),
                    array('del?ids=[id]&model=[MODEL]','edit?id=[id]&model=[MODEL]',$model['id']),
                    $href);

                // 替换数据变量
                $href   =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data){return $data[$match[1]];}, $href);

                $val[]  =   '<a href="'.U($href).'">'.$show.'</a>';
            }
        }
        $value  =   implode(' ',$val);
    }
    return $value;
}

/* 解析列表定义规则*/

function get_list_field2($data, $grid,$model){

    // 获取当前字段数据
    foreach($grid['field'] as $field){
        $array  =   explode('|',$field);
        $temp  =    $data[$array[0]];

        $data2[$array[0]]    =   $temp;
    }
    if(!empty($grid['format'])){
        $value  =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data2){return $data2[$match[1]];}, $grid['format']);
    }else{
        $value  =   implode(' ',$data2);
    }

    return $value;
}


function getStar($v)
{
    //return $v . '星';
    $a = '';
    for ($i = 0; $i < intval($v); $i++) {
        $a  .= '⭐';
    }

    return $a;
}


function get_user_info($uid = '',$field = 'nick_name')
{
    if($uid == ''){
        return session('user_auth.' . $field);
    }
    if($uid == session('user_auth.uid')){
         return session('user_auth.' . $field);
    }else{
        $user = D('user')->field($field)->find($uid);
        return $user[$field];
    }

}