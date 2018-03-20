<?php

/**
 * 采集扩展函数
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */

/**
 * 把附件地址转换为系统可识别的数据格式
 * @param type $downfiles
 * @return type
 */
function changeDownfiles($downfiles) {
    $field = $GLOBALS['field'];
    $_POST[$field . '_filename'] = $_POST[$field . '_fileurl'] = array();
    $_POST[$field . '_filename'][] = basename($downfiles);
    $_POST[$field . '_fileurl'][] = $downfiles;
    return $downfiles;
}

/**
 * 连接多个字符串
 * @return string
 */
function concat() {
    $args = func_get_args();
    return implode("", $args);
}

/**
 * 地址补全
 * @param type $url 地址
 * @return string
 */
function urlSupplement($url) {
    $config = $GLOBALS['Collection_config'];
    $baseurl = $config['urlpage']; //采集地址
    $urlinfo = parse_url($baseurl);
    $baseurl = $urlinfo['scheme'] . '://' . $urlinfo['host'] . (substr($urlinfo['path'], -1, 1) === '/' ? substr($urlinfo['path'], 0, -1) : str_replace('\\', '/', dirname($urlinfo['path']))) . '/';
    if (strpos($url, '://') === false) {
        if ($url[0] == '/') {
            $url = $urlinfo['scheme'] . '://' . $urlinfo['host'] . $url;
        } else {
            if ($config['page_base']) {
                $url = $config['page_base'] . $url;
            } else {
                $url = $baseurl . $url;
            }
        }
    }
    return $url;
}
/**
 * 获取标题图片
 * @param type $content
 */
 function getThumb($content,$auto_thumb_no=1) {
	//自动提取缩略图，从content 中提取
	if (empty($content)) {
		if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
			return $matches[3][$auto_thumb_no];
		}
	}
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function cut($str, $par) {
	$str=strip_tags($str);
	$par=explode(',',$par);
	$start=$par[0];
	$length=$par[1];
	$charset=(empty($par[2]))?'utf-8':$par[2];
	$suffix=(empty($par[3]))?true:$par[3];
	if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
		if(false === $slice) {
			$slice = '';
		}
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}
/**
 * 替换html中对应规则的字符
 */
function replace_html($html,$par) {
	//$par=explode(',',$par);
	if(!is_array($par)){
		$reg=$par;
		$replace='';
	}else{
		$reg=$par[0];
		$replace=(empty($par[1]))?'':$par[1];
	}
	
	$regArr=array("xx"=>array($reg,'html'));
	$rs=  QueryList::Query($html,$regArr,'curl','UTF-8');

	$rs_data = $rs->jsonArr;

	$data=$rs_data[0];
	return str_replace($data,$replace,$html);
}
/**
 * 替换html中对应字符串
 */
function replace_txt($html,$par) {
	//$par=explode(',',$par);
	if(!is_array($par)){
		$str=$par;
		$replace='';
	}else{
		$str=$par[0];
		$replace=(empty($par[1]))?'':$par[1];
	}

	return str_replace($str,$replace,$html);
}
/**
 * 添加class
 */
function kindeditor_html_div($html) {
	$html='<div class="kindeditor_html_div">'.$html.'</div>';
	return $html;
}