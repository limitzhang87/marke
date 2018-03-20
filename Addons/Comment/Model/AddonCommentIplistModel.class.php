<?php

namespace Addons\Comment\Model;
use Think\Model;

/**
 * Comment Iplist模型
 */
class AddonCommentIplistModel extends Model{

    private $_error;
    private $_success;
    private $_ip;
    private $addonCommentConfig;

    public function __construct() {
        parent::__construct();
        $this->_error = '';
        $this->_success = '';
        $this->_ip = get_client_ip();
        $this->addonCommentConfig = get_addon_config('Comment');
    }

    public function Error() {
        return $this->_error;
    }

    public function Success() {
        return $this->_success;
    }

    public function Ip() {
        return $this->_ip;
    }

    public function isValid($ip = '') {
        $ip = empty($ip) ? $this->_ip : $ip;
        if (empty($ip)) {
            $this->_error = '无效的IP';
            return false;
        }
        $map = array( 'ip' => $ip );
        $info = $this->where($map)->find();
        if (!$info) {
            $data['ip'] = $ip;
            $result = $this->data($data)->add();
            if (!$result) {
                $this->_error = '无法将IP写出';
                return false;
            }
            return true;
        }
        if ((int)$info['status'] !== 1) {
            $this->_error = 'IP被禁用';
            return false;
        }
        if ($this->addonCommentConfig['comment_frequency'] > 0 && time()-(int)$info['last_comment_time'] < (int)$this->addonCommentConfig['comment_frequency']) {
            $this->_error = '请间隔'.$this->addonCommentConfig['comment_frequency'].'秒后评论';
            return false;
        }
        return true;
    }

    public function updateIpStatus($status, $ip = '') {
        $ip = empty($ip) ? $this->_ip : $ip;
        $map = array('ip' => $ip);
        $data['status'] = $status;
        $this->where($map)->data($data)->save();
    }

    public function updateIpLastTime($ip = '') {
        if (empty($this->_error) || $this->addonCommentConfig['comment_frequency_strict'] == 1) {
            $ip = empty($ip) ? $this->_ip : $ip;
            $map = array('ip' => $ip);
            $data['last_comment_time'] = time();
            $this->where($map)->data($data)->save();
        }
    }

}