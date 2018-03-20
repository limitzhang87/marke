<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 采集管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------

	namespace Addons\Collection\Controller;
	use Home\Controller\AddonsController;
use Addons;
		class NodeController extends AddonsController{
    private $db;

    //初始化
    public function _initialize() {
        parent::_initialize();
        $this->db = D("Addons://Collection/CollectionNode");
        import('Collection.ORG.Collection','./Addons');
        import('Collection.Funs.funs', './Addons', '.php');
        import('Collection.ORG.QueryList','./Addons');
    }

    //采集管理
    public function index() {
        $where = array();
        $keyword = I("get.keyword", '', 'trim');
        if ($keyword) {
            $where['name'] = array("like", "%{$keyword}%");
            $this->assign("keyword", $keyword);
        }
        $count = $this->db->where($where)->count();
        $page = new \Think\Page($count, 20);
        $data = $this->db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("nodeid" => "desc"))->select();
        $this->assign("Page", $page->show());
        $this->assign("data", $data);
        $this->display(T('Addons://Collection@Node/index'));

        
    }

    //添加采集项目
    public function add() {
        if (IS_POST) {
            $data = I("post.data", null, "");
            if (!$data) {
                $this->error("参数非法！");
            }
            //自定义规则
            $customize_config = I("post.customize_config", "", "");
            $data['customize_config'] = array();
            if (is_array($customize_config)) {
                foreach ($customize_config['en_name'] as $k => $v) {
                    if (empty($v) || empty($customize_config['name'][$k])) {
                        continue;
                    }
                    $data['customize_config'][] = array(
                        'name' => $customize_config['name'][$k],
                        'en_name' => $v,
                        'rule' => $customize_config['rule'][$k],
                        'html_rule' => $customize_config['html_rule'][$k]
                    );
                }
            }
            //对自定义规则进行序列化
            $data['customize_config'] = serialize($data['customize_config']);
            //采集地址
            $data['urlpage'] = I('post.urlpage' . $data['sourcetype']);
            //自动验证
            $data = $this->db->create(array_merge($data, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME")))));
            if ($data) {
                if ($this->db->add($data)) {
                    $this->success("添加成功！", U("Addons/adminList/name/Collection"));
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->db->getError());
            }
        } else {
            $this->display(T('Addons://Collection@Node/add'));
        }
    }

    //修改采集项目
    public function edit() {
        if (IS_POST) {
            $nodeid = (int) I("post.nodeid");
            if (!$nodeid) {
                $this->error("该信息不存在！");
            }
            $data = I("post.data", null, "");
            if (!$data) {
                $this->error("参数非法！");
            }
            //自定义规则
            $customize_config = I("post.customize_config", "", "");
            $data['customize_config'] = array();
            if (is_array($customize_config)) {
                foreach ($customize_config['en_name'] as $k => $v) {
                    if (empty($v) || empty($customize_config['name'][$k])) {
                        continue;
                    }
                    $data['customize_config'][] = array(
                        'name' => $customize_config['name'][$k],
                        'en_name' => $v,
                        'rule' => $customize_config['rule'][$k],
                        'html_rule' => $customize_config['html_rule'][$k]
                    );
                }
            }
            //对自定义规则进行序列化
            $data['customize_config'] = serialize($data['customize_config']);
            //采集地址
            $data['urlpage'] = I('post.urlpage' . $data['sourcetype']);
            $data['urlpage_first'] = I('post.urlpage_first');
            //自动验证

            $data = $this->db->create(array_merge($data, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME")))));
            if ($data) {
                if (false !== $this->db->save($data)) {
                    $this->success("修改成功！",  U("Addons/adminList/name/Collection"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error($this->db->getError());
            }
        } else {
            $nodeid = (int) I("get.nodeid");
            if (!$nodeid) {
                $this->error("该信息不存在！");
            }
            $info = $this->db->where(array("nodeid" => $nodeid))->find();
            
            if ($info) {
                //自定义规则
                $info['customize_config'] = unserialize($info['customize_config']) ? unserialize($info['customize_config']) : array();
                $this->assign("data", $info);
                $this->assign("nodeid", $info['nodeid']);
            } else {
                $this->error("该信息不存在！");
            }
        }
   
        $this->display(T('Addons://Collection@Node/edit'));
    }

    //删除采集项目
    public function delete() {
        if (IS_POST) {
            $nodeid = I("post.nodeid");
            if ((is_array($nodeid) && count($nodeid) < 1) || !$nodeid) {
                $this->error("请指定需要删除的采集节点！");
            }
        } else {
            $nodeid = (int) I("get.nodeid");
            if (!$nodeid) {
                $this->error("请指定需要删除的采集节点！");
            }
        }
        //删除
        if (false !== $this->db->nodeDelete($nodeid)) {
            $this->success("删除采集节点成功！",  U("Addons/adminList/name/Collection"));
        } else {
            $this->error("删除失败！");
        }
    }

    //复制采集项目
    public function copy() {
        $nodeid = (int) I("get.nodeid");
        if(!$nodeid){
        	$nodeid = (int) I("post.nodeid");
        }
        if (!$nodeid) {
            $this->ajaxReturn(array('status'=>0,'message'=>'请指定需要复制的采集节点！'));
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            if (IS_POST) {
                unset($info['nodeid']);
                $name = I("post.name", '', "trim");
                $info['title'] = $name;
                $info = array_merge($info, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME"))));
                $data = $this->db->create($info);
                if ($data) {
                    if ($this->db->add($data)) {
                        $this->ajaxReturn(array('status'=>1,'message'=>'采集节点复制成功！'));
                    } else {
                        $this->ajaxReturn(array('status'=>0,'message'=>'采集节点复制失败！'));
                    }
                } else {
                    $this->error($this->db->getError());
                }
            } else {
            	$this->assign("info", $info);
                $this->assign("nodeid", $nodeid);
            }
        } else {
           
            $this->ajaxReturn(array('status'=>0,'message'=>'该采集节点不存在！'));
        }
        $this->display(T('Addons://Collection@Node/copy'));
    }

    //导入采集项目
    public function node_import() {
        if (IS_POST) {
            if (!$_FILES['file']) {
                $this->error("请选择上传文件！");
            }
            $filename = $_FILES['file']['tmp_name'];
            if (strtolower(substr($_FILES['file']['name'], -3, 3)) != 'txt') {
                $this->error("上传的文件格式有误！");
            }
            //读取文件
            $data = json_decode(base64_decode(file_get_contents($filename)), true);
            @unlink($filename);
            $name = I("post.name", '', "trim");
            $data['name'] = $name;
            unset($data['lastdate']);
            $info = array_merge($data, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME"))));
            $data = $this->db->create($info);
            if ($data) {
                if ($this->db->add($data)) {
                    $this->success("采集节点导入成功！", U("Addons/adminList/name/Collection"));
                } else {
                    $this->error("采集节点导入失败！");
                }
            } else {
                $this->error($this->db->getError());
            }
        } else {
            $this->display(T('Addons://Collection@Node/node_import'));
        }
    }

    //采集第一步，采集网址入库
    public function col_url_list() {

    		header("Content-type: text/html; charset=utf-8");

        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            //得到需要采集的网页列表页
        	import('ORG.Collection');
            $urls = \Collection::url_list($info);
            //总数
            if (is_array($urls)) {
                $total_page = count($urls);
            } else {
                $total_page = 0;
            }
            if ($total_page > 0) {
                $page = I("get.page", 0, "intval");
                $url_list = $urls[$page];
                //获取文章网址
                $url = \Collection::get_url_lists($url_list, $info);
                
    
                $title=$info['list_title'];
                $href=$info['url_regular'];
                $reg = array("title"=>array($title,"text"),"url"=>array($href,"href"));
                $rang=$info['list_list'];
                
                $hj = \QueryList::Query($url_list,$reg,$rang,'curl','UTF-8');
                $arr = $hj->jsonArr;  
                foreach ($arr as $k => $v) {
                	if(substr($v['url'],0,7) != 'http://'){
                			$first=substr( $v['url'], 0, 1 );
                    		if($first=='.'){
                    			$url_new=substr( $v['url'], 1);
                    			$arr[$k]['url'] =  $info['site'] . $url_new;
                    		}else{
                    			$arr[$k]['url'] =  $info['site'] .$v['url'];
                    		}
                	}
                	unset($v); // 最后取消掉引用
                } 
                $url=$arr;
               // array_splice($arr, 10);
                $history_db = M('CollectionHistory');
                $content_db = M('CollectionContent');
                //总数
                if (is_array($url)) {
                    $total = count($url);
                } else {
                    $total = 0;
                }
                //重复记录
                $re = 0;
                if (is_array($url) && !empty($url)) {
                    foreach ($url as $v) {
                        if (empty($v['url']) || empty($v['title'])) {
                            continue;
                        }
                        $data = array();
                        //去除html
                        $v['title'] = strip_tags($v['title']);
                        //对地址进行加密当作标识符
                        $md5 = md5($v['url']);
                        //检测是否已经存在
                        if (!$history_db->where(array('md5' => $md5))->find()) {
                            //添加 Collection_col_url_list 标签
                            tag('Collection_col_url_list', $data);
                            $data['history'] = array(
                                'md5' => $md5,
                                'nodeid' => $nodeid
                            );
                            //添加记录
                            $history_db->add($data['history']);
                            $data['content'] = array(
                                'nodeid' => $nodeid,
                                'status' => 0,
                                'url' => $v['url'],
                                'title' => $v['title']
                            );
                            $content_db->add($data['content']);
                        } else {
                            $re++;
                        }
                    }
                }
                //更新最后采集时间
               // if ($total_page <= $page) {
                    $this->db->where(array('nodeid' => $nodeid))->save(array('lastdate' => time()));
               // }
                $this->assign("url_list", $url_list);
                $this->assign("total", $total);
                $this->assign("re", $re);
                $this->assign("page", $page);
                $this->assign("urllist", $url);
                $this->assign("nodeid", $nodeid);
                //由于数组是从0开始，但是根据这个总数和页数进行判断是否继续下一页，所以减一
                $this->assign("total_page", $total_page - 1);
                $this->display(T('Addons://Collection@Node/col_url_list'));
            } else {
                $this->error("没有内容可采集！");
            }
        } else {
            $this->error("该采集节点不存在！");
        }
    }

    //采集第二部，内容采集入库
    public function col_content() {
        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            $content_db = M("CollectionContent");
            $page = I("get.page", 1, "intval");
            $total = I("get.total", 0, "intval");
            if (empty($total)) {
                //统计未采集数量
                $total = $content_db->where(array('nodeid' => $nodeid, 'status' => 0))->count();
            }
            //每次采集两条，分页总数
            $total_page = ceil($total / 2);
            $list = $content_db->where(array('nodeid' => $nodeid, 'status' => 0))->limit(2)->order(array("id" => "desc"))->getField("id,url");
            $i = 0;
            if (!empty($list) && is_array($list)) {
                foreach ($list as $id => $url) {
                    //获取采集内容
                    $html = \Collection::get_content($url, $info);
                   
                    //更新附件状态
                   // service("Attachment")->api_update('', 'cj-' . $nodeid . '-' . $id, 2);
                    $data = array(
                        'status' => 1,
                        'data' => serialize($html)
                    );
                    //添加Collection_col_content标签
                    tag("Collection_col_content", $data);
                    $content_db->where(array('id' => $id))->save(array('status' => 1, 'data' => serialize($html)));
                    $i++;
                }
            } else {
                $this->success("内容采集完成！",U("Addons/adminList/name/Collection"));
                exit;
            }
            //如果总分页数大于当前分页数，则进行下一轮采集
            if ($page <= $total_page) {
                $this->assign("waitSecond", 2);
                $this->success("采集正在进行中，采集进度:<font color=\"#FF0000\"> " . ($page * 2) . '/' . $total . " </font> ", addons_url("Collection://node/col_content", array("page" => $page + 1, "nodeid" => $nodeid, "total" => $total)));
            } else {
                $this->db->where(array('nodeid' => $nodeid))->save(array('lastdate' => time()));
                exit;
                $this->success("采集完成！", U("Addons/adminList/name/Collection"));
            }
        } else {
            $this->error("该采集节点不存在！");
        }
    }

    //采集入库
    public function publist() {
        $nodeid = (int) I("get.nodeid");
        $status = I("get.status");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        if (!$status) {
        	$status=2;//默认跳转已采集
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            $content_db = M("CollectionContent");
            $where = array();
            $where['nodeid'] = $nodeid;
            if ($status) {
                //0:未采集,1:已采集,2:已导入}
                $where['status'] = (int) $status - 1;
                $this->assign("status", $status);
            }
            $count = $content_db->where($where)->count();
           // $page = $this->page($count, 20);
            $page = new \Think\Page($count, 20, $REQUEST);
            $data = $content_db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
            $this->assign("data", $data);
            $this->assign("nodeid", $nodeid);
            $this->assign("Page", $page->show('Admin'));
            $this->display(T('Addons://Collection@Node/publist'));
        } else {
            $this->error("该采集节点不存在！");
        }
    }

    //文章导入
    public function import() {
        $nodeid = (int) I("request.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        $this->assign("nodeid", $nodeid);
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if (!$info) {
            $this->error("该采集节点不存在！");
        }
        //导入类型
        $type = I("get.type");
        $ids = I("post.id");
        if(!$ids){
        	$ids = I("get.ids");
        }

        if ($type == 'all') {
            //全部
        } else {
            if (!$ids) {
                $this->error("请指定需要导入的信息！");
            }else if(is_array($ids)){
            	$ids = implode('_', $ids);
            }
        }
        //导入方案
        $program_db = D("CollectionProgram");
        $where['nodeid']=$nodeid;
        $where['model']=2;//暂时只发新闻
        $program_list = $program_db->where($where)->select();
        //栏目
        $rs= M('Category')->field('id,pid as parentid,title as name')->where($where)->select();
     
        $catlist = array();
        foreach ($rs as $k => $v) {
            $result[$v['id']] = $v;
             $catlist[$v['id']] = $v;
//             if ($v['child'] == '0') {
//                 $result[$k]['disabled'] = "";
//             } else {
//                 $result[$k]['disabled'] = "disabled";
//             }
        }

        $tree = new \Think\Tree();     
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $str = "<option value='\$id' \$selected \$disabled>\$spacer \$name</option>";
        $tree->init($result);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("select_categorys", $select_categorys);
        $this->assign("catlist", $catlist);
        $this->assign("program_list", $program_list);
        $this->assign("type", $type);
        $this->assign("ids", $ids);
        $this->display(T('Addons://Collection@Node/import'));
    }
    //文章导入
    public function import_program() {
    	$nodeid = (int) I("request.nodeid");
    	if (!$nodeid) {
    		$this->error("请指定采集节点！");
    	}
    	$this->assign("nodeid", $nodeid);
    	$info = $this->db->where(array("nodeid" => $nodeid))->find();
    	if (!$info) {
    		$this->error("该采集节点不存在！");
    	}
    	//导入类型
    	$type = I("get.type");
    	$ids = I("post.id");
    	if(!$ids){
    		$ids = I("get.ids");
    	}
    
//     	if ($type == 'all') {
//     		//全部
//     	} else {
//     		if (!$ids) {
//     			$this->error("请指定需要导入的信息！");
//     		}else if(is_array($ids)){
//     			$ids = implode('_', $ids);
//     		}
//     	}
    	//导入方案
    	$program_db = D("CollectionProgram");
    	$where['nodeid']=$nodeid;
    	//$where['model']=$nodeid;
    	$program_list = $program_db->where($where)->select();
    	//栏目
    	$rs= M('Category')->field('id,pid as parentid,title as name')->where($where)->select();
    	 
    	$catlist = array();
    	foreach ($rs as $k => $v) {
    		$result[$v['id']] = $v;
    		$catlist[$v['id']] = $v;
    		//             if ($v['child'] == '0') {
    		//                 $result[$k]['disabled'] = "";
    		//             } else {
    		//                 $result[$k]['disabled'] = "disabled";
    		//             }
    	}
    
    	$tree = new \Think\Tree();
    	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
    	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	$str = "<option value='\$id' \$selected \$disabled>\$spacer \$name</option>";
    	$tree->init($result);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
    	$this->assign("catlist", $catlist);
    	$this->assign("program_list", $program_list);
    	$this->assign("type", $type);
//     	$this->assign("ids", $ids);
    	$this->display(T('Addons://Collection@Node/import_program'));
    }
    //导入文章到模型
    public function import_content() {
        C("TOKEN_ON", false);
        define('GROUP_MODULE', 'Content');
        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        $category_id = (int) I("post.category_id");
        if (!$category_id) {
        	$category_id = (int) I("get.category_id");
        	if(!$category_id){
        		$this->error("请指定所导入的分类！");
        	}
        }
        $Category = D('Category');
        	/* 获取分类信息 */
        $Category_rs = $Category->info($category_id);
        $this->assign("nodeid", $nodeid);
        $node = $this->db->where(array("nodeid" => $nodeid))->find();
        if (!$node) {
            $this->error("该采集节点不存在！");
        }
        $ids = I("get.ids");
        $programid = I("post.programid");
        if (!$programid) {
        	$programid = (int) I("get.programid");
            if (!$programid) {
           	 $this->error("请指定采集方案！");
       		 }
        }

        $program_db = D("CollectionProgram");
        $collection_content_db = D("CollectionContent");

        //导入顺序
        $order = $node['coll_order'] == 1 ? 'id desc' : '';
        $type = I("get.type");
        //执行完跳转地址
        $jumpUrl =addons_url("Collection://Node/publist", array('nodeid'=>$nodeid,'status'=>2));

        if ($type == 'all') {//全部导入
            //总数
            $total = I("get.total", '', 'intval');
            if (empty($total)) {
                $total = $collection_content_db->where(array('nodeid' => $nodeid, 'status' => 1))->count();
            }
            //导入轮数 每次20条入库
            $total_page = ceil($total / 20);
            $page = I("get.page", 1, 'intval');
            //取得数据
            $data = $collection_content_db->where(array('nodeid' => $nodeid, 'status' => 1))->order($order)->limit(20)->select();
        } else {
            if (!$ids) {
                $this->error("请指定需要导入库的信息！");
            }
            $ids = explode('_', $ids);
            $data = $collection_content_db->where(array('nodeid' => $nodeid, 'status' => 1, 'id' => array("in", $ids)))->order($order)->select();
            $total = count($data);
        }

        //取得方案
        $program = $program_db->where(array('id' => $programid))->find();
        $program['config'] = unserialize($program['config']);
        //自动提取摘要 
        $_POST['add_introduce'] = $program['config']['add_introduce']; //是否截取内容
        $_POST['introcude_length'] = $program['config']['introcude_length']; //截取长度
        //自动提取缩略图
        $_POST['auto_thumb'] = $program['config']['auto_thumb'];
        $_POST['auto_thumb_no'] = $program['config']['auto_thumb_no'];

        $i = 0;
        $coll_contentid = array();
        //内容处理
        foreach ($data as $k => $v) {
            //入库数据数组
            $sql = array(
                'category_id' => $category_id,
            	'province' => $Category_rs['province'],
            	'city' => $Category_rs['city'],
            	'district' => $Category_rs['district'],
            	'community' => $Category_rs['community'],
            	'model_id' => $program['model_id'],
                'status' => $program['config']['content_status']
            );
            $v['data'] = unserialize($v['data']);
            
            //如果值不存在或者为空。则填充默认数据
            foreach ($program['config']['default'] as $k => $b) {
                //存在该字段，且值为空，则默认值填充
                if (isset($v['data'][$k]) && empty($v['data'][$k])) {
                    $v['data'][$k] = $program['config']['default'][$k];
                } else if (!isset($v['data'][$k])) {//如果默认数据的字段不存在，直接填充进去
                    $v['data'][$k] = $program['config']['default'][$k];
                }
            }
  
            //根据对应关系补充数据
            foreach ($program['config']['map'] as $a => $b) {

                //检查是否需要进行自定义处理函数
                if (isset($program['config']['funcs'][$a])) {
                    //把字段名加入到全局变量中
                    $GLOBALS['field'] = $a;
                    try {
                    	$args = explode("|", $program['config']['funcs'][$a]);
                        $sql[$a] = call_user_func($args[0], $v['data'][$b] ? $v['data'][$b] : $v['data'][$a],$args[1]);
                    } catch (Exception $exc) {
                        $sql[$a] = $v['data'][$b] ? $v['data'][$b] : $v['data'][$a];
                    }
                } else {
                    $sql[$a] = $v['data'][$b] ? $v['data'][$b] : $v['data'][$a];
                }
                //内容是否分页
                if ((int) $node['content_page'] == 1) {
                    $sql['paginationtype'] = 2; //手动分页
                }
            
            }
//             $_POST['article_type'] = $v['data']['article_type'];
//             $_POST['content'] = $v['data']['content'];
          //  $v['data']['content']= htmlspecialchars($v['data']['content']);
            //合并数据
            $sql = array_merge($v['data'], $sql);
            if(empty($sql['description'])){
            	$sql['description']=cut($sql['content'],'0,100');
            }

            //添加Collection_import_content 标签
            tag("Collection_import_content", $sql);
            $document   =   D('Document');
//             print_r($sql);exit;
            $res = $document->update($sql,'1');
            $contentid=$res['new_id'];
           // $contentid = $this->Content->add($sql);
            if ($contentid) {
                $coll_contentid[] = $v['id'];
                $i++;
                //更新附件
//                 $aids = M("AttachmentIndex")->where(array('keyid' => 'cj-' . $nodeid . '-' . $v['id']))->field('aid')->select();
//                 if ($aids) {
//                     $a_ids = array();
//                     foreach ($aids as $r) {
//                         $a_ids[] = $r['aid'];
//                     }
//                     M("AttachmentIndex")->where(array('keyid' => 'cj-' . $nodeid . '-' . $v['id']))->save(array("keyid" => 'c-' . $program['category_id'] . '-' . $contentid));
//                     M("Attachment")->where(array("aid" => array("in", $a_ids)))->save(array("module" => "content"));
//                 }
                //更新采集状态
               $data=array(
               		'status'=>2,
               		'article_id'=>$res['new_id'],
               		'model_id'=>$program['model_id'],
               		'category_id'=>$category_id,
               );
                $collection_content_db->where(array("id" => array("in", $coll_contentid)))->save($data);
            } else {
                $this->error($document->getError(), addons_url('Collection://Node/publist', array('nodeid' => $nodeid)));
            }
        }

        if ($type == 'all' && $total_page > $page) {
            $this->assign("waitSecond", 2);
            $message = "正在导入中，导入进度：" . (($page - 1) * 20 + $i) . '/' . $total;
            $jumpUrl = addons_url("Collection://Node/import_content", array('nodeid'=> $nodeid ,'programid' => $programid ,'type'=>'all','category_id' => $category_id,'page'=> ($page + 1) ,'total'=>$total));
        } else {
            $message = "导入成功！";
        }

        $this->success($message, $jumpUrl);
    }

    //删除已经采集的文章
    public function content_del() {
        $nodeid = (int) I("post.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }
        $this->assign("nodeid", $nodeid);
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if (!$info) {
            $this->error("该采集节点不存在！");
        }
        $ids = I("post.id");
        if (!is_array($ids)) {
            $this->error("请指定需要删除的信息！");
        }
        //添加Collection_content_del标签
        tag("Collection_content_del", $info);
        //同时删除采集历史记录
        $history = I("request.history");
        $collection_content_db = M("CollectionContent");
        $history_db = M("CollectionHistory");
        if ($history) {
            $data = $collection_content_db->where(array("id" => array("IN", $ids)))->select();
            $list = array();
            foreach ($data as $v) {
                $list[] = md5($v['url']);
            }
          
            $history_db->where(array("md5" => array("IN", $list), "nodeid" => $nodeid))->delete();
        }
        $collection_content_db->where(array("id" => array("IN", $ids)))->delete();
        //删除对应附件
        $delFile = array();
        foreach ($ids as $id) {
            $delFile[] = 'cj-' . $nodeid . '-' . $id;
        }
       // service("Attachment")->api_delete(array('IN', $delFile));
        $this->success("删除成功！");
    }

    //添加导入方案
    public function import_program_add() {
        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定采集节点！");
        }

        $this->assign("nodeid", $nodeid);
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if (!$info) {
            $this->error("该采集节点不存在！");
        }
        if(I("get.model_id")==''){
        	$model_id = I("post.model_id", 0, 'intval');
        }else{
        	$model_id = I("get.model_id", 0, 'intval');
        }
       
        if (!$model_id) {
            $this->error("请指定模型！");
        }
       // $cat = get_category($category_id);
//         if ($cat['type'] != 0) {
//             $this->error("栏目类型不正确！");
//         }
        $type = I("get.type");
        $ids = I("get.ids");
        $model_field = I("post.model_field");
        if ($model_field) {
            $config = array();
            if (!$model_field) {
                $this->error("参数错误！");
            }
            $node_field = I("post.node_field");
            if (!$node_field) {
                $this->error("参数错误！");
            }
            $funcs = I("post.funcs", array(), 'trim');

            $config['add_introduce'] = I("post.add_introduce", 0, 'intval');
            $config['auto_thumb'] = I("post.auto_thumb", 0, 'intval');
            $config['introcude_length'] = I("post.introcude_length", 0, 'intval');
            $config['auto_thumb_no'] = I("post.auto_thumb_no", 0, 'intval');
            $config['content_status'] = I("post.content_status", 1, 'intval');

            //模型字段和入库数据对应关系
            foreach ($node_field as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['map'][$model_field[$k]] = $v;
            }

            //自定义处理函数
            foreach ($funcs as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['funcs'][$model_field[$k]] = $v;
            }

            //默认值
            $default = I("post.default", array());
            foreach ($default as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['default'][$model_field[$k]] = $v;
            }

            $data = array('config' => serialize($config), 'nodeid' => $nodeid, 'model_id' => $model_id,  'name' => I('post.name'));
            $program_db = D("CollectionProgram");
            $data = $program_db->create(array_merge($data, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME")))));
            if ($data) {
                $id = $program_db->add($data);
                if ($id) {
                    $this->success("发布方案添加成功！",addons_url('Collection://Node/import_program', array('programid' => $id, 'nodeid' => $nodeid, 'ids' => $ids, 'type' => $type)));
                } else {
                    $this->error("发布方案添加失败！");
                }
            } else {
                $this->error($program_db->getError());
            }
        } else {
//             $modelField = cache('ModelField');
//             //读取数据模型缓存
//             $model = $modelField[$cat['model_id']];
//             if (empty($model)) {
//                 $this->error("模型不存在！");
//             }

//            	$model_id     =   get_category($category_id, 'model');
//             if(empty($model_id)){
//             	$model_id=2;
//             }
        	$where['is_show']=1;
        	//$where['type']=array('in','string,num,textarea,datetime');
            $model = get_model_attribute($model_id,false,'id,name,title,type,extra,is_must',$where);
           // print_r($model);exit;
            
            
            $node_data = $info;
            $node_data['customize_config'] = unserialize($node_data['customize_config']);
            $node_field = array('' => "请选择", 'title' => "标题", 'author' => "作者", 'comeform' => "来源", 'time' => "时间", 'content' => "内容");
            if (is_array($node_data['customize_config'])) {
                foreach ($node_data['customize_config'] as $k => $v) {
                    if (empty($v['en_name']) || empty($v['name'])) {
                        continue;
                    }
                    $node_field[$v['en_name']] = $v['name'];
                }
            }
           // $this->assign("cat", $cat);
            $this->assign("model_field", $model);
            $this->assign("model_id", $model_id);
            $this->assign("node_field", $node_field);
            $this->assign("type", $type);
            $this->assign("ids", $ids);
            $this->display(T('Addons://Collection@Node/import_program_add'));
        }
    }

    //删除导入方案
    public function import_program_del() {
        $id = (int) I("get.id");
        if (!$id) {
            $this->error("请指定需要删除的导入方案！");
        }
        $this->assign("id", $id);
        $program_db = M("CollectionProgram");
        $info = $program_db->where(array("id" => $id))->find();
        if (!$info) {
            $this->error("该导入方案不存在！");
        }
        if (false !== $program_db->where(array("id" => $id))->delete()) {
            $this->success("删除成功！");
        } else {
            $this->error("删除成功！");
        }
    }

    //编辑导入方案
    public function import_program_edit() {
        $id = (int) I("get.id");
        if (!$id) {
            $this->error("请指定需要编辑的导入方案！");
        }
        $program_db = D("CollectionProgram");
        $info = $program_db->where(array("id" => $id))->find();
        if (!$info) {
            $this->error("该导入方案不存在！");
        }
        $info['config'] = unserialize($info['config']);
        $this->assign($info);
        $nodeid = (int) $info['nodeid'];
        $node_data = $this->db->where(array("nodeid" => $nodeid))->find();
        if (!$node_data) {
            $this->error("该采集节点不存在！");
        }
        $model_id= $info['model_id'];
        if (!$model_id) {
            $this->error("请指定栏目！");
        }
      //  $cat = get_category($category_id);
//         if ($cat['type'] != 0) {
//             $this->error("栏目类型不正确！");
//         }
        $type = I("get.type");
        $ids = I("get.ids");
        if (IS_POST) {
            $config = array();
            $model_field = I("post.model_field");
            if (!$model_field) {
                $this->error("参数错误！");
            }
            $node_field = I("post.node_field");
            if (!$node_field) {
                $this->error("参数错误！");
            }
            $funcs = I("post.funcs", array(), 'trim');
            $config['add_introduce'] = I("post.add_introduce", 0, 'intval');
            $config['auto_thumb'] = I("post.auto_thumb", 0, 'intval');
            $config['introcude_length'] = I("post.introcude_length", 0, 'intval');
            $config['auto_thumb_no'] = I("post.auto_thumb_no", 0, 'intval');
            $config['content_status'] = I("post.content_status", 1, 'intval');
            //模型字段和入库数据对应关系
            foreach ($node_field as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['map'][$model_field[$k]] = $v;
            }
            //自定义处理函数
            foreach ($funcs as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['funcs'][$model_field[$k]] = $v;
            }
            //默认值
            $default = I("post.default", array());
            foreach ($default as $k => $v) {
                if (empty($v)) {
                    continue;
                }
                $config['default'][$model_field[$k]] = $v;
            }
            $data = array('config' => serialize($config), 'nodeid' => $nodeid, 'model_id' => $model_id, 'name' => I('post.name'));
            $program_db = D("CollectionProgram");
            $data = $program_db->create(array_merge($data, array(C("TOKEN_NAME") => I("post." . C("TOKEN_NAME")))));
            if ($data) {
                $id = $program_db->where(array("id" => $id))->save($data);
                if (false !== $id) {
                    $this->success("发布方案修改成功！",addons_url('Collection://Node/import_program', array('programid' => $id, 'nodeid' => $nodeid, 'ids' => $ids, 'type' => $type)));
                } else {
                    $this->error("发布方案修改失败！");
                }
            } else {
                $this->error($program_db->getError());
            }
        } else {
//             $modelField = cache('ModelField');
//             //读取数据模型缓存
//             $model = $modelField[$cat['model_id']];
//             if (empty($model)) {
//                 $this->error("模型不存在！");
//             }
        	$where['is_show']=1;
        	//$where['type']=array('in','string,num,textarea,datetime');
            $model = get_model_attribute($model_id,false,'id,name,title,type,extra,is_must',$where);
            $node_data['customize_config'] = unserialize($node_data['customize_config']);
            $node_field = array('' => "请选择", 'title' => "标题", 'author' => "作者", 'comeform' => "来源", 'time' => "时间", 'content' => "内容");
            if (is_array($node_data['customize_config'])) {
                foreach ($node_data['customize_config'] as $k => $v) {
                    if (empty($v['en_name']) || empty($v['name'])) {
                        continue;
                    }
                    $node_field[$v['en_name']] = $v['name'];
                }
            }
            $this->assign("cat", $cat);
            $this->assign("model_field", $model);
            $this->assign("model_id", $model_id);
            $this->assign("node_field", $node_field);
            $this->assign("type", $type);
            $this->assign("ids", $ids);
            $this->display(T('Addons://Collection@Node/import_program_edit'));
        }
    }

    //导出采集项目
    public function export() {
        C('SHOW_PAGE_TRACE', false);
        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定需要复制的采集节点！");
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            unset($info['nodeid'], $info['name']);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=pc_collection_" . $nodeid . '.txt');
            echo base64_encode(json_encode($info));
        } else {
            $this->error("该采集节点不存在！");
        }
    }

    //显示采集地址。
    public function public_url() {
        $sourcetype = isset($_GET['sourcetype']) && intval($_GET['sourcetype']) ? intval($_GET['sourcetype']) : $this->error("缺少参数！");
        $pagesize_start = isset($_GET['pagesize_start']) && intval($_GET['pagesize_start']) ? intval($_GET['pagesize_start']) : 1;
        $pagesize_end = isset($_GET['pagesize_end']) && intval($_GET['pagesize_end']) ? intval($_GET['pagesize_end']) : 10;
        $par_num = isset($_GET['par_num']) && intval($_GET['par_num']) ? intval($_GET['par_num']) : 1;
        $urlpage = isset($_GET['urlpage']) && trim($_GET['urlpage']) ? trim($_GET['urlpage']) : $this->error("缺少参数！");
        echo "<textarea rows=\"22\" cols=\"108\">";
        while ($pagesize_start <= $pagesize_end) {
            echo str_replace('(*)', $pagesize_start, $urlpage) . "\n";
            $pagesize_start = $pagesize_start + $par_num;
        }
        echo "</textarea>";
    }

    //采集测试 文章URL采集
    public function public_test() {
        $nodeid = (int) I("get.nodeid");
        if (!$nodeid) {
            $this->error("请指定需要复制的采集节点！");
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        import('ORG.Collection');
        if ($info) {
            $urls = \Collection::url_list($info, 1);

            if (!empty($urls)) {
                foreach ($urls as $v) {
//                     $url = \Collection::get_url_lists($v, $info);

                    $title=$info['list_title'];
                    $href=$info['url_regular'];
                    $reg = array("title"=>array($title,"text"),"url"=>array($href,"href"));
                    $rang=$info['list_list'];
             
//                      $reg = array("title"=>array('  a:eq(0)',"text"),"url"=>array('   a:eq(0)',"href"));
//                      $rang='.main .newslist li';
                    
                    
                    $hj = \QueryList::Query($v,$reg,$rang,'curl','UTF-8');
                    
                    $arr = $hj->jsonArr;
                   // print_r($arr);exit;
                    foreach ($arr as $key => $val) {
                    	if(substr($val['url'],0,7) != 'http://'){
                    		$first=substr( $val['url'], 0, 1 );
                    		if($first=='.'){
                    			$url_new=substr( $val['url'], 1);
                    			$arr[$key]['url'] =  $info['site'] . $url_new;
                    		}else{
                    			$arr[$key]['url'] =  $info['site'] .$val['url'];
                    		}
                    	}
                    	unset($val); // 最后取消掉引用
                    }
                    $url=$arr;
                }
            }
            $this->assign("nodeid", $nodeid);
            $this->assign("urllist", $url);
            $this->display(T('Addons://Collection@Node/public_test'));
        } else {
            $this->error("该采集节点不存在！");
        }
    }

    //测试文章内容采集
    public function public_test_content() {
        $nodeid = (int) I("get.nodeid");
        $url = I("get.url");
        if (!$nodeid || empty($url)) {
            $this->error("参数不完整！");
        }
        $info = $this->db->where(array("nodeid" => $nodeid))->find();
        if ($info) {
            echo "<textarea rows=\"26\" cols=\"90\">";
            print_r(\Collection::get_content($url, $info));
            echo "</textarea>";
        } else {
            $this->error("该采集节点不存在！");
        }
    }

}
