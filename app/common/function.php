<?php
 function plugin_start() {
	$con = \core\lib\Db::getInstance();
	$res = $con->select('plugin','state=1','','','','directory');
	foreach ($res as $v) {
		include_once BX_ROOT . "app/common/plugin/{$v['directory']}/{$v['directory']}.php";
	}
}
function get_config($array=null) {
	$con = \core\lib\Db::getInstance();
	$res = $con->select('config',is_array($array) ? "k in ('" . join("','", $array) ."')" : '');
	foreach($res as $k => $v) {
		$new_res[$v['k']] = $v['v'];
	}
	return $new_res;
}
function set_config($array) {
	$con = \core\lib\Db::getInstance();
	foreach ($array as $key=>$value) {
		$con->update('config', array('v'=>$value),"k = '{$key}'");
	}
}
function post_id() {
	$res['id'] = isset($_POST['id']) ? $_POST['id'] : '';
	if($res['id'] == '') {
		exit(bx_msg('参数错误','参数错误','error'));
	}
	return $res['id'];
}
function post_lists() {
	$res['limit'] = isset($_POST['limit']) ? $_POST['limit'] : '';
	$res['page'] = isset($_POST['page']) ? $_POST['page'] : '';
	if( $res['limit'] == '' || $res['page'] == '') {
		exit(bx_msg('参数错误','参数错误','error'));
	}
	return $res;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
?>