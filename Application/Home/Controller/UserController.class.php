<?php
/**
 * 用户控制器
 *
 * 描述：		用户信息
 * 所属项目:	marke
 * 开发者:		张继贤
 * 创建时间:	2017/8/6 11:12 AM
 * 版权所有:	中房通(www.zfangw.cn)
 */
namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {


	/* 用户中心首页 */
	public function index(){
		$uid = I('uid');
		if(empty($uid) || $uid == is_login()){
			//本人
			$user = session('user_auth');
			$this->assign('user', $user);
			$this->assign('_title','个人中心');
			$this->display();
		}else{
			//is_superD();//只有超级会员才能查看其他人信息
			checkORredirect(AUTH_GROUP_MANAGE,'User/index');//只有拥有管理
			$where['id'] = $uid;
			$user = D('user')->where($where)->find();
			if(empty($user)){
				$this->error('未找到会员信息');
			}
			$this->assign('user', $user);
			$this->assign('_title','会员信息');
			$this->display('indexA');
		}

	}


	/**
	 * 用户基本信息
	 * @return [type] [description]
	 */
	public function user_info()
	{
		$id = I('id');
		$user = session('user_auth');
		if($id == '' || $id == $user['uid']){
			$user = session('user_auth');
			$user['sex'] = getSex($user['sex']);
			$this->assign('user', $user);
			$this->assign('_title','个人信息');
			$this->display();
		}else{
			$user = D('user')->find($id);
			$user['sex'] = getSex($user['sex']);
			$this->assign('user', $user);
			$this->assign('_title','个人信息');
			$this->display('user_info2');
		}
	}


	public function userList()
	{
		$this->redirect('lists');
	}
	/**
	 * 会员列表
	 * @return [type] [description]
	 */
	public function lists()
	{
		$title = '会员管理';
		$whereSQL = ' 1=1 ';
		if(I('kw') != '' || !empty(I('kw')) ){
			$whereSQL .= ' and (u.nick_name like \'%'.I('kw').'%\' or u.phone like \'%'.I('kw').'%\' ) ';
		}
		$where['u.status'] = '1';
		$page = I('page') > 0 ? I('page') : 1;
		$list = D()
				->table('zf_user u')
				->join('zf_group_user as gu on u.id=gu.uid')
				->join('zf_group as g on gu.g_id = g.id')
				->where($where)
				->where($whereSQL)
				->page($page)
				->limit(10)
				->order('g.id asc ')
				->field('u.*,g.name as g_name')
				->select();
		$total = D()
				->table('zf_user u')
				->join('zf_group_user as gu on u.id=gu.uid')
				->join('zf_group as g on gu.g_id = g.id')
				->where($where)
				->where($whereSQL)
				->count();
		//dump($total);dump(intval($total/10+1) );die;
		$this->assign('totalpage',intval($total/10)+1);
		$this->assign('kw',I('kw'));
		$this->assign('_list', $list);
		$this->assign('_title', $title);
		$this->assign('on',1);
		$this->display();
	}

	/**
	 * 已禁会员列表
	 * @return [type] [description]
	 */
	public function forbit()
	{
		$title = '已禁会员';
		$whereSQL = ' 1=1 ';
		if(I('kw') != '' || !empty(I('kw')) ){
			$whereSQL .= ' and (u.nick_name like \'%'.I('kw').'%\' or u.phone like \'%'.I('kw').'%\' ) ';
		}
		$where['u.status'] = '-1';
		$page = I('page') > 0 ? I('page') : 1;
		$list = D()
				->table('zf_user u')
				->join('zf_group_user as gu on u.id=gu.uid')
				->join('zf_group as g on gu.g_id = g.id')
				->where($where)
				->where($whereSQL)
				->page($page)
				->limit(10)
				->order('g.id asc ')
				->field('u.*,g.name as g_name')
				->select();
		$total = D()
				->table('zf_user u')
				->join('zf_group_user as gu on u.id=gu.uid')
				->join('zf_group as g on gu.g_id = g.id')
				->where($where)
				->where($whereSQL)
				->count();
		//dump($total);dump(intval($total/10+1) );die;
		$this->assign('totalpage',intval($total/10)+1);
		$this->assign('kw',I('kw'));
		$this->assign('_list', $list);
		$this->assign('_title', $title);
		$this->assign('on',-1);
		$this->display('lists');
	}

	/**
	 * 职位调整
	 * @return [type] [description]
	 */
	public function jobAdjust()
	{

		if(IS_POST){
			$data['g_id'] = I('g_id');
			$data['id']   = I('gu_id');
			$data['uid']  = I('uid');
			//dump($data);die;
			if(D('group_user')->save($data) !== false ){
				$this->success('职位调整成功！',U('User/index',array('uid'=>$data['uid'])));
			}else{
				$this->error('职位调整失败！');
			}
			return ;
		}
		$uid = I('id');
		if($uid == ''){
			$this->redirect('User/index');
		}
		$GroupUser = D('group_user')->where('uid=' . $uid)->find();
		$Group = D('group')->field('id,name')->select();
		//dump($Group);dump($GroupUser);die;
		$this->assign('groupuser', $GroupUser);
		$this->assign('group', $Group);
		$this->display();
	}

	/**
	 * 修改会员信息
	 * @return [type] [description]
	 */
	public function editInfo()
	{
		$field = I('field');
		$user  = session('user_auth');
		if(IS_POST){
			switch ($field) {
				case 'head_img':
					$data['head_img'] = I('head_img');
					break;
				case 'phone':
					$data['phone'] = I('phone');
					break;
				case 'nick_name':
					$data['nick_name'] = I('nick_name');
					break;
				case 'sex':
					$data['sex'] = I('sex');
					break;
				case 'password':
					if(I('password') != I('password_re') ){
						$this->error('两次密码不同！');
						return ;
					}
					$where['password'] = think_ucenter_md5( I('password_old'));
					$data['password'] = think_ucenter_md5(I('password'));

					$where['id'] = $user['uid'];
					if(D('user')->where($where)->field('id')->find() === false){
						$this->error('密码修改失败！');
					}
					break;
			}
			$data['id']= $user['uid'];
			if(D('user')->save($data) !== false){
				if($field == 'password'){
					session('user_auth', null);
		        	session('user_auth_sign', null);
		        	$this->success('密码修改成功，需要重新登录！', U('Index/index'));
		        	die;
		        }
				$user = D('user')->field('id as uid,phone,nick_name,head_img,is_super,sex,is_activation,is_activation,status')->find($data['id']);
				if($user['head_img'] == '' || empty($user['head_img'])){
		            if($user['sex'] == 2){
		                $user['head_img'] = './Public/Mobile/images/icon/head_img_w.png';
		            }else{
		                $user['head_img'] = './Public/Mobile/images/icon/head_img_m.png';
		            }
		        }
		        session('user_auth', $user);
		        session('user_auth_sign', data_auth_sign($user));
				$this->success('修改成功', U('User/user_info'));
			}else{
				$this->error('修改失败！1');
			}
		}else{
			$this->assign('user',$user);
			$this->assign('field', $field);
			$this->display();
		}
	}

	 /**
     * 自己写的上传组件
     * @return [type] [description]
     */
    public function upload_HeadImg()
    {
        if(IS_AJAX){
            if(I('image') != ''){
                $img = I('image');
                $img = str_replace('data:image/png;base64,', '', $img);  
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $dir = './Uploads/Picture/' . date('Y-m-d');
                if(!is_dir($dir)){
                    mkdir($dir);
                }
                $file = $dir . '/' . uniqid() . '.png';
                $success = file_put_contents($file, $data);

                if($success){
                    $this->success($file);
                }else{
                    $this->error('上传失败！');
                }
            }else{
                $this->error('图片上传失败');
            }
        }
    }

	/**
	 * 禁用会员
	 * @return [type] [description]
	 */
	public function forUser()
	{
		if(IS_AJAX){
			$id = I('id');

			if($id == ''){
				$this->error('禁用失败');
			}
			$data['id'] = $id;
			$data['status'] = -1;
			if(D('user')->save($data)){
				$this->success('禁用成功！');
			}else{
				$this->error('禁用失败！');
			}
		}
	}
	/**
	 * 禁用会员
	 * @return [type] [description]
	 */
	public function acUser()
	{
		if(IS_AJAX){
			$id = I('id');

			if($id == ''){
				$this->error('启用失败');
			}
			$data['id'] = $id;
			$data['status'] = 1;
			if(D('user')->save($data)){
				$this->success('启用成功！');
			}else{
				$this->error('启用失败！');
			}
		}
	}

	/**
	 * 删除会员
	 * @return [type] [description]
	 */
	public function delUser()
	{
		$id = I('id');
		if(D('user')->delete($id) && D('group_user')->where('uid=' . $id)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}


	/**
	 * 查看所有会员组信息
	 */
	public function group_info()
	{
		checkORredirect(!is_super());
		$group = session('group');
		$this->assign('group', $group);
		$this->display();
	}

}
