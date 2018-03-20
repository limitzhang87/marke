<?php
/**
 * 置业计划控制器
 *
 * 描述：		置业计划
 * 所属项目:	marke
 * 开发者:		张继贤
 * 创建时间:	2017/8/10 11:12 AM
 * 版权所有:	中房通(www.zfangw.cn)
 */
namespace Wechat\Controller;

class OwnerShipController extends HomeController {

	/* 置业计划首页 */
	public function index1(){
		echo '置业计划';
	}


    /**
     * 置业计划表
     * @author 张继贤
     */
    public function index($id = ''){
        if(IS_AJAX){
            //组装置业计划表的所有数据
            $data['title']           = getHouses('title');
            $data['name']            = I('name')  ? I('name')  : '_______' ;
            $data['sex']             = I('sex') ? I('sex'):'先生' ;
            $data['create_time']     = I('create_time')  ? date('Y年m月d日',strtotime(I('create_time'))) :  date('Y年m月d日', time());
            $data['checked_houses']  = I('checked_houses') ?I('checked_houses') : 1 ;
            // $data['building_num'] = I('building_num_'.$data['checked_houses']) ? I('building_num_'.$data['checked_houses'])  : '_______'  ;
            // $data['unit_num']     = I('unit_num_'.$data['checked_houses']) ? I('unit_num_'.$data['checked_houses']) : '_______';
            // $data['house_num']    = I('house_num_' . $data['checked_houses']) ? I('house_num_' . $data['checked_houses']) : '';
            $data['building_num']    = I('building') ? I('building')  : '_______'  ;
            $data['unit_num']        = I('unit') ? I('unit') : '_______';
            $data['house_num']       = I('room') ? I('room')  : '_______';

            $data['area']                 = I('area') == '' ? '_______' : I('area');
            $data['unit_price']           = I('unit_price') == '' ? '_______' : number_format(I('unit_price'),2);
            $data['usbale_area']          = I('usbale_area') == '' ? '_______' : I('usbale_area');
            $data['usbale_unit_price']    = I('usbale_unit_price') == '' ? '_______' : number_format(I('usbale_unit_price'),2);
            if($data['usbale_area'] == '_______'){
                 $data['usbale_unit_price'] = '_______';
            }
            $data['pool_area']            = I('pool_area') == '' ? '_______' : I('pool_area');

            $data['selling_agent']        = I('selling_agent') == '' ? '_______' : I('selling_agent');
            $data['phone']                = I('phone') == '' ? '_______' : I('phone');
            $data['total_price_pre']      = number_format(I('total_price_pre'),2);
            $data['total_price_discount'] = I('total_price_discount');
            $data['total_price_now']      = number_format(I('total_price_now'),2);

            $data['pay_way']        = trim(I('pay_way'));
            switch ($data['pay_way']) {
                case '1': //直接支付
                    $data['front_money_1']    = I('front_money_1');
                    $data['percent_1']        = I('percent_1');
                    $data['downpayment_1']    = number_format(I('downpayment_1'),2);
                    // /$data['sign_date_1']      = date(strtotime(I('sign_date_1')),'Y年m月d日');
                    $data['sign_date_1']      = I('sign_date_1');
                    break;
                case '2': //银行按揭
                    $data['front_money_2']    = I('front_money_2');
                    $data['percent_2']        = I('percent_2');
                    $data['downpayment_2']    = I('downpayment_2');
                    $data['downpayment_2'][0] = number_format($data['downpayment_2'][0],2);
                    $data['downpayment_2'][1] = number_format($data['downpayment_2'][1],2);
                    $data['downpayment_2'][2] = number_format($data['downpayment_2'][2],2);
                    $data['sign_date_2']      = I('sign_date_2');
                    // $data['sign_date_2'][0]   = date(strtotime(I('sign_date_2')[0] ),'Y年m月d日');
                    // $data['sign_date_2'][1]   = date(strtotime(I('sign_date_2')[1] ),'Y年m月d日');
                    // $data['sign_date_2'][2]   = date(strtotime(I('sign_date_2')[2] ),'Y年m月d日');
                    break;
                case '3': //银行贷款
                    $data['front_money_3']    = I('front_money_3');
                    $data['percent_3']        = I('percent_3');
                    $data['downpayment_3']    = number_format(I('downpayment_3',2));
                    $data['sign_date_3']      = I('sign_date_3');
                    $data['loan_value']       = number_format(I('loan_value'));
                    $data['rate']             = I('rate');
                    $data['year']             = I('year');

                    $data['month_sip_1']      = number_format(I('month_sip_1'),2);
                    $data['interest_total_1'] = number_format(I('interest_total_1'),2);
                    $data['repayment_1']      = number_format( (I('loan_value')+ I('interest_total_1')),2);
                    $data['ac_month_capital'] = number_format(I('ac_month_capital'),2);
                    $data['interest_total_2'] = number_format(I('interest_total_2'),2);
                    $data['repayment_2']      = number_format( (I('loan_value')+ I('interest_total_2')),2);

                    $data['calcdivate_type']  = I('calcdivate_type');
                    break;
            }

            //没有填写的空使用下划线代替
            $data['contract']                   = I('contract') == '' ? '____' : I('contract');
            $data['contract_rate']              = I('contract_rate') == '' ? '____' : I('contract_rate');
            $data['maintenance_fund']           = I('maintenance_fund') == '' ? '____' : I('maintenance_fund');
            $data['maintenance_fund_rate']      = I('maintenance_fund_rate') == '' ? '____' : I('maintenance_fund_rate');
            $data['price_regulation_fund']      = I('price_regulation_fund') == '' ? '____' : I('price_regulation_fund');
            $data['price_regulation_fund_rate'] = I('price_regulation_fund_rate') == '' ? '____' : I('price_regulation_fund_rate');
            $data['warrant_fee']                = I('warrant_fee') == '' ? '____' : I('warrant_fee');
            $data['gas_fee']                    = I('gas_fee') == '' ? '____' : I('gas_fee');
            $data['TV_fee']                     = I('TV_fee') == '' ? '____' : I('TV_fee');
            $data['another_fee']                = I('another_fee') == '' ? '____' : I('another_fee');
            // /$this->ajaxReturn($data);
            //置业计划图片大小
            $width = 800;
            $height = 1200;
            //初始化置业计划图片和颜色参数
            $img        = imagecreatetruecolor($width,$height);
            $bgcolor    = imagecolorallocate($img,176,224,230);
            $headcolor  = imagecolorallocate($img,0,100,0);
            $titlecolor = imagecolorallocate($img,255,127,80);
            $fontcolor  = imagecolorallocate($img,0,0,0);

            //标题字体和内容字体
            $fonttitle = 'simsun.ttc';
            $font =  './Public/Home/fonts/msyh.ttf';

            imagefill($img,0,0,$bgcolor);//填充背景颜色
            imagerectangle( $img, 15, 12, $width-15, $height-10, $fontcolor );//绘制边框
            imagefilledrectangle( $img , 23 , 20 , $width-23 , 100 , $headcolor );

            $titlenum = ceil(strlen($data['title'])/3);//标题字数每个汉字为3个长度
            $titleFontSize = ($width-100)/1.8/$titlenum;
            if($titleFontSize > 60){
                $titleFontSize  = 60;
            }
            $titleX = ( $width/2.2 - ($titleFontSize*$titlenum)/1.8 );
            $titleY = ( 60 + ($titleFontSize/1.8));
            imagettftext($img, $titleFontSize, 0, $titleX, $titleY, $titlecolor, $fonttitle, $data['title']);//设置标题


            $contentX = 50;
            $contentY = 140;
            $sp = 28;
            $n = 1;
            $contentSize = 15;

            //绘制置业计划内容
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '客户：'.$data['name'].' '.$data['sex'].'     日期：' . $data['create_time']);

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '认购单位： '.$data['building_num'].' - '.$data['unit_num'].' - '.$data['house_num']);

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '建筑面积：'.$data['area'].' m²     建筑单价：'.$data['unit_price'].'元');

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '套内面积：'.$data['usbale_area'].' m²     套内单价：'.$data['usbale_unit_price'].'元     公摊面积：' . $data['pool_area'] . ' m² ');

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '销售代理：'.$data['selling_agent'].'    联系电话：'.$data['phone'].' ');

            $n +=1;
            imagettftext($img, $contentSize*1.6, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '付款计划');

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '原总价：'.$data['total_price_pre'].'元    当前优惠折扣：'.$data['total_price_discount'].'%');

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '折后总价：'.$data['total_price_now'].'元');
            $n+=1;
            switch ($data['pay_way']) {
                case '1':
                    imagettftext($img, $contentSize*1.4, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '一次性付款');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  1、定金：'.$data['front_money_1'].' 元,在签署《认购书》时付清；');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  2、折后总价：'.$data['downpayment_1'].'元（含定金），');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       于认购书签署后 ' . $data['sign_date_1'] . ' 日内付清，同时签约《商品房买卖合同》。');
                    break;
                case '2':
                    imagettftext($img, $contentSize*1.4, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '分期付款');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  1、定金：'.$data['front_money_2'].' 元,在签署《认购书》时付清；');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  2、首款期：房价 '.$data['percent_2'][0].'%，既 '.$data['downpayment_2'][0].'元（含定金），');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       于认购书签署后 ' . $data['sign_date_2'][0] . ' 日内付清，同时签约《商品房买卖合同》；');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  3、第二期房款：房价 '.$data['percent_2'][1].'%，既 '.$data['downpayment_2'][1].'元，');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       于签署《商品房买卖合同》后 '.$data['sign_date_2'][1].' 日内付清；');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  4、第三期房款：房价 '.$data['percent_2'][2].'%，既 '.$data['downpayment_2'][2].'元，');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       于签署《商品房买卖合同》后 '.$data['sign_date_2'][2].' 日内付清。');
                    break;
                case '3':
                    imagettftext($img, $contentSize*1.4, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '银行按揭');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  1、定金：'.$data['front_money_3'].' 元,在签署《认购书》时付清；');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  2、首款期：房价 '.$data['percent_3'].'%，既 '.$data['downpayment_3'].'元（含定金），');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       于认购书签署后 ' . $data['sign_date_3'] . ' 日内付清，同时签约《商品房买卖合同》。');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       贷款额：'.$data['loan_value'].'元办理银行按揭（取整到千位数）。');
                    imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '       贷款年率利：'.$data['rate'].'，按揭年数：'.$data['year'].'年（'.($data['year']*12).'期）');
                    $n+=1;

                    switch ($data['calcdivate_type']) {
                        case '1':
                            imagettftext($img, $contentSize*1.2, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, ' 等额本息');
                            imagettftext($img, $contentSize*0.8, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '   月均还款：'. $data['month_sip_1'].'元，总利息：'.$data['interest_total_1'].'元，还款总额：'.($data['repayment_1']).'元；');
                            break;
                        case '2':
                            imagettftext($img, $contentSize*1.2, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, ' 等额本金');
                            imagettftext($img, $contentSize*0.8, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '   月本金：'. $data['ac_month_capital'].'元，总利息：'.$data['interest_total_2'].'元，还款总额：'.($data['repayment_2']).'元。');
                            break;
                        case '3':
                            imagettftext($img, $contentSize*1.2, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, ' 等额本息');
                            imagettftext($img, $contentSize*0.8, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '   月均还款：'. $data['month_sip_1'].'元，总利息：'.$data['interest_total_1'].'元，还款总额：'.($data['repayment_1']).'元；');

                            imagettftext($img, $contentSize*1.2, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, ' 等额本金');
                            imagettftext($img, $contentSize*0.8, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '   月本金：'. $data['ac_month_capital'].'元，总利息：'.$data['interest_total_2'].'元，还款总额：'.($data['repayment_2']).'元。');
                            break;
                    }
                    break;
            }
            $n +=1;
            imagettftext($img, $contentSize*1.4, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '购房相关综合费用');

            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  契税：'.$data['contract'].'元（总房款的 '. $data['contract_rate'].' %,地税收取）');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  公共维修基金： '.$data['maintenance_fund'].' 元（建筑面积 '.$data['maintenance_fund_rate'].' 元/m²房管局监管专用账户）');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  价格调节基金：'.$data['price_regulation_fund'].' 元（总房款的 '.$data['price_regulation_fund_rate'].' %，财务局收取）');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  权证综合费：'.$data['warrant_fee'].' 元');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  燃气管道初装费：'.$data['gas_fee'].' 元');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  有线电视安装费：'.$data['TV_fee'].' 元');
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  其他费用：'.$data['another_fee'].' 元');
            $data['omnibus_fee'] = $data['contract']+$data['maintenance_fund']+$data['price_regulation_fund']+$data['warrant_fee']+$data['gas_fee']+$data['TV_fee']+$data['another_fee'];
            imagettftext($img, $contentSize, 0, $contentX, $contentY+$sp*$n++, $fontcolor, $font, '  购房相关综合费用合计：'.$data['omnibus_fee'].' 元');
            $n++;
            $tipcolor  = imagecolorallocate($img,255,0,0);
            imagettftext($img, $contentSize*0.9, 0, $contentX, $contentY+$sp*$n++, $tipcolor, $font, '  *以上所有数据，仅表示截止至当日的信息，仅供参考。最终价格、优惠等以签约为准。');
            imagettftext($img, $contentSize*0.9, 0, $contentX, $contentY+$sp*$n++, $tipcolor, $font, '   实际签约面积以政府批准测绘及商品房买卖合同为准。');

            // //获取网站logog图片合并
            // //1.图片地址
            // $src = './Public/logozfang.png';
            // //2、获取图片信息
            // $info = getimagesize($src);
            // //3、获取图片类型
            // $type = image_type_to_extension($info[2], false);
            // //4、在内存中创建一个和我们图像类型一样的图像
            // $func = "imagecreatefrom{$type}";//构建函数名
            // //5、把图片复制到我们的内存中
            // $imageLogo = $func($src);
            // $white = imagecolorallocate($imageLogo,255,255,255);
            // imagecolortransparent($imageLogo,$white);//去除logo图片中的白底
            // imagecopymerge( $img, $imageLogo, ($width-$info[0])/2, $height-$info[1]-20, 0, 0,$info[0], $info[1], 60 );
            imagettftext($img, $contentSize, 0, ($width-260)/2, $height-20, $fontcolor, $font, '技术支持：海南中房通网络科技有限公司');
            //header("Content-type:image/png");
            $setting = C('PICTURE_UPLOAD');//图片上传路径
            $filename = time()  . rand(1,9) . '.png' ;
            $dir = $setting['rootPath'] . date('Y-m-d') . '/';
            if(!is_dir($dir)){//判断是否存在上传路径的文件夹。没有就创建
                mkdir($dir);
            }
            $pic_path =  $dir. $filename;

            $a = imagePng($img, $pic_path);//第二个参数是输出图片到文件夹 P大写！！
            $res = array();
            if($a){
                $pic_data['path'] = $pic_path;
                $pic_data['houses_id'] = getHouse();
                $pic_data['uid'] = is_login();
                $pic_data['created_time'] = time();
                if($pic_data['id'] = D('ownership_pic')->field('uid,houses_id,path,created_time')->add($pic_data)){
                    $res['error'] = 0 ;
                    $pic_data['created_time'] = date('Y年m月d H:i:s',$pic_data['created_time']);
                    $res['path'] = $pic_data;
                }else{
                    $res['error'] = 1;
                    $res['msg'] = '生成图片失败';
                }
            }else{
                $res['error'] = 1;
                $res['msg'] = '生成图片失败';
            }
            $this->ajaxReturn($res);
        }else{
            //获取某个楼盘所有栋号，单元号，同类型房号，房号
            $houses_id = getHouse();
            $building = D('building')->where('houses_id=' . $houses_id)->field('id,b_name')->select();
            $unit = D('unit')->where('houses_id=' . $houses_id)->select();
            foreach ($unit as $vo) {
                $unit_ids[] = $vo['id'];
            }

            $room = D()
                    ->table('zf_room r')
                    ->join('zf_sameroom as sr on r.s_id=sr.id','left')
                    ->where('r.houses_id=' . $houses_id)
                    ->field('r.id,r.u_id,r.room_number,r.unit_price,r.usable_price,sr.area,sr.usable_area')
                    ->select();
            $unit_sort = array();
            for ($i = 0; $i < count($unit); $i++) {
                $unit_sort[$unit[$i]['b_id']][ $unit[$i]['id'] ] = $unit[$i];
            }

            $room_sort = array();
            for ($i = 0; $i < count($room); $i++) {
                $room_sort[$room[$i]['u_id']][  $room[$i]['id'] ] = $room[$i];
            }

            //dump($building);dump($unit_sort);dump($room_sort);die;

            /**
             * 如果是从房号信息传过来的，则需要得到它的房号ID，单元ID，栋ID
             */
            $r_id = I('id');
            $u_id = '';
            $b_id = '';

            if($r_id != ''){
                foreach ($room as $vo) {
                    if($vo['id'] ==$r_id){
                        $u_id = $vo['u_id'];
                    }
                }
                foreach ($unit as $vo) {
                    if($vo['id'] ==$u_id){
                        $b_id = $vo['b_id'];
                    }
                }
                $this->assign('_type', 1);
            }else{
                $b_id = $building[0]['id'];
                $first = current($unit_sort[$b_id]);
                $u_id = $first['id'];
                $first = current($room_sort[$u_id]);
                $r_id = $first['id'];
            }
            $this->assign('_building', $building);
            $this->assign('_unit', $unit_sort);
            $this->assign('_room', $room_sort);
            $this->assign('_building_json', json_encode($building));
            $this->assign('_unit_json', json_encode($unit_sort));
            $this->assign('_room_json', json_encode($room_sort));

            $this->assign('b_id', $b_id);
            $this->assign('u_id', $u_id);
            $this->assign('r_id', $r_id);

            //获取背景图片
            $ownership_man = cookie('ownership_man');
            if($ownership_bg_img == ''){
                $ownership_man  = D('ownership_man')->where('houses_id='.getHouse())->find();
                cookie('ownership_man', $ownership_man);
            }
            $this->assign('ownership_man',$ownership_man);
            $this->display();
        }
    }

    /**
     * 获取置业计划的图片
     */
    public function getOwnership_pic()
    {

        if(IS_AJAX){
            $page = I('page')?I('page') : 1;
            $limit = I('limit')? I('limit') : 10;
            $map = array();
            if( I('houses_id') != ''){
                $map['houses_id'] = I('houses_id');
            }
            $field = 'id,path,created_time';
            $Ownership_pic = D('ownership_pic');
            $list = array();
            $list['data'] = $Ownership_pic->where($map)->page($page)->order('id desc')->field($field)->limit($limit)->select();
            if($list['data'] == null){
                $list['data'] =0;
            }else{
                foreach ($list['data'] as $key => $value) {
                    $list['data'][$key]['created_time'] = date('Y年m月d日 H:i:s',$list['data'][$key]['created_time']);
                }
            }

            $this->ajaxReturn($list);
        }
    }

    /**
     *下载置业计划图片
     * @return [type] [description]
     */
    public function download_pic()
    {
        $file_url = I('url');
        if(!isset($file_url)||trim($file_url)==''){  
            return '500';
        }  
        if(!file_exists($file_url)){ //检查文件是否存在
            return '404';
        }  
        $file_name=basename($file_url);
        $file_type=explode('.',$file_url);
        $file_type=$file_type[count($file_type)-1];
        $file_name=trim($new_name=='')?$file_name:urlencode($new_name);
        $file_type=fopen($file_url,'r'); //打开文件
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($file_url));
        header("Content-Disposition: attachment; filename=".$file_name);
        //输出文件内容
        echo fread($file_type,filesize($file_url));
        fclose($file_type);
    }


    /**
     * 删除置业计划图片
     * @return [type] [description]
     */
    public function del_own_pic()
    {
        if(IS_AJAX){
            //trim( I('path') ) = '33_./Uploads/Picture/2017-05-09/14943124637.png' 
            $data = explode('_',  trim( I('path') ));
            $Ownership_pic = D('ownership_pic');
            $res = $Ownership_pic->delete($data[0]);
            if($res){
                @unlink($data[1]);//删除数据库中的图片
                $this->success($data);
            }else{
                 $this->error($data);
            }
        }
    }


    /**
     * 显示置业计划表图片，
     * 当用于生成一张图片之后跳转到置业计划图片详情页，用户可以分享
     * @return [type] [description]
     */
    // public function ownership_pic_show()
    // {
    //     $id = I('id');
    //     if($id == '' || empty($id)){
    //         $this->error('未找到图片');
    //     }

    //     $info = D('ownership_pic')->find($id);

    //     if( !$info || empty($info) ){
    //         $this->error('未找到图片');
    //     }

    //     $this->assign('id',$id );
    //     $this->assign('_title','置业计划');
    //     $this->meta_title = '置业计划';
    //     $seo['title'] = '置业计划书';
    //     $seo['keywords'] = '置业计划书';
    //     $seo['description'] = '为你分享了置业计划图';
    //     $this->assign('seo',$seo);
    //     $this->assign('info',$info);
    //     $this->display();
    // }

    public function lists()
    {
        $page = I('page')?I('page') : 1;
        $limit = I('limit')? I('limit') : 20;
        $map = array();
        if( I('houses_id') != ''){
            $map['houses_id'] = I('houses_id');
        }
        $field = 'id,path,created_time';
        $Ownership_pic = D('ownership_pic');
        $list = $Ownership_pic->where($map)->page($page)->order('id desc')->field($field)->limit($limit)->select();

        foreach ($list as $key => $value) {
            $list[$key]['created_time'] = date('Y年m月d日 H:i:s',$list[$key]['created_time']);
        }
        $count = $Ownership_pic->where($map)->count();
        $this->assign('_list', $list);
        $this->assign('totalpage', $count/$limit+1);

        $user = session('user_auth');
        $config['url'] =  U('Share/ownership_pic_show',array('id'=>$id));
        //'http://www.zfangw.net/index.php?s=Home/share/ownership_pic_show' . '/id/' .$id;
        $config['title'] = getHouses('title') . '户型图';
        $config['desc'] = $user['nick_name'] .'为你分享了'. getHouses('title') . '置业计划表';
        $config['img'] = 'http://www.zfangw.net' . $path;
        $config['img_title'] =  getHouses('title') . '置业计划表';
        $config['from'] = '海南中房通网络可以有限公司';
        $this->assign('config',json_encode($config));
        $this->display();
    }

    public function manager()
    {
        $this->login();
        checkORredirect(is_auth(AUTH_HOUSE_MANAGE));
        if(IS_POST){
            $id = I('id');
            $data['bg_img'] = I('bg_img');
            $data['remark'] = I('remark');
            if($id == ''){
                $data['houses_id'] = getHouse();
                if(D('ownership_man')->add($data)){
                    $this->success('设置成功！');
                }else{
                    $this->error('设置失败！');
                }
            }else{
                $data['id'] = $id;
                if(D('ownership_man')->save($data)){
                    $this->success('设置成功！');
                }else{
                    $this->error('设置失败！');
                }
            }
            return ;
        }
        $info = D('ownership_man')->where('houses_id=' . getHouse())->find();
        $this->assign('info', $info);
        $this->display();
    }

}
