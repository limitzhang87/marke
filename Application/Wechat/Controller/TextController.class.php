<?php
namespace Wechat\Controller;
use Think\Controller;

class TextController extends Controller {
    public function index(){
    	C('DB_NAME','marke');
    	dump (C('DB_NAME'));
    }

}