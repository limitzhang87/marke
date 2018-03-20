<?php
/**
 *留言板插件控制器管理
 *
 * @package default
 * @author  nzing@aweb.cc
 * @link http://aweb.cc
 */
namespace Addons\Messagezft\Controller;
use Home\Controller\AddonsController;
class MessagezftController extends AddonsController {
    /* 添加留言板 */
    public function view() {
        $current = U('/home/addons/adminlist/name/Messagezft');
        $this -> assign('current', $current);
        //获取配置文件信息
        $config_info =
        include_once ONETHINK_ADDON_PATH . 'Messagezft/config.inc.php';
        $this -> assign('group_type', $config_info['type']);
        $id = I('get.id', '');
        $info = D('Addons://Messagezft/Messagezft') -> detail($id);
        $this -> assign('info', $info);
         $config = get_addon_config('Messagezft');
         $this -> assign('config', $config);
        $this -> display(T('Addons://Messagezft@Messagezft/view'));
    }

    /* 禁用留言板 */
    public function forbidden() {
        $id = I('get.id', '');
        if ( D('Addons://Messagezft/Messagezft') -> forbidden($id)) {
            $this -> success('成功禁用该留言板', Cookie('__forward__'));
        } else {
            $this -> error( D('Addons://Messagezft/Messagezft') -> getError());
        }
    }

    /* 启用留言板 */
    public function off() {
        $id = I('get.id', '');
        if ( D('Addons://Messagezft/Messagezft') -> off($id)) {
            $this -> success('成功启用该留言板', Cookie('__forward__'));
        } else {
            $this -> error( D('Addons://Messagezft/Messagezft') -> getError());
        }
    }

    /* 删除留言板 */
    public function del() {
        $id = I('get.id', '');
        if ( D('Addons://Messagezft/Messagezft') -> del($id)) {
            $this -> success('删除成功', Cookie('__forward__'));
        } else {
            $this -> error( D('Addons://Messagezft/Messagezft') -> getError());
        }
    }

    /* 更新留言板 */
    public function update() {
        // 如果没有传值默认取POST数据
        $data = I('post.');
        $res = D('Addons://Messagezft/Messagezft') -> update();
        if (!$res) {
            $this -> error( D('Addons://Messagezft/Messagezft') -> getError());
        } else {
            if ($res['id']) {
                $this -> success('更新成功', Cookie('__forward__'));
            } else {
                $this -> success('预约成功', Cookie('__forward__'));
            }
        }
    }

    /* 更新留言板 */
    public function reply() {
        // 如果没有传值默认取POST数据
        $data = I('post.');
        $res = D('Addons://Messagezft/Messagezft') -> update();
        if (!$res) {
            $this -> error( D('Addons://Messagezft/Messagezft') -> getError());
        } else {
            if ($res['id']) {
                $this -> success('更新成功', Cookie('__forward__'));
            } else {
                $this -> success('预约成功', Cookie('__forward__'));
            }
        }
    }

    /**
     * 批量处理
     */
    public function savestatus() {
        $status = I('get.status');
        $ids = I('post.id');
        if ($status == 0) {
            foreach ($ids as $id) {
                D('Addons://Messagezft/Messagezft') -> off($id);
            }
            $this -> success('成功启用该留言板', Cookie('__forward__'));
        } else {
            foreach ($ids as $id) {
                D('Addons://Messagezft/Messagezft') -> forbidden($id);
            }
            $this -> success('成功禁用该留言板', Cookie('__forward__'));
        }
    }

}
