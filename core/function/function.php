<?php
 function base_file() {
	$url = '';
	$script_name = basename($_SERVER['SCRIPT_FILENAME']);
	if (basename($_SERVER['SCRIPT_NAME']) === $script_name) {
		$url = $_SERVER['SCRIPT_NAME'];
	} elseif (basename($_SERVER['PHP_SELF']) === $script_name) {
		$url = $_SERVER['PHP_SELF'];
	} elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $script_name) {
		$url = $_SERVER['ORIG_SCRIPT_NAME'];
	} elseif (($pos = strpos($_SERVER['PHP_SELF'], '/' . $script_name)) !== false) {
		$url = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $script_name;
	} elseif (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
		$url = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
	}
	return $url;
}
function show_error($body = '') {
	if(\core\lib\Config::get('debug')) {
		exit('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Error</title></head><style type="text/css"> *{ padding: 0; margin: 0;} h1{ font-family: "Microsoft yahei"; font-size: 100px; font-weight: normal; margin-bottom: 12px; color: #333;}</style><body><div style="padding: 24px 48px;"><h1>(＞﹏＜)</h1><h1 style="font-size:42px">' . $body . '</h1></div></body></html>');
	} else {
		header('http/1.1 404 Not Found');
		exit;
	}
}
function addslashes_deep($value) {
	if (empty($value)) {
		return $value;
	} else {
		return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
	}
}
function get_file_suffix($fileName) {
	return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}
function new_html_special_chars(&$string) {
	if (!is_array($string)) return htmlspecialchars($string);
	foreach ($string as $key => $val) $string[$key] = new_html_special_chars($val);
	return $string;
}
function delete_file($file) {
	if (empty($file)) {
		return false;
	}
	if (@is_file($file)) {
		return @unlink($file);
	}
	$ret = true;
	if ($handle = @opendir($file)) {
		while ($filename = @readdir($handle)) {
			if ($filename == '.' || $filename == '..') continue;
			if (!delete_file($file . '/' . $filename)) $ret = false;
		}
	} else {
		$ret = false;
	}
	@closedir($handle);
	if (file_exists($file) && !rmdir($file)) {
		$ret = false;
	}
	return $ret;
}
function add_action($hook,$function) {
	return \core\lib\Hook::add_action($hook,$function);
}
function do_action($hook,$params=NULL) {
	return \core\lib\Hook::do_action($hook,$params);
}
function create_card() {
	return strtoupper(md5(uniqid('',TRUE).rand(rand(1,999),rand(999,99999))));
}
function create_rand_str($length = 12, $special_chars = FALSE) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ($special_chars) {
		$chars .= '!@#$%^&*()';
	}
	$rand_str = '';
	for ($i = 0; $i < $length; $i++) {
		$rand_str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $rand_str;
}
function bx_msg($title='',$text='',$state='',$type='msg') {
	return json_encode(array('title'=>$title,'text'=>$text,'state'=>$state,'type'=>$type));
}
function get_ip() {
	static $ip = null;
	if (null !== $ip) {
		return $ip;
	}
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos = array_search('unknown', $arr);
		if (false !== $pos) {
			unset($arr[$pos]);
		}
		$ip = trim(current($arr));
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = 'Unknown';
	}
	return $ip;
}
function sql_and($where) {
	$sql = '';
	for ($i=0; $i < count($where); $i++) {
		if($where[$i] == '') {
			continue;
		}
		$sql .= $where[$i] . ' and ';
	}
	return substr($sql,0,-4);
}
function bx_lists($data,$count) {
	return json_encode(array('data' => $data , 'count'=>$count));
}
?>