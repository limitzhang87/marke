<?php
namespace Addons\UploadFiles\Controller;
use Admin\Controller\AddonsController;
class UploadFilesController {
	public function zf_decrypt(){

		$data=I('data');
		$info=json_decode(trim(stripslashes($data),chr(239).chr(187).chr(191)),true);
		//$info=json_decode(stripslashes($data),true);
		//print_r(json_decode(stripslashes($data)),true);echo '<br/><br/>';print_r($info);die;
		$dedata=json_decode(think_decrypt($info['data']),true);
		$result = array_merge_recursive($info,$dedata);
		//var_dump($data);var_dump("==============");var_dump($info);var_dump("==============");var_dump($dedata);var_dump("==============");var_dump($result);
		echo json_encode($result);
}
}