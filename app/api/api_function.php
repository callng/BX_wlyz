<?php
 function rc4($pwd, $data) {
	$key[] ="";
	$box[] ="";
	$pwd_length = strlen($pwd);
	$data_length = strlen($data);
	for ($i = 0; $i < 256; $i++) {
		$key[$i] = ord($pwd[$i % $pwd_length]);
		$box[$i] = $i;
	}
	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $key[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for ($a = $j = $i = 0; $i < $data_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$k = $box[(($box[$a] + $box[$j]) % 256)];
		@$cipher .= chr(ord($data[$i]) ^ $k);
	}
	return @$cipher;
}
function api_json($code,$array="",$encrypt=true) {
	if($encrypt == true) {
		return bx_encrypt( json_encode(array( "code" => $code, "data" => $array)), API_KEY, API_ENCRYPT );
	} else {
		return json_encode(array( "code" => $code, "data" => $array ));
	}
}
function bx_encrypt($data,$key,$type) {
	switch ($type) {
		case 'authcode': return authcode($data,'',$key);
		break;
		case 'rc4': return base64_encode(rc4($key, $data));
		break;
		case 'no': return $data;
		break;
		case 'defined_encrypt': return @call_user_func_array('bx_defined_encrypt',array($data,$key));
		break;
		default: break;
	}
}
function bx_decrypt($data,$key,$type) {
	switch ($type) {
		case 'authcode': return authcode($data,'DECODE',$key);
		break;
		case 'rc4': return rc4($key,base64_decode($data));
		break;
		case 'no': return stripslashes($data);
		break;
		case 'defined_encrypt': return @call_user_func_array('bx_defined_decrypt',array($data,$key));
		break;
		default: break;
	}
}
function get_fucntion_parameter_name($func) {
	$ReflectionFunc = new \ReflectionFunction($func);
	$depend = array();
	foreach ($ReflectionFunc->getParameters() as $value) {
		$depend[] = $value->name;
	}
	return $depend;
}
function bx_verify_user($expire=FALSE,$point_min=FALSE) {
	$data = bx_decrypt($_POST['data'],API_KEY,API_ENCRYPT);
	$res = json_decode($data,TRUE);
	empty($res['username']) ? exit(api_json('1404','',true)) : FALSE;
	empty($res['password']) ? exit(api_json('1404','',true)) : FALSE;
	$con = \core\lib\Db::getInstance();
	$user_res = $con->select('user',"username='{$res['username']}' AND software_id={$_POST['id']}");
	if(!$user_res) {
		exit(api_json('1405','',true));
	}
	if(md5($res['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
		exit(api_json('1406','',true));
	}
	if($expire == TRUE) {
		if($user_res['0']['endtime'] <= time()) {
			exit(api_json('1407','',true));
		}
	}
	if($point_min != FALSE) {
		if($user_res['0']['point'] < $point_min) {
			exit(api_json('1409','',true));
		}
	}
}
function bx_verify_single_card($expire=FALSE,$point_min=FALSE) {
	$data = bx_decrypt($_POST['data'],API_KEY,API_ENCRYPT);
	$res = json_decode($data,TRUE);
	empty($res['cardnum']) ? exit(api_json('1410','',true)) : FALSE;
	$con = \core\lib\Db::getInstance();
	$card_res = $con->select('single_card',"cardnum='{$res['cardnum']}' AND software_id={$_POST['id']}");
	if(!$card_res) {
		exit(api_json('1411','',true));
	}
	if($expire == TRUE) {
		if($card_res['0']['endtime'] <= time()) {
			exit(api_json('1412','',true));
		}
	}
	if($point_min != FALSE) {
		if($card_res['0']['point'] < $point_min) {
			exit(api_json('1413','',true));
		}
	}
}
?>